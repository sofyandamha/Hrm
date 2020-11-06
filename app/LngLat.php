<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LngLat extends Model
{
    protected $table = 'location_office';
    protected $fillable = ['id','nama_lokasi','longtitude','latitude'];
}
