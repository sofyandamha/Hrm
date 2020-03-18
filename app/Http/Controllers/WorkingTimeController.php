<?php

namespace App\Http\Controllers;

use App\WorkingTime;
use Illuminate\Http\Request;
use App\Exports\WorkingTimeExport;
use App\Imports\WorkingTimeImport;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class WorkingTimeController extends Controller
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

    public function index(Request $request)
    {
        $data = WorkingTime::orderBy('workingTime_name','asc');
        if ($request->r) {
            $data->where('workingTime_name','like', '%'.$request->r.'%')->orWhere('out_time','like', '%'.$request->r.'%');
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

        return view('working_time.index', compact('data','tableinfo'));
    }

    public function insertWorkingtime(Request $request)
    {
        $data = new WorkingTime();
        $data->workingTime_name = $request->workingTime_name;
        $data->in_time = $request->in_time;
        $data->out_time = $request->out_time;
        $data->save();

        return redirect()->route('show_workingTime');
    }

    public function editWorkingtime($id)
    {
        $data = WorkingTime::find($id);
        return view('working_time.update', compact('data'));
    }

    public function deleteWorkingtime($id)
    {
        $data = WorkingTime::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function updateWorkingtime(Request $request)
    {
        $data = WorkingTime::find($request->id);
        $data->workingTime_name = $request->workingTime_name;
        $data->in_time = $request->in_time;
        $data->out_time = $request->out_time;
        $data->save();

        return redirect()->route('show_workingTime');
    }

    public function importWorkingtime(Request $request)
    {
        // dd($request->hasFile('namaStaff'));
        if ($request->hasFile('namaWorkingtime')) {
            try{
                Excel::import(new \App\Imports\WorkingTimeImport, $request->file('namaWorkingtime'));
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

    public function eksportWorkingtime()
    {
        return Excel::download(new WorkingTimeExport, 'WorkingTime.xlsx');
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
     * @param  \App\WorkingTime  $workingTime
     * @return \Illuminate\Http\Response
     */
    public function show(WorkingTime $workingTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkingTime  $workingTime
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkingTime $workingTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkingTime  $workingTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkingTime $workingTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkingTime  $workingTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkingTime $workingTime)
    {
        //
    }
}
