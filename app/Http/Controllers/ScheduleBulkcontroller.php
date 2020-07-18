<?php

namespace App\Http\Controllers;

use App\ScheduleBulk;
use Illuminate\Http\Request;

class ScheduleBulkcontroller extends Controller
{
    public function importyeah()
    {
        return ScheduleBulk::all();
    }
}
