<?php

namespace App\Http\Controllers;

use App\Employee;
use Carbon\Carbon;
use App\Attendance;
use App\Department;
use App\AttendanceBulk;
use Illuminate\Http\Request;
use App\Imports\WorkShiftImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexReport(Request $request)
    {
        $scan_id = auth()->user()->nik;
        $date_att= date('Y-m');
        $user = Auth()->user();
        $roles = $user->roles->pluck('name');
        if ($roles[0] == "HRD Manager" || $roles[0] == "HRD Admin Supervisor" ) {
            $employee = Employee::all();
            if ($request->scan_id != null && $request->date_attendance != null) { // ada semua
                $scan_id =$request->scan_id;
                $date_att =$request->date_attendance;

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
                WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku  and src1.scan_id = $scanid and src1.tglku LIKE '$date_att%'

            "));
            }
            if ($request->scan_id == null && $request->date_attendance != null) { //cuma date
                $date_att =$request->date_attendance;
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
                WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku
                        and src1.tglku LIKE '$date_att%'
                                "));
            }
            if ($request->scan_id != null && $request->date_attendance == null) { //cuma scan id
                $scan_id =$request->scan_id;
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
                WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku
                        and src1.scan_id = $scan_id
                                "));
            }
            if ($request->scan_id == null && $request->date_attendance == null) { //semuanya kososng
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
                WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku limit 10
                                "));
            }
            return view('attendance.report.index', compact('data','employee'));
        } else {
            $id = Auth()->user()->id;
            $empData = Employee::find($id);
            if ($empData->is_supervisor == 1) {
                $employee = Employee::where('id_designation', $empData->id_designation)->get();
                $nikKu = array();
                foreach ($employee as $rownikku) {
                    $nikKu[] = $rownikku->nik;
                }
                $nik =  str_replace("|",",",implode("|",$nikKu));
                if ($request->scan_id != null && $request->date_attendance != null) { // ada semua
                    $scan_id =$request->scan_id;
                    $date_att =$request->date_attendance;

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
                    WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku
                            and src1.scan_id = $scan_id and src1.tglku LIKE '$date_att%'
                                    "));
                }
                if ($request->scan_id == null && $request->date_attendance != null) { //cuma date
                    $date_att =$request->date_attendance;
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
                    WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku
                            and src1.tglku LIKE '$date_att%'
                                    "));
                }
                if ($request->scan_id != null && $request->date_attendance == null) { //cuma scan id
                    $scan_id =$request->scan_id;
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
                    WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku
                            and src1.scan_id = $scan_id
                                    "));
                }
                if ($request->scan_id == null && $request->date_attendance == null) { //semuanya kososng
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
                    WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku and src1.scan_id in ($nik)
                                    "));
                }
                return view('attendance.report.index', compact('data','employee'));
            } else {
                $employee = Employee::where('id', $id)->get();
                if ($request->scan_id != null && $request->date_attendance != null) { // ada semua
                    $scan_id =auth()->user()->nik;
                    $date_att =$request->date_attendance;

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
                    WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku
                            and src1.scan_id = $scan_id and src1.tglku LIKE '$date_att%'
                                    "));
                }
                if ($request->scan_id == null && $request->date_attendance != null) { //cuma date
                    $date_att =$request->date_attendance;
                    $scan_id =auth()->user()->nik;
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
                    WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku  and src1.scan_id = $scan_id
                            and src1.tglku LIKE '$date_att%'
                                    "));
                }
                if ($request->scan_id != null && $request->date_attendance == null) { //cuma scan id
                    $scan_id =auth()->user()->nik;
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
                    WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku
                            and src1.scan_id = $scan_id
                                    "));
                }
                if ($request->scan_id == null && $request->date_attendance == null) { //semuanya kososng
                    $scan_id =auth()->user()->nik;
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
                    WHERE sched.id_emp = src1.scan_id AND  sched.date_work = src1.tglku and src1.scan_id = $scan_id
                                    "));
                }
                return view('attendance.report.index', compact('data','employee'));
            }
        }
    }


    public function indexWorkshift()
    {
        return view('attendance.workshift.index');
    }

    public function importWorkshift(Request $request)
    {
        // dd($request->hasFile('namaStaff'));
        if ($request->hasFile('namaWorkshift')) {
            try{
                Excel::import(new \App\Imports\WorkShiftImport, $request->file('namaWorkshift'));
                // toast('Data Has Been Uploaded!','success');
            }
            catch(\Exception $e)
            {
                Alert::error('Error', $e->getMessage());
            }
        }
        else{
        }
        return redirect()->back();
    }

    public function getAbsensi(Request $request)
    {
        dd($request->all());
        $scanid = $request->nik;
        $month = $request->month;

        $data = DB::select(DB::raw("
        SELECT
		e.scan_id as 'scanid', e.full_name AS 'Full_Name' ,
		d.full_date AS 'Jadwal_Masuk',
		w.in_time AS 'Jam_Masuk', w.out_time AS 'Jam_Keluar',
		a.tanggal AS 'Tanggal_Scan' , a.in_time AS 'Scan_Masuk',
		a.out_time AS 'Scan_Keluar'
        FROM
            employees e LEFT JOIN attendances a
        on e.scan_id = a.id_employee
        JOIN schedules s ON s.id_emp = e.scan_id AND  e.scan_id= $scanid
        JOIN date d ON d.id = s.id_date
        JOIN working_times w ON w.id = s.id_work_time
        where e.scan_id = a.id_employee AND a.tanggal = d.full_date  AND a.tanggal LIKE '$month%';
                        "));
       return $data;

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function importabsensi()
    {
        if ($request->hasFile('schedule')) {
            try{
               $data =  Excel::import(new \App\Imports\ScheduleImport, $request->file('schedule'));

            }
            catch(\Exception $e)
            {
                Alert::error('Error', $e->getMessage());
            }
        }
        else{
        }
        return redirect()->back();
    }
}
