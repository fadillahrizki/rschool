<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    protected $guarded = [];

    function student(){
        return $this->belongsTo(Student::class);
    }
}
