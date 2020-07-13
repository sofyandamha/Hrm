<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $table = 'date';
    protected $fillable = ['full_date'];

}
