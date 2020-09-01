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
}
