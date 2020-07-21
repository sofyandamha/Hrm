<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIAbsensiReport extends Controller
{
    public function getAbsensi(Request $request)
    {   
        $scanid = $request->nik;
        $month = $request->month;

        $data = DB::select(DB::raw("
        SELECT 
		
		d.full_date AS 'Jadwal_Masuk', 
		w.in_time AS 'Jam_Masuk', w.out_time AS 'Jam_Keluar', 
		a.tanggal AS 'Tanggal_Scan' , a.in_time AS 'Scan_Masuk', 
		a.out_time AS 'Scan_Keluar',
		TIMEDIFF(a.in_time,  w.in_time) AS Status
        FROM
            employees e LEFT JOIN attendances a 
        on e.scan_id = a.id_employee
        JOIN schedules s ON s.id_emp = e.scan_id AND  e.scan_id= $scanid
        JOIN date d ON d.id = s.id_date
        JOIN working_times w ON w.id = s.id_work_time
        where e.scan_id = a.id_employee AND a.tanggal = d.full_date  AND a.tanggal LIKE '%$month%';
                        "));
       return $data;

    }
}
