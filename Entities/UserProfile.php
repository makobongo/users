<?php

namespace Ignite\Users\Entities;

use Carbon\Carbon;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\EmployeeCategory;
use Ignite\Evaluation\Entities\PartnerInstitution;

class UserProfile extends Model
{
    protected $table = 'users_user_profiles';

    protected $fillable = [
        'roll_no', 'title', 'first_name', 'middle_name', 'last_name',
        'employee_category_id', 'gender', 'dob', 'job_description', 'phone', 'photo', 'mpdb',
        'pin', 'id_number', 'staff_number', 'date_of_employment',
        'secondary_phone', 'secondary_email', 'work_email', 'address',
        'country', 'county', 'town', 'district', 'location', 'coverphoto', 'avatar', 'notes',
        'partner_institution', 'credit',
    ];

    protected $dates = ['date_of_employment', 'dob'];

    /**
     * cast attributes
     */
    protected $casts = [
        'clinics' => 'array',
    ];

    /**
     * append full name
     */
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        $name = mconfig('users.users.titles.' . $this->title) . ' '
                . $this->first_name . " " . $this->middle_name_name . ' ' . $this->last_name;
        return ucwords($name);
    }

    public function getNameAttribute() {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function partnerInstitution() {
        return $this->belongsTo(PartnerInstitution::class, 'partner_institution', 'id');
    }

    /**
     * a user who is an employee belongs to an employee category
     */
    public function employeeCategory()
    {
        return $this->belongsTo(EmployeeCategory::class, 'employee_category_id');
    }

    /**
     * get age
     */
    public function getAgeAttribute()
    {
        return $this->dob ? Carbon::parse($this->attributes['dob'])->age : '-';
    }

}
