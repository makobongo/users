<?php

namespace Ignite\Users\Library;

use Ignite\Users\Repositories\MyUsers;
use Ignite\Users\Repositories\UserRepository;
use Ignite\Users\Repositories\EmployeeCategoryRepository;

class UsersFunctions
{
    /**
    * @var UserRepository
    */
    private $userRepo;

    /**
    * @var PatientRepository
    */
    private $patientRepo;

    /**
    * @var PatientInsuranceRepository
    */
    private $patientInsuranceRepo;

    /**
    * @var EmployeeCategoryRepository
    */
    private $employeeCategoryRepo;

    /**
    * Jump start the class
    */
    public function __construct(
        UserRepository $userRepo,
        EmployeeCategoryRepository $employeeCategoryRepo
    )
    {
        $this->userRepo = $userRepo;
        $this->employeeCategoryRepo = $employeeCategoryRepo;
    }

    /**
    * Save a new record of employee into the patient records, since all employees here
    * are also patients (or sth of that kind)
    * @param array $employee_patient_data
    * @return $patient_record
    */
    public function saveEmployeePatient($employee_patient_data)
    {
        return $this->patientRepo->create($employee_patient_data);
    }

    /**
     * Save a new record of employee into the patient records, since all employees here
     * are also patients (or sth of that kind)
     *
     * @param $data
     *
     * @return  $patient_record
     */
    public function savePatientInsurance($data)
    {
        return $this->patientInsuranceRepo->create($data);
    }

    /**
     * Get all employee catgeories
     */
    public function allEmployeeCategories()
    {
        return $this->employeeCategoryRepo->all();
    }

}
