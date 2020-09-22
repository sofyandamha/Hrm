<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use App\Employee;
use App\Schedule;
use App\Department;
use App\LeaveDetEmp;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $table = 'employees';
    protected $fillable = ['id','email','password','scan_id', 'jabatan','full_name','nik','birth_date','id_status','id_designation'];
    // protected $primaryKey = 'scan_id';

    public function Designation()
    {
        return $this->belongsTo(Designation::class,'id_designation','id');
    }

    public function Attendance()
    {
        return $this->belongsTo(Employee::class,'id_employee','scan_id');
    }

    public function Schedule(){
        return $this->hasMany(Schedule::class,'id','id_emp');

    }
    public function leavedet(){
        return $this->hasMany(LeaveDetEmp::class,'id','id_emp');

    }
}
