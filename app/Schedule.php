<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    function class_room(){
        return $this->belongsTo(ClassRoom::class);
    }
}
