<?php

namespace App\Imports;

use App\Date;
use App\Schedule;
use Carbon\Carbon;
use App\WorkingTime;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ScheduleImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    public function collection(Collection $collection)
    {

        foreach($collection as $key => $row)
        {
            if($key>=1){

                $time = $row[1];
                $converted = Carbon::createFromFormat('d/m/Y', $time);
                $working_time = WorkingTime::all();
                $schedule = Schedule::all();
                $date = Date::where('full_date', 'like', '2020-02%')->get();
                $id_date = "";
                $id_work_time = "";

                foreach($date as $dateKu)
                {

                    if($dateKu->full_date == $converted->toDateString()){
                        $id_date = $dateKu->id;
                    }
                }

                foreach($working_time as $working_timeKu)
                {
                    if($working_timeKu->workingTime_name == $row[2]){
                       $id_work_time =$working_timeKu->id;
                    }
                }

                $data =  Schedule::where('id_emp',$row[0])
                                    ->where('id_date', $id_date)
                                    ->where('id_work_time', $id_work_time)
                    ->get();

                   if($data->count() >0)
                   {
                   }
                   else{
                      $x =  Schedule::firstOrCreate([
                            'id_emp'=> $row[0],
                            'id_date'=> $id_date,
                            'id_work_time'=> $id_work_time
                        ]);
                   }
                }

            }
        
    }
}
