<?php

namespace App\Http\Controllers;

use App\Leave_type;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Leave_type::orderBy('leave_type', 'desc');
        if ($request->r) {
            $data->where('leave_type','like', '%'.$request->r.'%');
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

        return view('leave.leave_type.index', compact('data','tableinfo'));
    }

    public function insertLeavetype(Request $request)
    {
        $data = new Leave_type();
        $data->leave_type = $request->leave_type;
        $data->is_day = $request->is_day;
        $data->save();

        return redirect()->route('show_leaveType');
    }

    public function editLeavetype($id)
    {
        $data = Leave_type::find($id);
        return view('leave.leave_type.update', compact('data'));
    }

    public function deleteLeavetype($id)
    {
        $data = Leave_type::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function updateLeavetype(Request $request)
    {
        $data = Leave_type::find($request->id);
        $data->leave_type = $request->leave_type;
        $data->is_day = $request->is_day;
        $data->save();

        return redirect()->route('show_leaveType');
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
     * @param  \App\Leave_type  $leave_type
     * @return \Illuminate\Http\Response
     */
    public function show(Leave_type $leave_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave_type  $leave_type
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave_type $leave_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leave_type  $leave_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave_type $leave_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave_type  $leave_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave_type $leave_type)
    {
        //
    }
}
