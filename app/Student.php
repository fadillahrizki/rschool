<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    function class_room(){
        return $this->belongsTo(ClassRoom::class);
    }

    function absents(){
        return $this->hasMany(Absent::class);
    }
}
