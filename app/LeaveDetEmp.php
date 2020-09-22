<?php

namespace App;

use App\Employee;
use App\Leave_type;
use Illuminate\Database\Eloquent\Model;

class LeaveDetEmp extends Model
{
    protected $table = 'leave_det_emp';
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'id_emp','id');
    }
    public function leavetype()
    {
        return $this->belongsTo(Leave_type::class,'id_leave_type','id');
    }
}
