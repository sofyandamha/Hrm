<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttLogAndroid extends Model
{
    protected $table = 'attlog_android';
    protected $fillable = ['nik', 'id_location_office','scan_at','status','created_at','updated_at','latitude','longtitude'];
}
