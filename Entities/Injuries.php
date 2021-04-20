<?php

namespace Ignite\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class Injuries extends Model {

    protected $fillable = [];
    public $table = 'injuries';

    public function users() {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function employees() {
        return $this->belongsTo(User::class, 'employee', 'id');
    }

}
