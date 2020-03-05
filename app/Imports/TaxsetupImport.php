<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Tax_setup;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TaxsetupImport implements ToCollection
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
                $data =  Tax_setup::where('tax_rule',$row[1])
                    ->get();
                   if($data->count() >0)
                   {
                   }
                   else{
                      $x =  Tax_setup::firstOrCreate([
                            'tax_rule'=> $row[1],
                            'tax_rate'=> $row[2],
                            'id_symbol'=> $row[3]
                        ]);
                   }
                }
        }
    }
}
