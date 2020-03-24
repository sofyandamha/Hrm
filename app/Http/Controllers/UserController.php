<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($id)
    {
        $employee = Employee::find($id);
        return view('dashboard.profile',compact('employee'));
    }
}
