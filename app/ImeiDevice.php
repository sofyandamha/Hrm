<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImeiDevice extends Model
{
    protected $fillable = ['id', 'id_employee', 'imei' ,'device', 'status'];

    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'id', 'id_employee');
    }

    public function Employee2(){
        return $this->hasOne(Employee::class,'id','id_employee');
    }
}
