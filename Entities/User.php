<?php

namespace Ignite\Users\Entities;

use Ignite\Evaluation\Entities\InvestigationResult;
use Ignite\Evaluation\Entities\Investigations;
use Ignite\Evaluation\Entities\Prescriptions;
use Ignite\Hr\Entities\Employee;
use Ignite\Hr\Library\Traits\HrUserTrait;
use Ignite\Hr\Library\Traits\PayrollTrait;
use Ignite\Inventory\Entities\ApprovalLevels;
use Ignite\Settings\Entities\Clinics;
use Ignite\Users\Entities\Role;
use Ignite\Users\Entities\Dependants;
use Illuminate\Notifications\Notifiable;
use Ignite\Reception\Entities\Patients;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as OwenAuditable;
use Illuminate\Support\Facades\Config;

class User extends Authenticatable implements Auditable
{
    use Notifiable, LaratrustUserTrait, OwenAuditable, HrUserTrait, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
        'is_employee', 'department_id', 'employment_type_id', 'active', 'last_login', 'last_login_ip', 'device_id',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * append profile
     */
    protected $with = [
        'profile',
    ];

    /**
     * cast attributes
     */
    protected $casts = [
        'enforce_password_reset' => 'boolean',
    ];

    /**
     * mutatable dates
     *
     * @var array
     */
    protected $dates = ['last_login', 'email_verified_at'];
    
    /**
     * append
     * @var array
     */
    protected $appends = [
        'full_name'
    ];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getGravatorAttribute() {
        return gravatar($this->email);
    }
    
    public function getFullNameAttribute()
    {
        return $this->profile ? $this->profile->full_name : $this->username;
    }

    /**
     * a user can have only one profile
     */
    public function profile() {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    /**
     * user can have many dependants
     */
    public function dependants() {
        return $this->hasMany(Dependants::class, 'employee_id');
    }

    /**
     * a user/employee cna have more than one chit
     */
    public function chits()
    {
        return $this->hasMany(Chit::class, 'employee_id', 'id');
    }

    /**
     * a user can allocate more than one chit to an employee
     */
    public function chitsAuthorized()
    {
        return $this->hasMany(Chit::class, 'user_id', 'id');
    }

    /*
     * Activation relationship
     */
    public function activation()
    {
        return $this->hasOne(Activation::class, 'user_id');
    }

    /**
     * relationship between users and patients.
     * a user can have only one patient record
     */
    public function patient()
    {
        return $this->hasOne(Patients::class, 'employee_id');
    }

    /**
     * Get active users
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /*
     * Relationship between the user and investigation results - table evaluation_investigation_results
     */
    public function diagnoses()
    {
        return $this->hasMany(InvestigationResult::class, "user");
    }

    /*
     * get procedures ordered by this doc
     */
    public function investigations() {
        return $this->hasMany(Investigations::class, 'user');
    }

    /*
     * get prescriptions by this doc
     */
    public function prescriptions() {
        return $this->hasMany(Prescriptions::class, 'user');
    }

    /**
     * a clinic has many users and a user can belong to more than one clinic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clinics()
    {
        return $this->belongsToMany(Clinics::class, 'clinic_user', 'user_id', 'clinic_id');
    }

    /**
     * override allPermissions
     */
    public function allPermissions()
    {
        $roles = $this->roles()->with('permissions')->get();

        $roles = $roles->flatMap(function($role) {
            return $role->permissions;
        });

        return $this->permissions()->get()->merge($roles)->unique('name');
    }

    public function approvalLevels ()
    {
        return $this->belongsToMany(ApprovalLevels::class,'inventory_approval_level_details',  'user_id', 'approval_level_id');
    }
    
    
    /*
     * check if user is sudo
     */
    public function getIsSudoAttribute()
    {
        return $this->hasRole('sudo');
    }
    
    /*
     * check if user is an admin
     */
    public function getIsAdminAttribute()
    {
        return $this->hasRole('sudo') || $this->hasRole('admin');
    }
}
