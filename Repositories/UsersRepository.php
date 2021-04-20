<?php

namespace Ignite\Users\Repositories;

use Exception;
use Ignite\Core\Repositories\EloquentBaseRepository;
use Ignite\Reception\Entities\Patients;
use Ignite\Users\Entities\Role;
use Ignite\Users\Entities\User;
use Ignite\Users\Http\Filters\UserFilter;
use Ignite\Users\Repositories\Traits\UpdateUserTrait;
use Ignite\Users\Transformers\UserResource;
use Ignite\Users\Transformers\UserResourceCollection;
use Illuminate\Support\Facades\DB;

class UsersRepository
{
    use UpdateUserTrait;

    protected $model;

    /**
    * Constructor
    *
    */
    public function __construct()
    {
        $this->model = new User;
    }
    
    /**
     * return users
     */
    public function get($pagination = 'm')
    {
        $users = $this->model->latest();
        
        return request('no_pagination') ? new UserResourceCollection($users->get()) : new UserResourceCollection($users->paginate(core_paginate($pagination)));
    }

    /*
     * Get a list of all the users in the system
     */
    public function all()
    {
        $filter = new UserFilter;
        $users = $filter->sieve($this->model)->get();

        return $users;
    }

    public function filterByRole ()
    {
        $users = $this->model->whereHas('roles', function ($role) {
            $role->where('name', 'LIKE', '%'. request('role') . '%');
        })->get();

        return  UserResource::collection($users);
    }
    
    /**
     * search user
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search()
    {
        $users = $this->model;
        
        $search = request('term') ?? request('search');
    
        if($search)
            $users = $users
                ->whereHas('profile', function($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('middle_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%");
                });
                
        
        if(request('roles') || request('roles_like'))
        {
            $roles = explode(',', request('roles') ?? request('roles_like'));
            
            if(request('roles'))
                $roleList = Role::whereIn('name', $roles)->pluck('name');
            
            else
            {
                $roleList = Role::where(function($q) use ($roles) {
                    foreach($roles as $role){
                        $q->orWhere('name', 'LIKE', "%$role%");
                    }
                })->pluck('name');
            }
    
            $users = $users->whereHas('roles', function($q) use ($roleList) {
                $q->whereIn('name', $roleList);
            });
        }
        
        return UserResource::collection($users->get());
    }

    /*
     * Get a list of all the users in the system
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /*
     * Create a user
     * Create user - Create Profile - Attach Role - Activate account
     */
    public function create()
    {
        if(mconfig('users.config.max_users')) {
            $max = mconfig('users.config.max_users');
            if(User::count() > $max) {
                abort(504, trans('app.max.users'));
            }
        }
        
        $user = request("basic");

        $profile = request("profile");
        
        try {
            DB::beginTransaction();
    
            $user["password"] = bcrypt($user["password"]);
    
            $user = $this->model->create($user);
    
            $profile["user_id"] = $user->id;
    
            $user->profile()->create($profile);
    
            $user->attachRoles(request("roles"));
    
            if(request()->has("clinics"))
            {
                $user->clinics()->sync(request("clinics"));
            }
    
            $this->updateUserStatus($user->id, 1);
    
            if(m_setting('users.enable_check_roll_number'))
            {
                // TODO: create a patient record. Add a checkbox later -> time constraint
                $this->createEmployeePatientRecord($user);
            }
            
            DB::commit();
        } catch (Exception $e)
        {
            DB::rollBack();
            
            env('APP_DEBUG') ? dde($e->getMessage()) : null;
            
            return false;
        }

        return $user;
    }

    /*
     * Get a paginated version of the main uses table
     */
    public function paginate()
    {
        return $this->model->paginate(core_paginate('m'));
    }

    /*
     * Generates a random activation code
     */
    public function generateCode($length)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    /**
     * Saves a new patient model to database. Updates patient if ID parameter supplied
     * @param User $user
     * @return Patients
     */
    public function createEmployeePatientRecord(User $user)
    {
        $data = [
            'roll_no' => $user->profile->roll_no,
            'first_name' => $user->profile->first_name,
            'middle_name' => $user->profile->middle_name,
            'last_name' => $user->profile->last_name,
            'dob' => new \Date($user->profile->dob),
            'sex' => $user->profile->gender,
            'id_no' => $user->profile->id_number,
            'mobile' => $user->profile->mobile,
            'email' => $user->email,
            'patient_no' => $this->getPatientNo()
        ];

        // save patient details. May also include insurance data.
        return $user->patient()->create($data);
    }

    /**
     * @param array|string $role
     *
     * @return mixed
     */
    public function getUsersByRole($role)
    {
        if (! is_array($role)) {
            $role = [$role];
        }

        return $this->model->whereHas('roles', function($q) use ($role) {
                $q->whereIn('name', $role);
            })
            ->get();
    }
}
