<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    protected $fillable = ['id','allowance_name','allowance_amount','id_symbol'];

    public function Symboll()
    {
        return $this->belongsTo('App\Symbol', 'id_symbol', 'id');
    }
}
