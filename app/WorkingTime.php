<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingTime extends Model
{
    protected $fillable = ['id','in_time','out_time','workingTime_name'];
}
