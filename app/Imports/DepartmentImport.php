<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Department;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DepartmentImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public function collection(Collection $collection)
    {

        foreach($collection as $key => $row)
        {
            if($key>=1){
                $data =  Department::where('name',$row[1])
                    ->get();
                   if($data->count() >0)
                   {
                   }
                   else{
                       $is_office_hour=0;
                       if($row[2] == 10 && $row[1]== "Operational 10(5-2)"){
                        $is_office_hour = 5; // 5-2 dan 9 jam
                       }
                       else if($row[2] == 12 && $row[1]== "Operational 12(5-2)"){
                        $is_office_hour = 4; // 6-1 dan 9 Jam
                       }
                       else if($row[2] == 9 && $row[1]== "Operational Supporting 9 (6 -1)"){
                        $is_office_hour = 3; // 6-1 dan 10 Jam
                       }
                       else if($row[2] == 10 && $row[1]== "Operational Supporting 10 (6 -1)"){
                        $is_office_hour = 2; // Operational dan 10 Jam
                       }
                       else if($row[2] == 9 && $row[1]== "Supporting 9(5-2)"){
                        $is_office_hour = 1; // Operational dan 12 Jam
                       }

                      $check = Department::where('name', $row[1])->where('is_officeHour', $is_office_hour)->get();
                      if (count($check)>0) {
                          # code...
                      } else {
                          Department::create([
                              'name' => $row[1],
                              'is_officeHour' => $is_office_hour,
                              'type'=> $row[3]
                          ]);
                      }

                   }
                }
        }
    }
}
