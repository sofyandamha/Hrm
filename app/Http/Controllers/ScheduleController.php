<?php

namespace App\Http\Controllers;

use App\Date;
use App\Employee;
use App\Schedule;
use Carbon\Carbon;
use App\Department;
use App\log_em_stat;
use App\WorkingTime;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ScheduleController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        
        
        // $period = CarbonPeriod::create('2018-01-01', '2030-12-31');
        
        // Convert the period to an array of dates
        // $dates = $period->toArray();
        // $firstofthismonth =  Carbon::now()->firstOfMonth(); // get this first day in month now
        // $lastofthismonth =  Carbon::now()->lastOfMonth(); // get this last day in month now
        // $thismonth = Carbon::now()->format('m'); // get this month now
        // $thisyear = Carbon::now()->format('Y'); // get this year now
        // $i = $firstofthismonth->format('d'); // 1
        // $y = $lastofthismonth->format('d'); // 31
        // $check  = Date::where('full_date',  $firstofthismonth)->get(); // check data month
        // if (count($check) > 0) {

        // }
        // else{
        //     for ($i;  $i<= $y ; $i++) {
        //         $month = $thisyear.'-'.$thismonth.'-'.$i;
        //         // dd($month);
        //         $data  = new Date();
        //         $data->full_date = $month;
        //         $data->save();
        //     }
        // }
    }

    public function generateDate(){
        $period = CarbonPeriod::create('2020-01-01', '2020-12-31');

        // Iterate over the period
        foreach ($period as $date) {
            $tgl=  $date->format('Y-m-d');
            $check  = Date::where('full_date',  $tgl)->get();
            if (count($check) > 0) {

            }
            else{
               
                    $data  = new Date();
                    $data->full_date = $tgl;
                    $data->save();
                
            }
        }
    }

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

        // $thismonth = Carbon::now()->addMonths(1)->format('Y-m'); //angka this month
        $thismonth = '2020-02'; //angka this month
    
        $datatgl = Date::where('full_date','like','%'.$thismonth.'%')->get();
        $employee = Employee::all();
        $department = Department::all();
        // $workingtime = WorkingTime::all();
        $workingtime = WorkingTime::where('id',3)->get();
        return view('schedule.add', compact('employee','department','workingtime','datatgl'));
    }

    public function insertSchedule(Request $request)
    {
        // dd($request->all());
        foreach ($request->schedule_detail as $row) {
            if ($request->working_time != '0') {
                $data  = new Schedule();
                $data->id_date = $row['date_id'];
                $data->id_work_time = $row['working_time'];
                $data->id_emp = $request->employee_id;
                $data->save();
            }
                
        }
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

    public function importSchedule(Request $request)
    {
        // dd($request->hasFile('namaStaff'));
        if ($request->hasFile('schedule')) {
            try{
               $data =  Excel::import(new \App\Imports\ScheduleImport, $request->file('schedule'));
              
            }
            catch(\Exception $e)
            {
                Alert::error('Error', $e->getMessage());
            }
        }
        else{
        }
        return redirect()->back();
    }

}
