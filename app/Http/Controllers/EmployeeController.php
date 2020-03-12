<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Department;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Employee::orderBy('full_name', 'asc');

        if ($request->r) {
            $data->where('full_name','like', '%'.$request->r.'%')
                 ->orWhere('scan_id','like', '%'.$request->r.'%')
                 ->orWhereHas('Department', function ($query) use ($request) {
                    $query->Where('name', 'like', '%' . $request->r . '%');
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

        return view('employee.index', compact('data','tableinfo','perPage','page'));
    }

    public function addEmployee()
    {
        $department = Department::all();
        return view('employee.add', compact('department'));
    }

    public function insertEmployee(Request $request)
    {
        $data = new Employee();
        $data->id_department = $request->department_name;
        $data->scan_id = $request->scan_id;
        $data->full_name = $request->full_name;
        $data->address = $request->address;
        $data->nik = $request->nik;
        $data->is_supervisor = $request->is_supervisor;
        $data->birth_date = $request->birth_date;
        $data->save();

        return redirect()->route('show_employee');
    }

    public function editEmployee($id)
    {
        $editEmp = Employee::find($id);
        $data = Department::all();
        return view('employee.update', compact('editEmp','data'));
    }

    public function updateEmployee(Request $request)
    {
        $data = Employee::find($request->id);
        $data->scan_id = $request->scan_id;
        $data->full_name = $request->full_name;
        $data->address = $request->address;
        $data->nik = $request->nik;
        $data->is_supervisor = $request->is_supervisor;
        $data->birth_date = $request->birth_date;
        $data->save();

        return redirect()->route('show_employee');
    }

    public function deleteEmployee($id)
    {
        $data = Employee::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function importEmployee(Request $request)
    {
        // dd($request->hasFile('namaStaff'));
        if ($request->hasFile('namaEmployee')) {
            try{
                Excel::import(new \App\Imports\EmployeeImport, $request->file('namaEmployee'));
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

    public function eksportEmployee()
    {
        return Excel::download(new EmployeeExport, 'Employee.xlsx');
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
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
