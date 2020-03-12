<?php

namespace App\Http\Controllers;

use App\Date;
use App\Employee;
use Carbon\Carbon;
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

    public function addSchedule(Request $request)
    {

        $firstofthismonth =  Carbon::now()->firstOfMonth();
        $lastofthismonth =   Carbon::now()->lastOfMonth();
        $thismonth = Carbon::now()->format('m'); //angka this month
        $i = $firstofthismonth->format('d'); //1
        $y = $lastofthismonth->format('d'); //31
        $check  = Date::where('full_date',  $firstofthismonth)->get();
        if (count($check) > 0) {

        }
        else{
            for ($i;  $i<= $y ; $i++) {
                $month = '2020-'.$thismonth.'-'.$i;
                // dd($month);
                $data  = new Date();
                $data->full_date = $month;
                $data->save();
            }
        }
        $datatgl = Date::where('full_date','like','%'.$thismonth.'%')->get();
        // dd($datatgl);
        $employee = Employee::all();
        $department = Department::all();
        $workingtime = WorkingTime::all();
        return view('schedule.add', compact('employee','department','workingtime','datatgl'));
    }

    public function insertSchedule(Request $request)
    {
        $data = new log_em_stat();
        $data->id_employee = $request->employee_name;
        $data->id_department = $request->department_name;
        $data->id_work_time = $request->working_time;
        $data->is_supervisor = $request->is_supervisor;
        $data->month = $request->is_month;
        $data->save();

        return redirect()->route('show_schedule');
    }

    public function editSchedule($id)
    {
        $editSchedule = log_em_stat::find($id);
        $employee = Employee::all();
        $department = Department::all();
        $workingtime = WorkingTime::all();
        return view('schedule.update', compact('editSchedule','employee','department','workingtime'));
    }

    public function updateSchedule(Request $request)
    {
        $data = log_em_stat::find($request->id);
        $data->id_employee = $request->employee_name;
        $data->id_department = $request->department_name;
        $data->id_work_time = $request->working_time;
        $data->is_supervisor = $request->is_supervisor;
        $data->month = $request->is_month;
        $data->save();

        return redirect()->route('show_schedule');
    }

    public function deleteSchedule($id)
    {
        $data = log_em_stat::find($id);
        $data->delete();
        return redirect()->back();
    }
}
