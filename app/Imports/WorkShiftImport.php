<?php

namespace App\Imports;

use App\Attendance;
use Carbon\CarbonImmutable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class WorkShiftImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public function collection(Collection $collection)
    {

        foreach($collection as $key => $row)
        {
            if($key == 0){
                // $date = Carbon::parse($row[1]);
                $z = Carbon::createFromFormat('d/m/Y', $row[1]);
                      $x =  Attendance::firstOrCreate([
                            'id_employee'=> $row[0],
                            'in_time' => $row[2],
                            'out_time' => $row[3],
                            'tanggal' => $z->format('Y-m-d')
                        ]);

                }
        }
    }
}
