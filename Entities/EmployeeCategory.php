<?php

namespace Ignite\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\UserProfile;

class EmployeeCategory extends Model
{
	/**
	 * specify table
	 */
	protected $table = 'users_employee_categories';

	/**
	 * mass assignable attributes
	 */
    protected $fillable = ["name","description"];

    /**
     * can have more than one employee under it
     */
    public function employees()
    {
    	return $this->hasMany(UserProfile::class, 'employee_category_id');
    }
}
