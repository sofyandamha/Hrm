<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;

    protected $table = 'employees';
    protected $fillable = ['id','email','password','scan_id','full_name','nik','birth_date','id_status','id_department'];
    protected $primaryKey = 'scan_id';

    public function Department()
    {
        return $this->belongsTo('App\Department','id_department','id');
    }



}
