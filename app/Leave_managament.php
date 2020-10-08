<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave_managament extends Model
{
    protected $table = 'leave_det_emp';
   protected $guarded =[];
    public function Employee()
    {
        return $this->belongsTo('App\Employee', 'id_employee', 'id');
    }

    public function Leave_type()
    {
        return $this->belongsTo('App\Leave_type', 'id_leave_type', 'id');
    }

}
