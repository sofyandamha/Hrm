<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImeiDevice extends Model
{
    protected $fillable = ['id', 'id_employee', 'imei'];

    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'id', 'id_employee');
    }
}
