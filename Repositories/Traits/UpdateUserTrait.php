<?php

namespace Ignite\Users\Repositories\Traits;

use Carbon\Carbon;
use Ignite\Reception\Entities\Patients;
use Ignite\Settings\Entities\Clinics;
use DB;
use Ignite\Users\Entities\Dependants;
use Ignite\Users\Entities\User;
use Illuminate\Support\Facades\Storage;

trait UpdateUserTrait
{
    /*
     * Update user details
     */
    public function update($userId)
    {
        $user = $this->find($userId);

        if(request()->has("roles"))
        {
            $user->syncRoles(request("roles"));
        }

        if(request()->has("profile"))
        {
            $profile = array_filter(request("profile"));

            array_key_exists('title', $profile) ?: $profile['title']  = 0;

            $user->profile()->update($profile);
        }

        if(request()->has("user"))
        {
            $fields = array_filter(request("user"));
            $userData = collect();

            if(isset($fields["password"]))
            {
                $userData->put('password', bcrypt($fields["password"]));
            }

            if(isset($fields['confirm_username'])) {
                $userData->put('username', $fields['username']);
            }

            if(isset($fields['confirm_email'])) {
                $userData->put('email', $fields['email']);
            }

            $user->update($userData->toArray());
        }

        if(request()->has("clinics"))
        {
            $user->clinics()->sync(request("clinics"));
        }

        if(request()->has("permission"))
        {
            $permission = request("permission");

            $user->hasPermission($permission) ? $user->detachPermission($permission) : $user->attachPermission($permission);
        }

        if(request()->has("dependant"))
        {
            $dependant = request("dependant");

            $this->saveDependant(request(), $user);
        }

        if(request()->has('signature'))
        {
            $upload = request()->file('signature');
            $filename =  md5(str_random(20)) . '.' . $upload->getClientOriginalExtension();

            Storage::disk('signatures')->putFileAs('/', $upload, $filename);

            $file = Storage::disk('signatures')->get($filename);
            $type = pathinfo(config('filesystems.disks.signatures.root') . '/' . $filename, PATHINFO_EXTENSION);
            $base64 = base64_encode($file);

            $image = 'data:image/' . $type . ';base64, ' . $base64;

            $user->signature = $image;
            if($user->save())
                Storage::disk('signatures')->delete($filename);
        }

        return $user;
    }

    /**
     * Save dependant for the employee.
     * @param Request $request
     * @return string | Dependant
     */
    public function saveDependant($request, $user)
    {
        $data = [
            'first_name' => ucfirst($request->dependant['first_name']),
            'middle_name' => ucfirst($request->dependant['middle_name']),
            'last_name' => ucfirst($request->dependant['last_name']),
            'mobile' => $request->dependant['mobile'],
            'gender' => $request->dependant['gender'],
            'dob' => Carbon::parse($request->dependant['dob']),
            'relationship' => $request->dependant['relationship'],
        ];

        if ($request->update_photo) {
            $data = array_merge($data, [
                'image' => $request->imagesrc
            ]);
        }


        // begin a transaction
        try{
            DB::beginTransaction();

            $dependant = $user->dependants()->create($data);

            // creates a new patient record for dependant
            $patient_data = [
                'first_name' => ucfirst($dependant->first_name),
                'middle_name' => ucfirst($dependant->middle_name),
                'last_name' => ucfirst($dependant->last_name),
                'dob' => $dependant->dob,
                'sex' => $dependant->gender,
                'mobile' => $dependant->mobile,
                'image' => $dependant->image,
                'roll_no' => $user->roll_no,
            ];

            $dependantPatientRecord = $this->createDependantPatientRecord($dependant, $patient_data);

            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            dd($e->getMessage());
            return false;
        }

        if($this->inheritPrincipalInsuranceScheme($dependant))
        {
            flash()->success('Dependant added and schemes attached.');
            return $dependant;
        }

        flash()->success('Dependant added.'); // some schemes could have been left out mate.
        return $dependant;
    }

    /**
     * @param Dependants $dependant
     * @param $patient_data
     *
     * @return mixed
     */
    public function createDependantPatientRecord($dependant, $patient_data)
    {
        return $dependant->patient()->create($patient_data);

    }

    /**
     * @param Dependant $saved_dependant
     * @return bool
     */
    public function inheritPrincipalInsuranceScheme($dependant)
    {
        $patient = Patients::where('employee_id', '=', $dependant->employee_id)->first(); // the parent for the dependant

        if ($patient) {
            // now feed schemes. Dependants inherit schemes of their parents
            $patientInsuranceSchemes = $patient->schemes;

            // get dependant patient record
            $dependantPatientRecord = $dependant->patient;

            //create dependant schemes here
            foreach ($patientInsuranceSchemes as $currentScheme) {
                $insurance_data = [
                    'patient' => $dependantPatientRecord->id,
                    'scheme' => $currentScheme->scheme,
                    'policy_number' => $currentScheme->policy_number,
                    'principal' => $currentScheme->principal,
                    'dob' => $currentScheme->principal_dob,
                    'relationship' => $dependant->relationship, // now this is appropriate, since only one recordis tored per request
                ];

                // attach scheme to dependant
                $dependantPatientRecord->schemes()->create($insurance_data);
            }
            return true;
        }
        return false;
    }

    /**
     * Get the last patient_no and return the next number
     *
     * @return int
     */
    public function getPatientNo()
    {
        return Patients::select(['patient_no'])->get()->max('patient_no') + 1;
    }

    /**
     * update the status of a user
     *
     * @param int $id
     * @param int $status
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function updateUserStatus($id, $status)
    {
        $user = User::findOrFail($id);

        $dependants = Dependants::where('employee_id', $id)->get();

        if($status == 1) {
            $user->active = true;
        } else {
            $user->active = false;
        }

        $user->save();

        // Deactivate patient
        try {
            $patient = Patients::updateOrCreate(['employee_id' => $id], ['status' => $status]);
        } catch (\Exception $e) {
        }

        // Deactivate Dependants
        if(m_setting('users.enable_dependants'))
        {
            try {
                foreach ($dependants as $d) {
                    $patient_data = Patients::updateOrCreate(['dependant_id' => $d->id], ['status' => $status]);
                }
            } catch (\Exception $e) {
            }
        }

        return $user;
    }

    /**
     * Hard reset a user's password to 12345678
     * Good for excel uploaded users whose passwords are autogenerated
     *
     * @param bool $all
     * @param null|int $id
     *
     * @return int
     */
    public function hardResetUserPassword($all = false, $id = null)
    {
        $count = 0;

        if($all) {
            $items = User::all();
            foreach($items as $item) {
                $item->password = bcrypt('12345678');
                $item->enforce_password_reset = true;
                $item->save();

                $count++;
            }
        } else {
            $item = User::findOrFail($id);
            $item->password = bcrypt('12345678');
            $item->enforce_password_reset = true;
            $item->save();

            $count++;
        }

        return $count;
    }

}
