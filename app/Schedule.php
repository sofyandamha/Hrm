<?php

namespace App;

use App\Employee;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['id_emp','date_work','in_time', 'out_time'];

    public function Employee(){
        return $this->belongsTo(Employee::class,'id_emp','scan_id');

    }
}
