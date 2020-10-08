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
                // dd($collection);
                $data =  Department::where('name',$row[5])
                    ->get();
                   if($data->count() >0)
                   {
                   }
                   else{
                       $is_office_hour=0;
                       if($row[5]== "Office 5-2"){
                        $is_office_hour = 1;
                       }

                      $check = Department::where('name', $row[1])->where('is_officeHour', $is_office_hour)->get();
                      if (count($check)>0) {
                          # code...
                      } else {
                          Department::create([
                              'name' => $row[5],
                              'is_officeHour' => $is_office_hour
                          ]);
                      }

                   }
                }
        }
    }
}
