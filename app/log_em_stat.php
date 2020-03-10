<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log_em_stat extends Model
{
    protected $fillable = ['id','id_employee','id_department','id_status','id_work_time','end_work','in_work','is_active','full_name'];

    public function Employee()
    {
        return $this->belongsTo('App\Employee','id_employee','id');
    }

    public function Department()
    {
        return $this->belongsTo('App\Department','id_department','id');
    }

    public function Workingtime()
    {
        return $this->belongsTo('App\WorkingTime','id_work_time','id');
    }

    public function Status()
    {
        return $this->belongsTo('App\Status','id_status','id');
    }
}
