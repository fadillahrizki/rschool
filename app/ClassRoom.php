<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $guarded = [];

    function students(){
        return $this->hasMany(Student::class);
    }
    
    function schedules(){
        return $this->hasMany(Schedule::class);
    }
}
