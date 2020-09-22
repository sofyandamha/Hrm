<?php

namespace App\Imports;

use App\Employee;
use Carbon\Carbon;
use App\Designation;
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
        $designation = Designation::all();
        $design_id = 0;
        foreach($collection as $key => $row)
        {
            if($key>=1){
                $data =  Employee::where('scan_id', $row[2])
                    ->get();

                   if($data->count() >0)
                   {
                   }
                   else{
                    foreach ($designation as $design) {
                        if ($design->name == $row[6]) {
                            $design_id = $design->id;
                        }
                    }

                        $x =  Employee::firstOrCreate(['scan_id'=>$row[2],
                            'full_name'=> $row[0],
                            'id_designation' => $design_id,
                            'password' => bcrypt('secret')
                        ]);
                   }
                }
        }
    }
}
