<?php

namespace App\Imports;

use App\AttLog;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;

class AttLogImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public function collection(Collection $collection)
    {

        foreach($collection as $key => $row)
        {
            if($key>=1){
                $date = Date::excelToDateTimeObject($row[1]);
                $x =  AttLog::create([
                    'scan_id'=> $row[0],
                    'tgl'=> $date->format('Y-m-d H:i'),
                    'no_mesin'=> $row[2],
                    'status'=> $row[3],
                    'cek'=> $row[4],
                    'tipescan'=> $row[5]
                ]);
            }
        }
    }
}
