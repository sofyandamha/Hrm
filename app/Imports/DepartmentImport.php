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
                $data =  Department::where('name',$row[1])
                    ->get();
                   if($data->count() >0)
                   {
                   }
                   else{
                      $x =  Department::firstOrCreate([
                            'name'=> $row[1]
                        ]);
                   }
                }
        }
    }
}
