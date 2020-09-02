<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    protected $table = 'studies';
    public function student()
    {
        return $this->hasOne('App\Student','id','student_id');
    }
    public function Class()
    {
        return $this->hasOne('App\Classes','id','class_id');
    }
}
