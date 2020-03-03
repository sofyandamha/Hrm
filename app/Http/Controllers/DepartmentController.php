<?php

namespace App\Http\Controllers;
use App\Department;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Department::orderBy('name', 'desc');
        if ($request->r) {
            $data->where('name','like', '%'.$request->r.'%');
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

        return view('department.index', compact('data','tableinfo'));
    }

    public function insertDepartment(Request $request)
    {
        $data = new Department();
        $data->name = $request->name;
        $data->save();

        return redirect()->route('show_department');
    }

    public function editDepartment($id)
    {
        $data = Department::find($id);
        return view('department.update', compact('data'));
    }

    public function deleteDepartment($id)
    {
        $data = Department::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function updateDepartment(Request $request)
    {
        $data = Department::find($request->id);
        $data->name = $request->name;
        $data->save();

        return redirect()->route('show_department');
    }

    public function importDepartment(Request $request)
    {
        // dd($request->hasFile('namaStaff'));
        if ($request->hasFile('namaStaff')) {
            try{
                Excel::import(new \App\Imports\DepartmentImport, $request->file('namaStaff'));
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
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }
}
