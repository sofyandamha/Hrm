<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax_setup extends Model
{
    protected $fillable = ['id','tax_rule','tax_rate','id_symbol'];

    public function Symboll()
    {
        return $this->belongsTo('App\Symbol','id_symbol','id');
    }
}
