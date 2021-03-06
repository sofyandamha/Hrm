<?php

namespace App\Http\Controllers;

use App\LngLat;
use App\Employee;
use Carbon\Carbon;
use App\Leave_type;
use App\LeaveDetEmp;
use App\AttLogAndroid;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class APIFormController extends Controller
{

    public function generateNoImage()
    {
        $year_month = Carbon::now()->format("ym");
        $lastDate = LeaveDetEmp::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $lastNoProc = isset($lastDate->no_procurement) ? $lastDate->no_procurement : 'SAKIT'.$year_month.'000';
        $strReplace = str_replace('SAKIT','',$lastNoProc);
        if (substr($strReplace, -1) == 'A') {
            $strReplace = str_replace('A', '', $strReplace);
        }

        return 'SAKIT'.($strReplace + 1);
    }

    public function formTgsLr(Request $request)
    {
        $year = Carbon::now()->format('Y');
        $datenow = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $id_emp = Employee::where('scan_id', $request->scan_id)->first();
        $from =  Carbon::createFromFormat('Y-m-d', $request->start_leave);
        $to =  Carbon::createFromFormat('Y-m-d', $request->end_leave);
        $all_dates = array();
        while ($from->lte($to)){
            $all_dates[] = $from->toDateString();
            $from->addDay();
        }

        $dateStart = Carbon::createFromFormat('Y-m-d', $request->start_leave);

        // $selisih_tgl = $datenow->diffInDays($request->start_leave);
        $selisih_tgl = $dateStart->diffInDays($datenow);

        if ($request->file) {
            $file_name = $this->generateNoImage().'.'.'png';
            \File::put(public_path('assets/images/leave'). '/' . $file_name, base64_decode($request->file));

        }else{
            $file_name = "";
        }

        // dd($file_name);

        // dd($selisih_tgl);

        if($request->id_leave_type == 2 || $request->id_leave_type == 3 || $request->id_leave_type == 4){
            if($selisih_tgl >= 7 || $selisih_tgl == 0){
                if($request->id_leave_type == 3){
                    $getTotalCuti = LeaveDetEmp::groupBy('id_emp','status', 'year')
                                    ->selectRaw('sum(totalhari) as total')
                                    ->where('id_leave_type', 3)
                                    ->where('status', 1)
                                    ->where('year', date('Y'))
                                    ->where('id_emp', $id_emp->id)
                                    ->first();
                    if(!isset($getTotalCuti)){
                        $data = new LeaveDetEmp();
                        $data->id_emp = $id_emp->id;
                        $data->id_leave_type= $request->id_leave_type;
                        $data->start_leave= $request->start_leave;
                        $data->end_leave=  $request->end_leave;
                        $data->year= $year;
                        $data->remarks= $request->remarks;
                        $data->totalhari= $request->total_hari;
                        $data->det_tgl = json_encode($all_dates);
                        $data->foto = $file_name;
                        $data->status= 0;
                        $data->save();
                        return response()->json([
                            'success' => true,
                        ], 200);
                    }else{
                        $sisa_cuti = 12 - $getTotalCuti->total;
                        $tmp_cuti = $sisa_cuti - $request->total_hari;
                        if($tmp_cuti < 0){
                            return response()->json([
                                'success' => true,
                                'message' => 'Sisa Cuti Tahun '.$year.' = '.$sisa_cuti
                            ], 401);
                        }else{
                            $data = new LeaveDetEmp();
                            $data->id_emp = $id_emp->id;
                            $data->id_leave_type= $request->id_leave_type;
                            $data->start_leave= $request->start_leave;
                            $data->end_leave=  $request->end_leave;
                            $data->year= $year;
                            $data->remarks= $request->remarks;
                            $data->totalhari= $request->total_hari;
                            $data->det_tgl = json_encode($all_dates);
                            $data->foto = $file_name;
                            $data->status= 0;
                            $data->save();

                            return response()->json([
                                'success' => true,
                                'message' => 'yes2'
                            ], 200);
                        }
                    }
                }else{
                    $leave_det_emp = LeaveDetEmp::create([
                        'id_emp' => $id_emp->id,
                        'id_leave_type' => $request->id_leave_type,
                        'year' => $year,
                        'start_leave' => $request->start_leave,
                        'end_leave' => $request->end_leave,
                        'remarks' => $request->remarks,
                        'totalhari' => $request->total_hari,
                        'det_tgl' => json_encode($all_dates),
                        'foto' => $file_name,
                        'status' => 0,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'yes'
                    ], 200);
                }
            }else{
                return response()->json([
                        'success' => true,
                        'message' => "Pengajuan Maxs H-7",
                    ], 401);
            }
        }else{
            $leave_det_emp = LeaveDetEmp::create([
                'id_emp' => $id_emp->id,
                'id_leave_type' => $request->id_leave_type,
                'year' => $year,
                'start_leave' => $request->start_leave,
                'end_leave' => $request->end_leave,
                'remarks' => $request->remarks,
                'totalhari' => $request->total_hari,
                'det_tgl' => json_encode($all_dates),
                'foto' => $file_name,
                'status' => 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'yes3'
            ], 200);
        }
    }

    public function getLeaveType()
    {
        $data = Leave_type::where('id', '!=', 5)->get();

        if(count($data) > 0){
            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "Data Tidak Ada",
            ], 404);
        }
    }

    public function getHistoryForm(Request $request)
    {
        $id_emp = Employee::where('scan_id', $request->scan_id)->first();
        $dataHistoryForm = LeaveDetEmp::where('id_emp', $id_emp->id)->get();

        if(count($dataHistoryForm) > 0){
            return response()->json([
                'success' => true,
                'data' => $dataHistoryForm,
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "Data Tidak Ada",
            ], 404);
        }
    }

    public function getAttendanceNow(Request $request)
    {
        // dd($request->tgl);
        $scanid = $request->nik;
        $tgl = $request->tgl;
        $data = DB::select(DB::raw("
        SELECT src.nik, src.tgl, min(src.ScanMasuk) AS scanIn, max(src.ScanKeluar)AS scanOut FROM (
            SELECT nik, STR_TO_DATE(scan_at, '%Y-%m-%d') AS tgl,
                case
                    when STATUS = 0 then DATE_FORMAT(STR_TO_DATE(scan_at, '%Y-%m-%d %H:%i:%s'), '%H:%i:%s')
                END AS 'ScanMasuk',
                case
                    when STATUS = 1 then DATE_FORMAT(STR_TO_DATE(scan_at, '%Y-%m-%d %H:%i:%s'), '%H:%i:%s')
                END AS 'ScanKeluar'
                FROM attlog_android GROUP BY nik, scan_at, STATUS
                ) src
                WHERE src.nik = $scanid AND src.tgl = '$tgl'
                GROUP BY src.nik, src.tgl
        "));
        if(count($data) > 0){
            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ada',
            ], 404);
        }
    }

    public function getLngLat(Request $request)
    {
        $scanid = $request->nik;
        $dataEmp =  Employee::where('nik',  $scanid)->first();
        if(isset($dataEmp)){
            $dataLocation = LngLat::find($dataEmp->location_office_id);
            return response()->json([
                'success' => true,
                'data' => [$dataLocation],
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data Tida Ada',
            ],404);
        }
        return $dataLocation;
    }

    public function signIn(Request $request)
    {
        if(isset($request->nik) || isset($request->scan_at) || isset($request->lat) || isset($request->long)){
            $data =  AttLogAndroid::create([
                "nik"=> $request->nik,
                "id_location_office" => $request->idLoc,
                "scan_at"=> $request->scan_at,
                "latitude"=> $request->lat,
                "longtitude"=> $request->long,
                "status"=> 0,
            ]);

            return response()->json([
                'success' => true,
                'scan_at' => Carbon::parse($request->scan_at)->toTimeString(),
                'message' => 'Scan Berhasil',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Scan Gagal',
            ], 404);
        }
    }

    public function scanBarcodeIn(Request $request)
    {
        if(isset($request->nik) || isset($request->scan_at) || isset($request->lat) || isset($request->long)){
            $data =  AttLogAndroid::create([
                "nik"=> $request->nik,
                "id_location_office" => $request->idLoc,
                "scan_at"=> $request->scan_at,
                "latitude"=> $request->lat,
                "longtitude"=> $request->long,
                "status"=> 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Scan Berhasil',
                'scan_at' => Carbon::parse($request->scan_at)->toTimeString(),
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Scan Gagal',
            ], 404);
        }
    }

    public function signOut(Request $request)
    {

        if(isset($request->nik) || isset($request->scan_at) || isset($request->lat) || isset($request->long)){
            $data =  AttLogAndroid::create([
                "nik"=> $request->nik,
                "id_location_office" => $request->idLoc,
                "scan_at"=> $request->scan_at,
                "latitude"=> $request->lat,
                "longtitude"=> $request->long,
                "status"=> 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Scan Berhasil',
                'scan_at' => Carbon::parse($request->scan_at)->toTimeString(),
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Scan Gagal',
            ], 404);
        }
    }

    public function scanBarcodeOut(Request $request)
    {
        if(isset($request->nik) || isset($request->scan_at) || isset($request->lat) || isset($request->long)){
            $data =  AttLogAndroid::create([
                "nik"=> $request->nik,
                "id_location_office" => $request->idLoc,
                "scan_at"=> $request->scan_at,
                "latitude"=> $request->lat,
                "longtitude"=> $request->long,
                "status"=> 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Scan Berhasil',
                'scan_at' => Carbon::parse($request->scan_at)->toTimeString(),
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Scan Gagal',
            ], 404);
        }
    }

    public function changePassword(Request $request)
    {
        $user = Employee::where('scan_id', $request->nikEmployee)->first();
        if (Hash::check($request->oldPassword, $user->password)) {
            $user->update(['password' => Hash::make($request->password)]);
            $response = [
                'status' => 'Success',
                'message' => 'Successfully Password Changed',
            ];
        } else {
            $response = [
                'status' => 'Fail',
                'message' => 'Password does not match',
            ];
        }

        return response()->json($response);
    }

    public function getEmployeeAbsenScan()
    {
        $dataEmployee = Employee::groupBy('full_name')->get();
        if(count($dataEmployee)>0){
            return response()->json([
                'success' => true,
                'data' => $dataEmployee,
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'data' => $dataEmployee,
            ], 404);
        }
    }
    
}
