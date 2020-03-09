<?php

namespace App\Imports;

use Carbon\Carbon;
use App\WorkingTime;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class WorkingTimeImport implements ToCollection
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
                $data =  WorkingTime::where('id',$row[0])
                    ->get();
                   if($data->count() >0)
                   {
                   }
                   else{
                      $x =  Allowance::firstOrCreate([
                            'in_time'=> $row[1],
                            'out_time'=> $row[2]
                        ]);
                   }
                }
        }
    }
}
