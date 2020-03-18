<?php

namespace App\Imports;

use App\Employee;
use Carbon\Carbon;
use App\Department;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeeImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public function collection(Collection $collection)
    {
        $department = Department::all();
        $depart_id = 0;
        foreach($collection as $key => $row)
        {
            if($key>=2){
                // dd($row[1]);
                $data =  Employee::where('scan_id', $row[0])
                    ->where('full_name',$row[1])
                    ->get();

                   if($data->count() >0)
                   {
                   }
                   else{
                    foreach ($department as $depart) {
                        if ($depart->name == $row[2]) {
                            $depart_id = $depart->id;
                        }
                    }
                        $x =  Employee::firstOrCreate(['scan_id'=>$row[0],
                            'full_name'=> $row[1],
                            'id_department' => $depart_id,
                            'password' => bycrpt('123456')
                        ]);
                   }
                }
        }
    }
}
