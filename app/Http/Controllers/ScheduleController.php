<?php

namespace App\Http\Controllers;

use App\Date;
use App\Employee;
use App\Schedule;
use Carbon\Carbon;
use App\Department;
use App\log_em_stat;
use App\WorkingTime;
use App\ScheduleBulk;
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
            // dd($tgl);
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


        $user = Auth()->user();
        $roles = $user->roles->pluck('name');

        if ($roles[0] == "HRD Manager" || $roles[0] == "HRD Admin Supervisor") {
            $data = Schedule::orderBy('id', 'desc');
            if ($request->r) {
                $data->WhereHas('Employee', function ($query) use ($request) {
                        $query->Where('full_name', 'like', '%' . $request->r . '%');
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
        else {
            $id = Auth()->user()->id;
            $empData = Employee::find($id);
            if ($empData->is_supervisor == 1) {
                $idEmp = Employee::select('nik')->where('id_designation', $empData->id_designation)->get();
                $data = Schedule::whereIn('id_emp', $idEmp )->orderBy('id', 'desc');
                if ($request->r) {
                    $data->WhereHas('Employee', function ($query) use ($request) {
                            $query->Where('full_name', 'like', '%' . $request->r . '%');
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
            } else {
                $data = Schedule::where('id_emp', $empData->nik )->orderBy('id', 'desc');
                if ($request->r) {
                    $data->WhereHas('Employee', function ($query) use ($request) {
                            $query->Where('full_name', 'like', '%' . $request->r . '%');
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
        }
    }

    public function addSchedule(Request $request)
    {

        // $thismonth = Carbon::now()->addMonths(1)->format('Y-m'); //angka this month
        // dd($thismonth);
        $thismonth = date('Y-m'); //angka this month

        $datatgl = Date::where('full_date','like','%'.$thismonth.'%')->get();
        // dd($datatgl);
        $employee = Employee::all();
        $department = Department::all();
        // $workingtime = WorkingTime::all();
        $workingtime = WorkingTime::select('in_time','out_time', 'workingTime_name' )->get();
        return view('schedule.add', compact('employee','department','workingtime','datatgl'));
    }

    public function checkSchedule(Request $request)
    {
        $user = Auth()->user();
        $roles = $user->roles->pluck('name');
        if ($roles[0] == "HRD Manager" || $roles[0] == "HRD Admin Supervisor")  {
            $employee = Employee::all();
            return view('schedule.check', compact('employee'));
        }
        else{
            $id = Auth()->user()->id;
            $empData = Employee::find($id);
            if ($empData->is_supervisor == 1) {
                $employee = Employee::where('id_designation', $empData->id_designation)->get();
                return view('schedule.check', compact('employee'));
            }
            else{

            }

        }


    }

    public function findSchedule(Request $request)
    {
       $scan_id = $request->employee_id;
       $month = $request->month;
       $schedule = Schedule::where('id_emp', $scan_id)
                        ->where('date_work', 'like', '%'.$request->month.'%')->first();

        if(isset($schedule)) {
            Alert::info('Info', "Data Has Been Added");
            $scheduledetail = Schedule::where('id_emp', $scan_id)
            ->where('date_work', 'like', '%'.$request->month.'%')->get();
            return view('schedule.update', compact('schedule','scheduledetail'));
        }
        else{
            $datatgl = Date::where('full_date','like','%'.$month.'%')->get();
            $employee = Employee::where('scan_id', $scan_id)->first();
            return view('schedule.add', compact('employee','datatgl'));

        }
    }

    public function insertSchedule(Request $request)
    {
        foreach ($request->schedule_detail as $row) {
                $data  = new Schedule();
                $data->date_work = $row['date_work'];
                $data->in_time = date("H:i", strtotime($row['in_time']));
                $data->out_time = date("H:i", strtotime($row['out_time']));
                $data->id_emp = $request->id_emp;
                $data->save();
        }
        return redirect()->route('show_schedule');
    }

    public function editSchedule($id)
    {
        $employee = Employee::all();
        $schedule = WorkingTime::all();
        return view('schedule.update', compact('employee','schedule'));
    }

    public function updateSchedule(Request $request)
    {
        foreach ($request->schedule_det as $row) {
            Schedule::where('id', $row['sched_id'])
            ->update([
                'in_time' => date("H:i", strtotime($row['in_time'])),
                'out_time' =>  date("H:i", strtotime($row['out_time']))
                ]);
        }
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

    public function importAttlog(Request $request)
    {
        // dd($request->hasFile('namaStaff'));
        if ($request->hasFile('attlog')) {
            try{
               $data =  Excel::import(new \App\Imports\AttlogImport, $request->file('attlog'));

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



    public function importyeah()
    {
        $data = ScheduleBulk::all();
        foreach($data as $row)
        {
            // dd($row);


                    $time = explode('/', $row->tgl);

                    $converted = $time[2]."-".$time[1]."-".$time[0];

                    $working_time = WorkingTime::all();
                    $schedule = Schedule::all();
                    $date = Date::where('full_date', 'like', '2020-06%')->get();
                    $id_date = "";
                    $id_work_time = "";

                    foreach($date as $dateKu)
                    {

                        if($dateKu->full_date == $converted){
                            $id_date = $dateKu->id;
                        }
                    }

                    foreach($working_time as $working_timeKu)
                    {
                        if($working_timeKu->workingTime_name == $row->jamkerja){
                           $id_work_time =$working_timeKu->id;
                        //    dd($id_work_time);
                        }
                    }

                    $data =  Schedule::where('id_emp',$row->scanid)
                                        ->where('id_date', $id_date)
                                        ->where('id_work_time', $id_work_time)
                        ->get();

                       if($data->count() >0)
                       {
                       }
                       else{
                        $schedule = Schedule::create([
                                'id_emp'=> $row->scanid,
                                'id_date'=> $id_date,
                                'id_work_time'=> $id_work_time
                            ]);
                            $schedule->save();
                       }
                    }



    }



}
