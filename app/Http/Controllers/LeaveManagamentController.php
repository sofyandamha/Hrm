<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Schedule;
use Carbon\Carbon;
use App\Leave_type;
use App\LeaveDetEmp;
use Carbon\CarbonPeriod;
use App\Leave_managament;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LeaveManagamentController extends Controller
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

    public function index()
    {
        //
    }

    public function indexRequestapp(Request $request)
    {
        $user = Auth()->user();
        $roles = $user->roles->pluck('name');
        if ($roles[0] == "HRD Manager" || $roles[0] == "HRD Admin Supervisor")  {
            $data = LeaveDetEmp::orderBy('id_emp', 'desc');

            if ($request->has('page') ? $request->get('page') : 1) {
                $page    = $request->has('page') ? $request->get('page') : 1;
                $total   = $data->count();
                $perPage = 10;
                $showingTotal  = $page * $perPage;

                $currentShowing = $showingTotal > $total ? $total : $showingTotal;
                $showingStarted = $showingTotal - $perPage;
                $tableinfo = "Showing $showingStarted to $currentShowing of $total entries";
            }

            $data = $data->paginate($perPage);
            $data->appends($request->all());

            return view('leave.request.index', compact('data','tableinfo','perPage','page'));

        } else {
            $id = Auth()->user()->id;
            $empData = Employee::find($id);
            $EmpDet = Employee::find(auth()->user()->id);
            if ($empData->is_supervisor == 1) {
                $idEmp = Employee::select('id')->where('id_designation', $empData->id_designation)->get();
                // dd($idEmp);
                $dataSpv = LeaveDetEmp::whereIn('id_emp', $idEmp);
                // dd($dataSpv->get());
                if ($request->has('page') ? $request->get('page') : 1) {
                    $page    = $request->has('page') ? $request->get('page') : 1;
                    $total   = $dataSpv->count();
                    $perPage = 10;
                    $showingTotal  = $page * $perPage;

                    $currentShowing = $showingTotal > $total ? $total : $showingTotal;
                    $showingStarted = $showingTotal - $perPage;
                    $tableinfo = "Showing $showingStarted to $currentShowing of $total entries";
                }

                $dataSpv = $dataSpv->paginate($perPage);
                $dataSpv->appends($request->all());

                return view('leave.request.index', compact('dataSpv','tableinfo','perPage','page','EmpDet'));
            }
            else{
                $dataSingle = LeaveDetEmp::where('id_emp', auth()->user()->id);
                $EmpDet = Employee::find(auth()->user()->id);
                if ($request->has('page') ? $request->get('page') : 1) {
                    $page    = $request->has('page') ? $request->get('page') : 1;
                    $total   = $dataSingle->count();
                    $perPage = 10;
                    $showingTotal  = $page * $perPage;

                    $currentShowing = $showingTotal > $total ? $total : $showingTotal;
                    $showingStarted = $showingTotal - $perPage;
                    $tableinfo = "Showing $showingStarted to $currentShowing of $total entries";
                }

                $dataSingle = $dataSingle->paginate($perPage);
                $dataSingle->appends($request->all());

                return view('leave.request.index', compact('dataSingle','tableinfo','perPage','page','EmpDet'));

            }

        }


    }

    public function indexLeavereport()
    {
        dd(true);
    }

    public function addRequestapp()
    {
        $employee = Employee::all();
        $leave_type = Leave_type::whereIn('id', ["1","2","3","4","7","8"])->get();
        $getTotalCuti = LeaveDetEmp::groupBy('id_emp','status', 'year')
        ->selectRaw('sum(totalhari) as total')
        ->where('status', 1)
        ->where('year', date('Y'))
        ->where('id_emp', Auth()->user()->id)
        ->first();
        $totalCuti = isset($getTotalCuti->total) ? $getTotalCuti->total : 0;
        // dd($leave_type);
        return view('leave.request.add', compact('employee','leave_type','totalCuti'));
    }
    public function checkRequestapp(Request $request)
    {
        // dd($request->all());
        $year = date('Y');
        $datenow = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $date = explode(' - ', $request->leave_date);
        $from = Carbon::createFromFormat('Y-m-d', $date[0]);
        $fromTwo = Carbon::createFromFormat('Y-m-d', $date[0]);
        $to = Carbon::createFromFormat('Y-m-d', $date[1]);
        $diff_in_days = $from->diffInDays($to) + 1;

        $all_dates = array();
        while ($from->lte($to)){
            $all_dates[] = $from->toDateString();
            $from->addDay();
        }

        $checkHmin = $datenow->diffInDays($fromTwo);
        if ($request->leave_type_id == 3 || $request->leave_type_id == 2) {
            if ($checkHmin >= 7) {
               if ($request->leave_type_id == 3) {
                $getTotalCuti = LeaveDetEmp::groupBy('id_emp','status', 'year')
                            ->selectRaw('sum(totalhari) as total')
                            ->where('status', 1)
                            ->where('year', date('Y'))
                            ->where('id_emp', $request->employee_id)
                            ->first();
                if (!isset($getTotalCuti)) { // klo data ga ada
                    $data = new LeaveDetEmp();
                    $data->id_emp = $request->employee_id;
                    $data->id_leave_type= $request->leave_type_id;
                    $data->start_leave= $date[0];
                    $data->end_leave=  $date[1];
                    $data->year= $year;
                    $data->remarks= $request->remak;
                    $data->totalhari= $diff_in_days;
                    $data->det_tgl = json_encode($all_dates);
                    // $data->det_tgl = str_replace('"', '', json_encode($all_dates));
                    $data->status= 0;
                    $data->created_by= auth()->user()->id;

                    $data->save();
                    return redirect()->route('show_requestApp');
                } else { // klo ada
                  $sisaCuti = 12 - $getTotalCuti->total;
                  $checkCuti = $sisaCuti - $diff_in_days;
                  if ($checkCuti < 0) {
                    Alert::info('Info', "Sisa Cuti Tahun ".$year." = ".$sisaCuti);
                    return redirect()->back();
                  } else {
                    $data = new LeaveDetEmp();
                    $data->id_emp = $request->employee_id;
                    $data->id_leave_type= $request->leave_type_id;
                    $data->start_leave= $date[0];
                    $data->end_leave=  $date[1];
                    $data->year= $year;
                    $data->remarks= $request->remak;
                    $data->totalhari= $diff_in_days;
                    $data->det_tgl = json_encode($all_dates);
                    // $data->det_tgl = str_replace('"', '', json_encode($all_dates));
                    $data->status= 0;
                    $data->created_by= auth()->user()->id;

                    $data->save();
                    return redirect()->route('show_requestApp');
                  }

                }

            } else {
                $data = new LeaveDetEmp();
                $data->id_emp = $request->employee_id;
                $data->id_leave_type= $request->leave_type_id;
                $data->start_leave= $date[0];
                $data->end_leave=  $date[1];
                $data->year= $year;
                $data->remarks= $request->remak;
                $data->totalhari= $diff_in_days;
                $data->det_tgl = json_encode($all_dates);
                // $data->det_tgl = str_replace('"', '', json_encode($all_dates));
                $data->status= 0;
                $data->created_by= auth()->user()->id;

                $data->save();
                return redirect()->route('show_requestApp');
            }
            } else {
                Alert::info('Info', "Pengajuan Maxs H-7");
                return redirect()->back();
            }

        } else {
            $data = new LeaveDetEmp();
            $data->id_emp = $request->employee_id;
            $data->id_leave_type= $request->leave_type_id;
            $data->start_leave= $date[0];
            $data->end_leave=  $date[1];
            $data->year= $year;
            $data->remarks= $request->remak;
            $data->totalhari= $diff_in_days;
            $data->det_tgl = json_encode($all_dates);
            // $data->det_tgl = str_replace('"', '', json_encode($all_dates));
            $data->status= 0;
            $data->created_by= auth()->user()->id;

            $data->save();
            return redirect()->route('show_requestApp');
        }
    }

    public function insertRequestapp(Request $request)
    {
        $data = new Leave_managament();
        $data->id_employee = $request->employee_name;
        $data->id_leave_type = $request->leave_type;
        $data->start_leave = $request->start_leave;
        $data->end_leave = $request->end_leave;
        $data->remak = $request->remak;
        $data->status = 0;

        $data->save();
        return redirect()->route('show_requestApp');
    }

    public function editRequestapp($id)
    {
        $edit_requestApp = Leave_managament::find($id);
        $leave_type = Leave_type::all();
        $employee = Employee::all();

        return view('leave.request.update', compact('edit_requestApp','leave_type','employee'));
    }

    public function updateRequestapp(Request $request)
    {
        // $data = Leave_managament::find($request->leave_id);
    }

    public function deleteRequestapp($id)
    {
        // dd($id);
        $data = Leave_managament::find($id);
        $data->delete();

        return redirect()->back();
    }

   public function approvedRequestapp($id)
   {
        $year = date('Y');
        $getLeaveData = LeaveDetEmp::where('id', $id)->first();
        $getTotalCuti = LeaveDetEmp::groupBy('id_emp','status', 'year')
            ->selectRaw('sum(totalhari) as total')
            ->where('status', 1)
            ->where('year', date('Y'))
            ->where('id_emp', $getLeaveData->id_emp)
            ->first();
        if ($getLeaveData->id_leave_type == 3) {
            if (!isset($getTotalCuti)) {
                $getLeaveData->status = 1; //Approved
                $getLeaveData->approved_by = Auth()->user()->id;
                $getLeaveData->approved_at = now();
                $getLeaveData->updated_by = Auth()->user()->id;
                $getLeaveData->save();

                $dateSched = json_decode($getLeaveData->det_tgl);
                $dataEmp = Employee::find($getLeaveData->id_emp);
                $dataSched = Schedule::select('id')->where('id_emp', $dataEmp->scan_id )->whereIn('date_work', $dateSched)->get();
                foreach ($dataSched as $row) {
                    Schedule::where('id', $row->id)
                    ->update([
                        'status' => $getLeaveData->id_leave_type
                        ]);
                }

            }else{
                $sisaCuti = 12 - $getTotalCuti->total;
                $from = Carbon::createFromFormat('Y-m-d', $getLeaveData->start_leave);
                $to = Carbon::createFromFormat('Y-m-d', $getLeaveData->end_leave);
                $diff_in_days = $from->diffInDays($to) + 1;
                $checkCuti = $sisaCuti - $diff_in_days;
                if ($checkCuti < 0) {
                    Alert::info('Info', "Sisa Cuti Hanya ".$sisaCuti.". Data Rejected");
                    $getLeaveData->status = 2; //Rejected
                    $getLeaveData->approved_by = Auth()->user()->id;
                    $getLeaveData->approved_at = now();
                    $getLeaveData->updated_by = Auth()->user()->id;
                    $getLeaveData->save();
                } else {
                    $getLeaveData->status = 1; //Approved
                    $getLeaveData->approved_by = Auth()->user()->id;
                    $getLeaveData->approved_at = now();
                    $getLeaveData->updated_by = Auth()->user()->id;
                    $getLeaveData->save();

                    $dateSched = json_decode($getLeaveData->det_tgl);
                    $dataEmp = Employee::find($getLeaveData->id_emp);
                    $dataSched = Schedule::select('id')->where('id_emp', $dataEmp->scan_id )->whereIn('date_work', $dateSched)->get();
                    foreach ($dataSched as $row) {
                        Schedule::where('id', $row->id)
                        ->update([
                            'status' => $getLeaveData->id_leave_type
                            ]);
                    }
                }
            }
        } else {
            $getLeaveData->status = 1; //Approved
            $getLeaveData->approved_by = Auth()->user()->id;
            $getLeaveData->approved_at = now();
            $getLeaveData->updated_by = Auth()->user()->id;
            $getLeaveData->save();

            $dateSched = json_decode($getLeaveData->det_tgl);
            $dataEmp = Employee::find($getLeaveData->id_emp);
            $dataSched = Schedule::select('id')->where('id_emp', $dataEmp->scan_id )->whereIn('date_work', $dateSched)->get();
            foreach ($dataSched as $row) {
                Schedule::where('id', $row->id)
                ->update([
                    'status' => $getLeaveData->id_leave_type
                    ]);
            }
        }
        return redirect()->route('show_requestApp');
   }

   public function rejectedRequestapp($id)
   {
        $data = LeaveDetEmp::find($id);
        $data->status = 2; //Rejected
        $data->approved_by = Auth()->user()->id;
        $data->approved_at = date('Y-m-d H:i');
        $data->updated_by = Auth()->user()->id;
        $data->save();
        return redirect()->route('show_requestApp');
   }

   public function cancel_requestApp($id)
   {
        $data = LeaveDetEmp::find($id);
        $data->status = 0; //Pending
        $data->approved_by = null;
        $data->approved_at = null;
        $data->updated_by = null;
        $data->save();

        $dateSched = json_decode($data->det_tgl);
        $dataEmp = Employee::find($data->id_emp);
        $dataSched = Schedule::select('id')->where('id_emp', $dataEmp->scan_id )->whereIn('date_work', $dateSched)->get();
        foreach ($dataSched as $row) {
            Schedule::where('id', $row->id)
            ->update([
                'status' => 0
                ]);
        }
        return redirect()->route('show_requestApp');
   }


}
