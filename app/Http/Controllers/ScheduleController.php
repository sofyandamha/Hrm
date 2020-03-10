<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Department;
use App\log_em_stat;
use App\WorkingTime;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $data = log_em_stat::orderBy('id_employee', 'asc');
        // if ($request->r) {
        //     $data->where('id_employee','like', '%'.$request->r.'%')
        //          ->orWhere('id_department','like', '%'.$request->r.'%');
        // }
        if ($request->r) {
            $data->WhereHas('Employee', function ($query) use ($request) {
                    $query->Where('full_name', 'like', '%' . $request->r . '%');
                })
                ->orWhereHas('Department', function ($query) use ($request) {
                    $query->Where('name', 'like', '%' . $request->r . '%');
                });

        }
        if ($request->has('page') ? $request->get('page') : 1) {
            $page    = $request->has('page') ? $request->get('page') : 1;
            $total   = $data->count();
            $perPage = 10;
            $showingTotal  = $page * $perPage;

            $currentShowing = $showingTotal > $total ? $total : $showingTotal;
            $showingStarted = $showingTotal - $perPage;
            $tableinfo = "Showing $showingStarted to $currentShowing of $total entries";
        }

        $data = $data->paginate($perPage);
        $data->appends($request->all());

        return view('schedule.index', compact('data','tableinfo','perPage','page'));
    }

    public function addSchedule()
    {
        $employee = Employee::all();
        $department = Department::all();
        $workingtime = WorkingTime::all();
        return view('schedule.add', compact('employee','department','workingtime'));
    }

    public function insertSchedule(Request $request)
    {
        $data = new log_em_stat();
        $data->id_employee = $request->employee_name;
        $data->id_department = $request->department_name;
        $data->id_work_time = $request->working_time;
        $data->is_supervisor = $request->is_supervisor;
        $data->save();

        return redirect()->route('show_schedule');
    }
}
