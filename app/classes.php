<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';

    public function staff()
    {
        return $this->hasOne('App\Staff','id','staff_id');
    }
    public function book()
    {
        return $this->hasOne('App\Book','id','book_id');
    }
    public function room()
    {
        return $this->hasOne('App\Room','id','room_id');
    }
    public function studies()
    {
        return $this->hasMany('App\Study','class_id','id');
    }
}
