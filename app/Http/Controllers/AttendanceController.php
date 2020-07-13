<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Attendance;
use App\Department;
use Illuminate\Http\Request;
use App\Imports\WorkShiftImport;
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
        $employee = Employee::where('id','!=',1)->orderBy('id', 'asc')->get();
        $department = Department::all();

        // dd($department);
        $data = Attendance::orderBy('id_employee', 'asc');
        if ($request->has('scan_id')) {
            if ($request->scan_id != "") {
                $data->where('id_employee', $request->scan_id);
            }
        }
        if ($request->has('date_attendance')) {
           if ($request->date_attendance != "") {
                $data->where('tanggal','like','%'.$request->date_attendance.'%');
           }
        }
        if ($request->has('page') ? $request->get('page') : 1) {
            $page    = $request->has('page') ? $request->get('page') : 1;
            $total   = $data->count();
            $perPage = 30;
            $showingTotal  = $page * $perPage;

            $currentShowing = $showingTotal > $total ? $total : $showingTotal;
            $showingStarted = $showingTotal - $perPage;
            $tableinfo = "Showing $showingStarted to $currentShowing of $total entries";
        }

        $data = $data->paginate($perPage);
        $data->appends($request->all());

        return view('attendance.report.index', compact('data','employee','department','tableinfo','perPage','page'));

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
}
