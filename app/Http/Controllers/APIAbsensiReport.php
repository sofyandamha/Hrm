<?php

namespace App\Http\Controllers;

use App\Employee;
use App\ImeiDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIAbsensiReport extends Controller
{
    public function getAbsensi(Request $request)
    {
        $scanid = $request->nik;
        $month = $request->month;

        $data = DB::select(DB::raw("
		SELECT src1.*, sched.in_time, sched.out_time, TIMEDIFF(src1.JamMasukMinFix, sched.in_time) AS selisihmasuk, TIMEDIFF(src1.JamKelMaxFix, sched.out_time) AS selisihkeluar,
		CASE
			when sched.status = 0 and src1.JamMasukMinFix IS null then 'Datang Telat'
			when sched.status = 0 and TIMEDIFF(src1.JamMasukMinFix, sched.in_time) < '00:00:00.000000' then 'Datang Cepat'
			when sched.status = 0 and TIMEDIFF(src1.JamMasukMinFix, sched.in_time) = '00:00:00.000000' then 'Datang Tepat Waktu'
			when sched.status = 0 and TIMEDIFF(src1.JamMasukMinFix, sched.in_time) > '00:00:00.000000' then 'Datang Terlambat'
			ELSE  lt.leave_type
		END AS 'KeteranganMasuk',
		CASE
			when sched.status = 0 and TIMEDIFF(src1.JamKelMaxFix, sched.out_time) < '00:00:00.000000' then 'Pulang Cepat'
			when sched.status = 0 and TIMEDIFF(src1.JamKelMaxFix, sched.out_time) = '00:00:00.000000' then 'Pulang Tepat Waktu'
			when sched.status = 0 and TIMEDIFF(src1.JamKelMaxFix, sched.out_time) > '00:00:00.000000' then 'Pulang Melebihi Jadwal Kerja'
			ELSE  lt.leave_type
		END AS 'KeteranganPulang',
		sched.`status`
		FROM (
		SELECT src.scan_id , src.tglku, MIN(src.JamMasukMinimal) AS JamMasukMin ,
			MAX(src.JamMasukMaksimal) AS JamMasukMax , MIN(src.JamKeluarMinimal) AS JamKelMin, MAX(src.JamKeluarMaksimal) AS JamKelMax,
			case
				when MIN(src.JamMasukMinimal) IS NULL AND MIN(src.JamKeluarMaksimal) IS NOT NULL then MIN(src.JamKeluarMaksimal)
				when MIN(src.JamMasukMinimal) IS not NULL then MIN(src.JamMasukMinimal)
			END AS JamMasukMinFix,
				 IFNULL(MAX(src.JamKeluarMaksimal), MAX(src.JamMasukMaksimal)) AS JamKelMaxFix
				FROM (
					SELECT nik as scan_id, DATE_FORMAT(scan_at, '%Y-%m-%d') AS tglku,
		case
			when status = 0 then MIN(DATE_FORMAT(scan_at, '%H:%i'))
		END AS 'JamMasukMinimal',
		case
			when status = 0 then MAX(DATE_FORMAT(scan_at, '%H:%i'))
		END AS 'JamMasukMaksimal',
		case
			when status = 1 then MIN(DATE_FORMAT(scan_at, '%H:%i'))
		END AS 'JamKeluarMinimal',
		case
			when status = 1 then MAX(DATE_FORMAT(scan_at, '%H:%i'))
		END AS 'JamKeluarMaksimal'
		from
				attlog_android
		GROUP BY
			nik, scan_at, STATUS) src
				GROUP BY src.scan_id , src.tglku
				) src1
		JOIN schedules sched
			left JOIN leave_types lt ON lt.id = sched.`status`
				WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku  and src1.scan_id = $scanid and src1.tglku LIKE '$month%'
        "));
       return $data;

    }

    public function getAbsensiLogMonthEmp(Request $request)
    {
        $scanid = $request->nik;
        $month = $request->month;
        $data = DB::select(DB::raw("
        SELECT nik AS scan_id, scan_at as tglku, DATE_FORMAT(scan_at, '%H:%i') AS Jam, STATUS,
		case
			when status = 0 then 'Absen Masuk'
			when STATUS = 1 then 'Absen Keluar'
		END AS 'Keterangan'
		from
				attlog_android  WHERE nik = $scanid  and scan_at LIKE '$month%'
		GROUP BY
            nik, scan_at, status;
        "));
       return $data;
    }

    public function getAbsensiEmp(Request $request)
    {
        $scanid = $request->nik;
        $month = $request->month;
        $data = DB::select(DB::raw("
        SELECT
		src.scan_id , src.tglku, MIN(src.JamMasukMinimal) AS JamMasukMin ,
		MAX(src.JamMasukMaksimal) AS JamMasukMax , MIN(src.JamKeluarMinimal) AS JamKelMin, MAX(src.JamKeluarMaksimal) AS JamKelMax,
			MIN(src.JamMasukMinimal) AS JamMasukMinFix,
			 IFNULL(MAX(src.JamKeluarMaksimal), MAX(src.JamMasukMaksimal)) AS JamKelMaxFix
			FROM (
				SELECT nik as scan_id, DATE_FORMAT(scan_at, '%Y-%m-%d') AS tglku,
		case
			when status = 0 then MIN(DATE_FORMAT(scan_at, '%H:%i'))
		END AS 'JamMasukMinimal',
		case
			when status = 0 then MAX(DATE_FORMAT(scan_at, '%H:%i'))
		END AS 'JamMasukMaksimal',
		case
			when status = 1 then MIN(DATE_FORMAT(scan_at, '%H:%i'))
		END AS 'JamKeluarMinimal',
		case
			when status = 1 then MAX(DATE_FORMAT(scan_at, '%H:%i'))
		END AS 'JamKeluarMaksimal'
		from
				attlog_android
		GROUP BY
			nik, scan_at, STATUS
			) src where  src.scan_id = $scanid and src.tglku like '$month%'
			GROUP BY src.scan_id , src.tglku;
        "));
       return $data;
	}

	public function getOtentikasiEmployee()
	{
		$dataEmployee = Employee::whereDoesntHave('ImeiDevice')->orderBy('full_name', 'ASC')->get();
		if(isset($dataEmployee)){
			return response()->json([
				'success' => true,
				'data' => $dataEmployee,
			]);
		}else{
			return response()->json([
				'success' => false,
				'message' => 'Data Tidak Ada',
			], 404);
		}
	}

	public function regisOtentikasiHrd(Request $request)
	{
		$nikEmployee = $request->nikEmployee;
		$dataEmployee = Employee::where('nik', $nikEmployee)->first();

		if(isset($dataEmployee)){
			foreach($request->imei as $imeis){
				$dataImei = ImeiDevice::create([
					'id_employee' => $dataEmployee->id,
					'imei' => $imeis,
				]);
			}

			return response()->json([
				'success' => true,
				'message' => 'Register Berhasil...',
			], 200);
		}
	}

}
