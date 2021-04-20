<?php


namespace Ignite\Users\Http\Controllers;

use Carbon\Carbon;
use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Core\Library\Traits\UploadExcelTrait;
use Ignite\Users\Repositories\Traits\UpdateUserTrait;
use Illuminate\Http\Request;

use Ignite\Settings\Entities\Schemes;
use Ignite\Users\Repositories\MyUsers;
use Excel;
use DB;
use Ignite\Users\Entities\User;
use Ignite\Users\Entities\UserProfile;
use Log;


class UploadDocumentController extends AdminBaseController
{
    use UploadExcelTrait;
    use UpdateUserTrait;

    /**
     * @var MyUsers. Provide user_functions
     */
    private $my_users;

    /**
     * Initialize the class
     */
    public function __construct(
        MyUsers $my
    ) {
        parent::__construct();

        $this->my_users = $my;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function employees() {
        $schemes = Schemes::all();
        return view('users::uploads.employees', compact('schemes'));
    }

    /**
     * Upload a worksheet now
     */
    public function employeesStore(Request $request)
    {
        $m = "User #" . doe()->id . " (" . doe()->full_name . ") just attempted uploading excel sheet of employees";
        Log::channel('excel_uploads')->info($m);
    
        $recordsInserted = $recordsIgnored = 0;

        if($request->hasFile('file')) {
            ini_set('max_execution_time', 300);
            ini_set('memory_limit', -1);

            // so first, lets get the data and format it nicely
            $excel_data = $this->readExcelFile($request->file('file'));

            // now lets save the damn thing
            /**
             * Algorithm: Save user, then the user profile, followed by the patient data,
             * and finally the patient scheme.
             */

            if(!empty($excel_data)) {
                foreach($excel_data as $data) {
                    if($this->checkIfArrayOfNulls($data)) {
                        $recordsIgnored++;
                        continue;
                    }

                    // format the tingz first
                    $info = [
                        'title' => $data[0],
                        'first_name' => $data[1],
                        'middle_name' => $data[2],
                        'last_name' => $data[3],
                        'id_number' => $data[4],
                        'roll_no' => $data[5],
                        'gender' => $data[6],
                        'dob' => $data[7],
                        'tel' => (int)$data[8],
                        'pin' => $data[9],
                    ];

                    // begin a transaction
                    try{
                        DB::beginTransaction();
                        // create user
                        $user = $this->createUserWithProfile($info);

                        $this->activate_user($user->id);

                        // create patient data
                        $patient = $this->createPatientEmployee($user, $info, $request->get('scheme_id'));

                        $recordsInserted++;

                        DB::commit();

                    } catch(\Exception $e){
                        DB::rollback();
                        flash()->error($e->getMessage());
                        return $e->getMessage();
                    }
                }
            }
        } else {
            flash()->error('Please upload a file!');
            return redirect()->back();
        }

        flash()->success('User and Patient data saved! Records inserted: ' . $recordsInserted . ' Records ignored: ' . $recordsIgnored);
        return redirect()->back();

    }

    /**
     * Save user info
     * @param array $excel_row_data
     * @return User $user
     */
    protected function createUserWithProfile($data)
    {

        $user_data = [
            'email' => null,
            'username' => strtolower($data['first_name'] . '_' . $this->generateCode(4)),
            'password' => bcrypt($this->generateCode(4)),
        ];


        $user_profile = UserProfile::where('roll_no', (int)$data['roll_no'])->first();
        if($user_profile)
        {
            return $user_profile->user;
        }

        $user = User::create($user_data);

        // attach profile
        $profile_data = [
            'roll_no' => (int)$data['roll_no'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'middle_name' => $data['middle_name'],
            'id_number' => $data['id_number'],
            'dob' => $data['dob'],
            'phone' => $data['tel'],
            'gender' => $data['gender'],
            'job_description' => null,
            'title' => $data['title'],
            'mpdb' => null,
            'pin' => $data['pin'],
            'employee_category_id' => null,
            'is_employee' => 1, // general assumption that all users are employees in the organization
        ];

        // save profile
        $user->profile()->create($profile_data);

        return $user;
    }

    /**
     * Save patient info
     * @param User $user
     * @param array $excel_row_data
     * @param int $scheme_id
     * @return Patient $patient
     */
    public function createPatientEmployee($user, $data, $scheme_id)
    {
        if($user->patient) {
            $patient = $user->patient;
        } else {
            $patient_data = [
                'roll_no' => (int)$data['roll_no'],
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'dob' => $data['dob'],
                'sex' => $data['gender'],
                'id_no' => $data['id_number'],
                'mobile' => $data['tel'],
                'email' => null,
                'patient_no' => $this->getPatientNo(),
            ];

            $patient = $user->patient()->create($patient_data);
        }

        $insurance_data = [
            'scheme' => $scheme_id,
            'policy_number' => null,
            'principal' => null,
            'dob' => $data['dob'],
            'relationship' => null,
        ];
        $patient->schemes()->create($insurance_data);

        return $patient;
    }

    public function generateCode($length)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    /**
     * Upload dependants view.
     *
     * @return Response
     */
    public function dependants() {
        return view('users::uploads.dependants');
    }

    /**
     * Save dependants to DB
     *
     * @param Request $request
     */
    public function dependantsStore(Request $request)
    {
        $recordsInserted = $recordsIgnored = 0;

        if($request->hasFile('file')) {
            ini_set('max_execution_time', 300);
            ini_set('memory_limit', -1);

            // so first, lets get the data and format it nicely
            $excel_data = $this->readExcelFile($request->file('file'));

            // now lets save the damn thing
            /**
             * Algorithm: Save dependant, then make a new dependant patient record,
             * and finally give the dependant the parent's schemes.
             */

            if(!empty($excel_data)) {
                foreach($excel_data as $data) {
                    if($this->checkIfArrayOfNulls($data)) {
                        $recordsIgnored++;
                        continue;
                    }

                    $roll_no = $data[0];
                    $first_name = $data[1];
                    $middle_name = $data[2];
                    $last_name = $data[3];
                    $dob = $data[4];
                    $gender = $data[5];
                    $relationship = $data[6];
                    $mobile = $data[7];

                    // begin a transaction
                    try{
                        DB::beginTransaction();

                        $user = User::whereHas('profile', function($q) use ($roll_no) {
                            $q->where('roll_no', $roll_no);
                        })->first();

                        if($user)
                        {
                            $data = [
                                'employee_id' => $user->id,
                                'roll_no' => $roll_no,
                                'first_name' => $first_name,
                                'middle_name' => $middle_name,
                                'last_name' => $last_name,
                                'mobile' => $mobile,
                                'gender' => $gender,
                                'dob' => Carbon::parse($dob),
                                'relationship' => $relationship,
                            ];

                            $dependant = $user->dependants()->create($data);

                            // save patient data
                            $patient_data = [
                                'first_name' => ucfirst($dependant->first_name),
                                'middle_name' => ucfirst($dependant->middle_name),
                                'last_name' => ucfirst($dependant->last_name),
                                'dob' => $dependant->dob,
                                'sex' => $dependant->gender,
                                'mobile' => $dependant->mobile,
                                'image' => $dependant->image,
                                'roll_no' => $roll_no,
                                'patient_no' => $this->getPatientNo(),
                            ];

                            $dependantPatientRecord = $this->createDependantPatientRecord($dependant, $patient_data);

                            $this->inheritPrincipalInsuranceScheme($dependant);
                        }

                        $recordsInserted++;

                        DB::commit();

                    } catch(\Exception $e){
                        DB::rollback();
                        flash()->error($e->getMessage());
                        return $e->getMessage();
                    }
                }
            }
        } else {
            flash()->error('Please upload a file!');
            return redirect()->back();
        }

        flash()->success('Dependants saved! Records inserted: ' . $recordsInserted . ' Records ignored: ' . $recordsIgnored);
        return redirect()->back();

    }

}
