<?php

namespace Ignite\Users\Entities;

use Ignite\Reception\Entities\Patients;
use Illuminate\Database\Eloquent\Model;
use Ignite\Users\Entities\User;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as OwenAuditable;

class Dependants extends Model implements Auditable
{
    use OwenAuditable;

    public $table = "users_dependants";

    protected $fillable = [
        "employee_id", "first_name", "middle_name", "last_name", "gender", "relationship", "dob", "mobile", 'image',
    ];

    /**
     * mutatable dates
     */
    protected $dates = [
        "dob"
    ];

    protected static function boot()
    {
    	parent::boot();

    	static::deleting(function($dependant) {
    		// $dependant->patient->schemes->delete(); // this action deletes even the schemes for parents. BEWARE!
    		// $dependant->patient()->delete(); // does the patient data go too when deleting?
    	});
    }

    /*
     * Accessor to retrieve the dependants full name
     */
    public function getFullNameAttribute($value)
    {
        return $this->attributes["first_name"] . " " . $this->attributes["middle_name"] . " " . $this->attributes["last_name"];
    }

    /**
     * A dependant has one patient record
     */
    public function patient(){
        return $this->hasOne(Patients::class, "dependant_id");
    }

    /**
     * get the user employee to which the dependant belongs to. 
     * Can only belong to one!
     */
    public function user()
    {
        return $this->belongsTo(User::class, "employee_id");
    }

    /**
     * get the user employee to which the dependant belongs to. 
     * Can only belong to one!
     */
    public function employee()
    {
    	return $this->user();
    }

    /**
     * get dependant"s age
     * @return int $age in years
     */
    public function getAgeAttribute()
    {
        $now = Carbon::now();
        $age_diff = $now->diff($this->dob);
        return $age_diff->y;
    }

    /**
     * determine whether a patient is eligible for treatment under cover
     *
     * @return bool
     */
    public function getIsEligibleAttribute()
    {
        if(str_contains(strtolower($this->relationship), 'spouse'))
            return true;

        return $this->age <= m_setting('users.max_age_of_dependant');
    }

}
