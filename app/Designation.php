<?php

namespace App;

use App\Department;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class,'idDepartment','id');
    }
}
