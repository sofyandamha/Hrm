<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Allowance;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AllowanceImport implements ToCollection
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
                $data =  Allowance::where('allowance_name',$row[1])
                    ->get();
                   if($data->count() >0)
                   {
                   }
                   else{
                      $x =  Allowance::firstOrCreate([
                            'allowance_name'=> $row[1],
                            'allowance_amount'=> $row[2],
                            'id_symbol'=> $row[3]
                        ]);
                   }
                }
        }
    }
}
