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
            $price = 0;
            if($key>=3){
                // dd($collection);
                $data =  Department::where('id', $row[2])
                    ->where('name',)
                    ->get();

                   if($data->count() >0)
                   {
                   }
                   else{
                      $row =  Department::firstOrCreate([
                            'name'=> $row[2]
                        ]);
                   }
                }
        }
    }
}
