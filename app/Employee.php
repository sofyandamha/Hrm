<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['id','scan_id','full_name','nik','birth_date','id_status','id_department'];

    public function Department()
    {
        return $this->belongsTo('App\Department', 'id_department', 'id');
    }

}
