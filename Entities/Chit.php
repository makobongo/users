<?php

namespace Ignite\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class Chit extends Model
{
    protected $guarded = ['id'];

    protected $table = 'employee_chits';

    /**
     * user executing the action
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * the employee to which the chit belongs to
     */
    public function employee() {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

    /**
     * get duration attr
     */
    public function getDurationFriendlyAttribute()
    {
        return $this->duration . ' ' . str_plural($this->time_measure, $this->duration);
    }

}
