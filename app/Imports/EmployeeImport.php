<?php

namespace App\Imports;

use App\Role;
use App\Employee;
use Carbon\Carbon;
use App\Department;
use App\Designation;
use App\Model_has_role;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeeImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public function collection(Collection $collection)
    {
        $designation = Designation::all();
        $dept = Department::all();
        $role = Role::all();
        $design_id = 0;
        $design_id2 = 0;
        $role_id = 0;
        foreach($collection as $key => $row)
        {
            if($key>=1){
                // dd($collection);
                // $bagian = Designation::where('name', $row[4])->get();
                // if ($bagian->count()>0) {

                // } else {
                //     $id_dept = 0;
                //     foreach ($dept as $deptRow) {
                //        if ($deptRow->name == $row[5]) {
                //         $id_dept = $deptRow->id;
                //        }
                //     }
                //     $bag = new Designation;
                //     $bag->name = $row[4];
                //     $bag->idDepartment = $id_dept;
                //     $bag->save();
                // }

                // $role = Role::where('name', $row[2])->get();
                // if ($role->count()>0) {

                // } else {
                //     $bag = new Role;
                //     $bag->name = $row[2];
                //     $bag->guard_name = 'web';
                //     $bag->save();
                // }


                    $data =  Employee::where('scan_id', $row[0])
                    ->get();

                   if($data->count() >0)
                   {
                   }
                   else{
                    foreach ($designation as $design) {
                        if ($design->name == $row[4]) {
                            $design_id2 = $design->id;
                        }
                    }
                    $bag = new Employee;
                    $bag->scan_id = $row[0];
                    $bag->nik = $row[0];
                    $bag->full_name = $row[1];
                    $bag->id_designation =$design_id2;
                    $bag->is_supervisor = $row[6];
                    $bag->cabang = $row[3];
                    $bag->password = bcrypt('secret');
                    $bag->save();

                    foreach ($role as $rol) {
                        if ($rol->name == $row[2]) {
                            $role_id = $rol->id;
                        }
                    }

                    $dataEmp = Employee::where('scan_id', $row[0])->first();
                    DB::table('model_has_roles')->insert(
                        [
                            'role_id' =>  $role_id,
                            'model_type' => 'App\Employee',
                            'model_id' => $dataEmp->id
                        ]
                    );
                   }
                }
        }
    }
}
