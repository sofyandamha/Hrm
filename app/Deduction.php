<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    protected $fillable = ['id','id_symbol','deduction_name','deduction_amount'];

    public function Symboll()
    {
        return $this->belongsTo('App\Symbol','id_symbol','id');
    }
}
