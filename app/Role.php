<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['id','name'];

    public function Employee()
    {
        return $this->belongsTo(Model_has_role::class, 'id', 'role_id');
    }
}
