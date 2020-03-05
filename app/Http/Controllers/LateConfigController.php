<?php

namespace App\Http\Controllers;

use App\Late_config;
use Illuminate\Http\Request;

class LateConfigController extends Controller
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

    public function insertLateconfig(Request $request)
    {
        $data = new Late_config();
        $data->late_config = $request->late_config;
        $data->save();

        return redirect()->back();
    }

    public function editLateconfig($id)
    {
        $editLate = Late_config::find($id);
        return view('payroll.lateconfig.update', compact('editLate'));
    }

    public function updateLateconfig(Request $request)
    {
        $data = Late_config::find($request->id);
        $data->late_config = $request->late_config;
        $data->save();

        return redirect()->route('show_taxsetup');
    }

    public function deleteLateconfig($id)
    {
        $data = Late_config::find($id);
        $data->delete();
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
     * @param  \App\Late_config  $late_config
     * @return \Illuminate\Http\Response
     */
    public function show(Late_config $late_config)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Late_config  $late_config
     * @return \Illuminate\Http\Response
     */
    public function edit(Late_config $late_config)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Late_config  $late_config
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Late_config $late_config)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Late_config  $late_config
     * @return \Illuminate\Http\Response
     */
    public function destroy(Late_config $late_config)
    {
        //
    }
}
