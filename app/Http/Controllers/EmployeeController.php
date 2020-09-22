<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Department;
use App\Designation;
use App\Model_has_role;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeController extends Controller
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
        // $data = Employee::orderBy('full_name', 'asc');
        // $data = DB::select('SELECT c.`scan_id`,c.`full_name`,c.`id_designation`,c.`address`,c.`nik`,c.`birth_date`,c.`id_status`,c.`created_by`,b.id FROM model_has_roles a
		// JOIN roles b ON a.role_id = b.id
        // JOIN `employees` c ON a.model_id = c.`id`');
        $role = Role::all();
        $designation = Designation::all();
        $data = DB::table('employees')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'employees.id')
        ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->select('employees.id as idemp', 'employees.scan_id', 'employees.full_name', 'employees.id_designation','employees.address','employees.nik','employees.birth_date','employees.id_status','employees.created_by','roles.id');
        if ($request->r) {
            // $data->where('full_name','like', '%'.$request->r.'%')
            //      ->orWhere('scan_id','like', '%'.$request->r.'%')
            //      ->orWhereHas('Department', function ($query) use ($request) {
            //         $query->Where('name', 'like', '%' . $request->r . '%');
            //     });
            $data = DB::table('employees')
                    ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'employees.id')
                    ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->leftJoin('designation','employees.id_designation','=','designation.id')
                    ->select('employees.id as idemp', 'employees.scan_id', 'employees.full_name', 'employees.id_designation','employees.address','employees.nik','employees.birth_date','employees.id_status','employees.created_by','roles.id','designation.name')
                    ->where('full_name','like','%'.$request->r.'%')
                    ->orWhere('scan_id','like','%'.$request->r.'%')
                    ->orWhere('designation.name','like','%'.$request->r.'%');
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
        // dd($data);

        return view('employee.index', compact('data','tableinfo','perPage','page','role','designation'));
    }

    public function addEmployee()
    {
        $department = Department::all();
        return view('employee.add', compact('department'));
    }

    public function insertEmployee(Request $request)
    {
        $data = new Employee();
        $data->id_designation = $request->department_name;
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
        // $editEmp = Employee::find($id);

        $editEmp = DB::table('employees')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'employees.id')
        ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('employees.scan_id', $id)
        ->select('employees.id','employees.scan_id', 'employees.full_name', 'employees.id_designation','employees.address','employees.nik','employees.birth_date','employees.id_status','employees.created_by','roles.id as role_id')->first();
        // dd($editEmp);

        $data = Department::all();
        $role = Role::all();

        // dd($editEmp);
        return view('employee.update', compact('editEmp','data','role'));
    }

    public function updateEmployee(Request $request)
    {
        // dd($request->all());
        $data = Employee::find($request->id_emp);
        // dd($data);

        $data->full_name = $request->full_name;
        $data->address = $request->address;
        $data->nik = $request->nik;
        // $data->is_supervisor = $request->is_supervisor;
        $data->birth_date = $request->birth_date;

        $check = Model_has_role::where('model_id',$request->id_emp)->get();
        // dd($check->count());
        if ($check->count() >0) {

            DB::table('model_has_roles')
            ->where('model_id', $request->id_emp)
            ->update(['role_id' => $request->role]);

        }else{
            DB::table('model_has_roles')->insert([
                [
                        'role_id' => $request->role,
                        'model_type' => 'App\Employee',
                        'model_id' => $request->id_emp
                ]]);
        }

        $data->save();


        return redirect()->route('show_employee');
    }

    public function deleteEmployee($id)
    {
        // dd($request->all());
        $data = Employee::find($id);
        // dd($data);
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
