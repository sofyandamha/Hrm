<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Model_has_role extends Model
{
    protected $table = 'model_has_roles';
    protected $fillable = ['role_id','model_type','model_id'];

    public function Employee()
    {
        return $this->belongsTo('App\Employee', 'model_id', 'id');
    }
}
