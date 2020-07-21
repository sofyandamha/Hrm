<?php

namespace App\Http\Controllers;

use App\Employee;
use Carbon\Carbon;
use App\Attendance;
use App\Department;
use App\AttendanceBulk;
use Illuminate\Http\Request;
use App\Imports\WorkShiftImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexReport(Request $request)
    {   
        // dd($request->all());
        $scanid = "900009014";
        $month = "2020-06";
           if ($request->scan_id != "") {
               $scanid = $request->scan_id;
           }
            if ($request->date_attendance != "") {
                $month =  $request->date_attendance;
            }
            
        $data = DB::select(DB::raw("
        SELECT 
		e.scan_id as 'scanid', e.full_name AS 'Full_Name' , 
		d.full_date AS 'Jadwal_Masuk', 
		w.in_time AS 'Jam_Masuk', w.out_time AS 'Jam_Keluar', 
		a.tanggal AS 'Tanggal_Scan' , a.in_time AS 'Scan_Masuk', 
		a.out_time AS 'Scan_Keluar' 
        FROM
            employees e LEFT JOIN attendances a 
        on e.scan_id = a.id_employee
        JOIN schedules s ON s.id_emp = e.scan_id AND  e.scan_id= $scanid
        JOIN date d ON d.id = s.id_date
        JOIN working_times w ON w.id = s.id_work_time
        where e.scan_id = a.id_employee AND a.tanggal = d.full_date  AND a.tanggal LIKE '$month%';
                        "));
        $department = Department::get();
        $employee = Employee::get();
       
        return view('attendance.report.index', compact('data','department','employee'));

    }


    public function indexWorkshift()
    {
        return view('attendance.workshift.index');
    }

    public function importWorkshift(Request $request)
    {
        // dd($request->hasFile('namaStaff'));
        if ($request->hasFile('namaWorkshift')) {
            try{
                Excel::import(new \App\Imports\WorkShiftImport, $request->file('namaWorkshift'));
                // toast('Data Has Been Uploaded!','success');
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

    public function getAbsensi(Request $request)
    {   
        dd($request->all());
        $scanid = $request->nik;
        $month = $request->month;

        $data = DB::select(DB::raw("
        SELECT 
		e.scan_id as 'scanid', e.full_name AS 'Full_Name' , 
		d.full_date AS 'Jadwal_Masuk', 
		w.in_time AS 'Jam_Masuk', w.out_time AS 'Jam_Keluar', 
		a.tanggal AS 'Tanggal_Scan' , a.in_time AS 'Scan_Masuk', 
		a.out_time AS 'Scan_Keluar' 
        FROM
            employees e LEFT JOIN attendances a 
        on e.scan_id = a.id_employee
        JOIN schedules s ON s.id_emp = e.scan_id AND  e.scan_id= $scanid
        JOIN date d ON d.id = s.id_date
        JOIN working_times w ON w.id = s.id_work_time
        where e.scan_id = a.id_employee AND a.tanggal = d.full_date  AND a.tanggal LIKE '$month%';
                        "));
       return $data;

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function importabsensi()
    {
        $data = AttendanceBulk::select('id_employee','tanggal','in_time','out_time')->get();
        foreach($data as $row)
        {

                
                    $time = explode('/', $row->tanggal);
                    $converted = $time[2]."-".$time[1]."-".$time[0];

                    $data =  Attendance::where('id_employee', $row->id_employee)
                                        ->where('tanggal', $converted)
                                        ->where('in_time', $row->in_time)
                                        ->where('out_time', $row->out_time)
                        ->get();
    
                       if($data->count() >0)
                       {
                       }
                       else{
                        $attendance = Attendance::create([
                                'id_employee'=> $row->id_employee,
                                'tanggal'=> $converted,
                                'in_time'=> $row->in_time,
                                'out_time'=> $row->out_time
                            ]);
                            $attendance->save();
                       }
                    }
               
            
        
    }
}
