<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function sub_study()
    {
        return $this->hasOne('App\Study','id','study_id');
    }
}
