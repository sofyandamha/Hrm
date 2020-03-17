<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave_managament extends Model
{
    protected $fillable = ['id_employee','id_leave_type','start_leave','end_leave','remak','status','created_by','updated_by'];

    public function Employee()
    {
        return $this->belongsTo('App\Employee', 'id_employee', 'id');
    }

    public function Leave_type()
    {
        return $this->belongsTo('App\Leave_type', 'id_leave_type', 'id');
    }

}
