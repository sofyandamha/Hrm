<?php

namespace App\Http\Controllers;

use App\Employee;
use Carbon\Carbon;
use App\LeaveDetEmp;
use Illuminate\Http\Request;

class APIFormController extends Controller
{
    public function formTgsLr(Request $request)
    {
        $year = Carbon::now()->format('Y');
        $id_emp = Employee::where('scan_id', $request->scan_id)->first();
        $leave_det_emp = LeaveDetEmp::create([
            'id_emp' => $id_emp->id,
            'id_leave_type' => $request->id_leave_type,
            'year' => $year,
            'start_leave' => $request->start_leave,
            'end_leave' => $request->end_leave,
            'remarks' => $request->remarks,
            'totalhari' => $request->total_hari,
            'det_tgl' => $request->det_tgl,
            'status' => 0,
        ]);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function formIznTdkMsk(Request $request)
    {

    }

    public function formAbsnMnl(Request $request)
    {
        # code...
    }
}
