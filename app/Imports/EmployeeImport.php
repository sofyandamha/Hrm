<?php

namespace App\Imports;

use App\Employee;
use Carbon\Carbon;
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

        foreach($collection as $key => $row)
        {
            if($key>=3){
                // dd($collection);
                $data =  Employee::where('scan_id', $row[1])
                    ->where('full_name',$row[2])
                    ->get();

                   if($data->count() >0)
                   {
                   }
                   else{
                      $x =  Employee::firstOrCreate(['scan_id'=>$row[1],
                            'full_name'=> $row[2]
                        ]);
                   }
                }
        }
    }
}
