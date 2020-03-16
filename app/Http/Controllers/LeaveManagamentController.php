<?php

namespace App\Http\Controllers;

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

    public function indexRequestapp()
    {
        return view('leave.requestApp.index');
    }

    public function indexLeavereport()
    {
        return view('leave.requestApp.index');
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
