<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Deduction;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DeductionImport implements ToCollection
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
                $data =  Deduction::where('deduction_name',$row[1])
                    ->get();
                   if($data->count() >0)
                   {
                   }
                   else{
                      $x =  Deduction::firstOrCreate([
                            'deduction_name'=> $row[1],
                            'deduction_amount'=> $row[2],
                            'id_symbol'=> $row[3]
                        ]);
                   }
                }
        }
    }
}
