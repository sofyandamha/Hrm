<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use App\LngLat;
use App\Employee;
use App\Schedule;
use Carbon\Carbon;
use App\Department;
use App\ImeiDevice;
use App\LeaveDetEmp;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    protected $table = 'employees';
    protected $fillable = ['id','email','password','scan_id', 'jabatan','full_name','nik','birth_date','id_status','location_office_id','id_designation','is_supervisor','join_date'];
    // protected $primaryKey = 'scan_id';

    public function Designation()
    {
        return $this->belongsTo(Designation::class,'id_designation','id');
    }
    public function LngLat()
    {
        return $this->belongsTo(LngLat::class,'location_office_id','id');
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

    public function model_has_role(){
        return $this->hasOne(Model_has_role::class,'model_id','id');

    }

    public function ImeiDevice()
    {
        return $this->hasMany(ImeiDevice::class, 'id_employee', 'id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
