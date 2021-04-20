<?php


namespace Ignite\Users\Entities;


use Illuminate\Database\Eloquent\Model;

class UserUploads extends Model
{
    protected $table = 'uploaded_files';
    protected $dates = ['uploaded_at'];
    public $timestamps = false;

    public function last(){
        return $this->orderBy('id','desc')->first();
    }
}