<?php

namespace Ignite\Users\Http\Controllers;

use Carbon\Carbon;
use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Reception\Repositories\PatientRepository;
use Ignite\Users\Http\Requests\CreateDependantRequest;
use Ignite\Users\Repositories\DependantRepository;
use Ignite\Users\Repositories\MyUsers;
use Ignite\Users\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;

class DependantController extends AdminBaseController
{
    /**
     * @var UserRepository
     */
    private $user;

    /**
     * @var DependantRepository
     */
    private $dependantRepo;

    /**
     * @var MyUsers. Provide user_functions
     */
    private $my_users;

    /**
     * @var PatientRepository.
     */
    private $patientRepo;

    /**
     * Constructor
     *
     * @param UserRepository $user
     * @param DependantRepository $dependantRepo
     * @param MyUsers $my
     * @param PatientRepository $patientRepo
     */
    public function __construct(
        UserRepository $user,
        DependantRepository $dependantRepo,
        MyUsers $my,
        PatientRepository $patientRepo
    )
    {
        parent::__construct();

        $this->user = $user;
        $this->dependantRepo = $dependantRepo;
        $this->my_users = $my;
        $this->patientRepo = $patientRepo;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $user = $this->user->find($request->user_id);
        $dependants = $this->dependantRepo->allWithBuilder()->where('employee_id', $request->user_id)->get();
        $dependant = $this->dependantRepo->find($request->id);
        return view('users::dependants.index', compact('dependant', 'dependants', 'user'));
    }

    /**
     * add a users dependants
     *
     * @param $user_id
     * @param CreateDependantRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($user_id, CreateDependantRequest $request)
    {
        $user = $this->user->find($user_id);
        $dependant = $this->saveDependant($request);
        if (is_string($dependant)) {
            flash()->error($dependant);
            return redirect()->back();
        }
        else if ($dependant) {
            flash()->success('The dependant has been added successfully');
            return redirect()->back();
        }
        flash()->error('An error occurred. Please try again.');
        return redirect()->back();
    }

    /**
     * Save dependant for the employee.
     * @param Request $request
     * @return string | Dependant
     */
    public function saveDependant($request)
    {
        $data = [
            'employee_id' => $request->user_id,
            'first_name' => ucfirst($request->dependant['first_name']),
            'middle_name' => ucfirst($request->dependant['middle_name']),
            'last_name' => ucfirst($request->dependant['last_name']),
            'mobile' => $request->dependant['mobile'],
            'gender' => $request->dependant['gender'],
            'dob' => $request->dependant['dob'],
            'relationship' => $request->dependant['relationship'],
        ];

        // check to see whether dependant is above 18 yrs
        $no_of_years = Carbon::parse($request->dp_dob)->diff(Carbon::now());
        if ($no_of_years->y >= m_setting('users.max_age_of_dependant'))
        {
            // allow only spouses
            if (strtolower($request->dependant['relationship']) != 'spouse') {
                return 'Dependant not eligible to be covered under Wilson Cover.';
            }
        }

        if ($request->update_photo) {
            $data = array_merge($data, [
                'image' => $request->imagesrc
            ]);
        }

        // begin a transaction
        try{
            DB::beginTransaction();

            if (isset($request->dependant_id)) {
                $d = $this->dependantRepo->allWithBuilder()->findOrNew($request->dependant_id);
                $d->update($data);
            } else {
                $d = $this->dependantRepo->create($data);
            }

            // creates a new patient record for dependant
            if (! $request->dependant_id) {
                $patient_data = [
                    'first_name' => ucfirst($request->dp_first_name),
                    'middle_name' => ucfirst($request->dp_middle_name),
                    'last_name' => ucfirst($request->dp_last_name),
                    'dob' => new \Date($request->dp_dob),
                    'sex' => $request->dp_gender,
                    'mobile' => $request->dp_mobile,
                    'dependant_id' => $d->id,
                ];
                if($request->update_photo) {
                    $patient_data = array_merge($patient_data, [
                        'image' => $request->imagesrc
                    ]);
                }
                $patient = $this->my_users->saveEmployeePatient($patient_data);
            }

            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            return false;
        }

        if($this->inheritPrincipalInsuranceScheme($request, $d))
        {
            flash()->success('Dependant added and schemes attached.');
            return $d;
        }
        flash()->success('Dependant added.'); // some schemes could have been left out mate.
        return $d;
    }

    /**
     * @param $createDependantRequest - request object containing details of
     * principal and dependant
     * @param Dependant $saved_dependant
     * @return bool
     */
    private function inheritPrincipalInsuranceScheme($createDependantRequest, $dependant)
    {
        $patient =$this->patientRepo->allWithBuilder()->where('employee_id', '=', $createDependantRequest->employee_id)->first();
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
                    'relationship' => $createDependantRequest->dp_relationship, // now this is appropriate, since only one recordis tored per request
                ];

                // leverage the power of repo
                $patient_insurance = $this->my_users->savePatientInsurance($insurance_data);
            }
            return true;
        }
        return false;
    }

    /**
     * Delete the record of a dependant. Remember, a dependant is attached to patient record, scheme
     * @param int $id
     * @return response
     */
    public function destroy(Request $request)
    {
        $dependant = $this->dependantRepo->find($request->id);
        // data associated with dependant will be deleted in the boot method of the model
        $dependant->delete();
        flash('Dependant has been deleted');
        return redirect()->back();
    }

}
