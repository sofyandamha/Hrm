<?php

namespace App\Http\Controllers;

use App\Employee;
use Carbon\Carbon;
use App\Leave_type;
use App\LeaveDetEmp;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;

class APIFormController extends Controller
{
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

        // dd($selisih_tgl);

        if($request->id_leave_type == 2 || $request->id_leave_type == 3 || $request->id_leave_type == 4){
            if($selisih_tgl >= 7 || $selisih_tgl == 0){
                if($request->id_leave_type == 3){
                    $getTotalCuti = LeaveDetEmp::groupBy('id_emp','status', 'year')
                                    ->selectRaw('sum(totalhari) as total')
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

        return $data;
    }

    public function getHistoryForm(Request $request)
    {
        $id_emp = Employee::where('scan_id', $request->scan_id)->first();
        $dataHistoryForm = LeaveDetEmp::where('id_emp', $id_emp->id)->get();

        return $dataHistoryForm;
    }
}
