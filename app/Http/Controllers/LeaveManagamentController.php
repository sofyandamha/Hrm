<?php

namespace App\Http\Controllers;

use App\Employee;
use Carbon\Carbon;
use App\Leave_type;
use App\LeaveDetEmp;
use App\Leave_managament;
use Illuminate\Http\Request;

class LeaveManagamentController extends Controller
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

    public function index()
    {
        //
    }

    public function indexRequestapp(Request $request)
    {
        $data = LeaveDetEmp::orderBy('id_emp', 'desc');

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

        return view('leave.request.index', compact('data','tableinfo','perPage','page'));
    }

    public function indexLeavereport()
    {
        return view('leave.report.index');
    }

    public function addRequestapp()
    {
        $employee = Employee::all();
        $leave_type = Leave_type::where('id', '<', 4)->get();
        return view('leave.request.add', compact('employee','leave_type'));
    }
    public function checkRequestapp(Request $request)
    {
        $year = date('Y');
        $date = explode(' - ', $request->leave_date);
        $from = Carbon::createFromFormat('Y-m-d', $date[0]);
        $to = Carbon::createFromFormat('Y-m-d', $date[1]);
        $diff_in_days = $from->diffInDays($to);

        // $check = LeaveDetEmp::where('id_emp', $request->employee_id)
        //                         ->where('year', $year)->get();
        $data = new LeaveDetEmp();
        $data->id_emp = $request->employee_id;
        $data->id_leave_type= $request->leave_type_id;
        $data->start_leave= $date[0];
        $data->end_leave=  $date[1];
        $data->year= $year;
        $data->remarks= $request->remak;
        $data->totalhari= $diff_in_days;
        $data->status= 0;
        $data->created_by= auth()->user()->id;

        $data->save();
        return redirect()->route('show_requestApp');

    }

    public function insertRequestapp(Request $request)
    {
        $data = new Leave_managament();
        $data->id_employee = $request->employee_name;
        $data->id_leave_type = $request->leave_type;
        $data->start_leave = $request->start_leave;
        $data->end_leave = $request->end_leave;
        $data->remak = $request->remak;
        $data->status = 0;

        $data->save();
        return redirect()->route('show_requestApp');
    }

    public function editRequestapp($id)
    {
        $edit_requestApp = Leave_managament::find($id);
        $leave_type = Leave_type::all();
        $employee = Employee::all();

        return view('leave.request.update', compact('edit_requestApp','leave_type','employee'));
    }

    public function updateRequestapp(Request $request)
    {
        $data = Leave_managament::find($request->id);
    }

    public function deleteRequestapp($id)
    {
        $data = Leave_managament::find($id);
        $data->delete();

        return redirect()->back();
    }

   public function approvedRequestapp($id)
   {
        $data = LeaveDetEmp::find($id);
        $data->status = 1; //Approved
        $data->approved_by = Auth()->user()->id;
        $data->approved_at = date('Y-m-d H:i');
        $data->updated_by = Auth()->user()->id;
        $data->save();
        return redirect()->route('show_requestApp');
   }

   public function rejectedRequestapp($id)
   {
        $data = LeaveDetEmp::find($id);
        $data->status = 2; //Rejected
        $data->approved_by = Auth()->user()->id;
        $data->approved_at = date('Y-m-d H:i');
        $data->updated_by = Auth()->user()->id;
        $data->save();
        return redirect()->route('show_requestApp');
   }

   public function cancel_requestApp($id)
   {
        $data = LeaveDetEmp::find($id);
        $data->status = 0; //Pending
        $data->approved_by = null;
        $data->approved_at = null;
        $data->updated_by = null;
        $data->save();
        return redirect()->route('show_requestApp');
   }


}
