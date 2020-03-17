<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Leave_type;
use App\Leave_managament;
use Illuminate\Http\Request;

class LeaveManagamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function indexRequestapp(Request $request)
    {
        $data = Leave_managament::orderBy('id_employee', 'asc');

        if ($request->r) {
            $data->WhereHas('Employee', function ($query) use ($request) {
                    $query->Where('name', 'like', '%' . $request->r . '%');
                })
                ->orWhereHas('Leave_type',function ($query) use ($request){
                    $query->Where('leave_type', 'like', '%' . $request . '%');
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

        return view('leave.request.index', compact('data','tableinfo','perPage','page'));
    }

    public function indexLeavereport()
    {
        return view('leave.report.index');
    }

    public function addRequestapp()
    {
        $employee = Employee::all();
        $leave_type = Leave_type::all();
        return view('leave.request.add', compact('employee','leave_type'));
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
     * @param  \App\Leave_managament  $leave_managament
     * @return \Illuminate\Http\Response
     */
    public function show(Leave_managament $leave_managament)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave_managament  $leave_managament
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave_managament $leave_managament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leave_managament  $leave_managament
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave_managament $leave_managament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave_managament  $leave_managament
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave_managament $leave_managament)
    {
        //
    }
}
