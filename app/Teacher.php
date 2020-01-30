<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = [];

    function schedules(){
        return $this->hasMany(Schedule::class);
    }
}
