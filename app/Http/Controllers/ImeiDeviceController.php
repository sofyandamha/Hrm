<?php

namespace App\Http\Controllers;

use App\Employee;
use App\ImeiDevice;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

class ImeiDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\ImeiDevice  $imeiDevice
     * @return \Illuminate\Http\Response
     */
    public function show(ImeiDevice $imeiDevice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImeiDevice  $imeiDevice
     * @return \Illuminate\Http\Response
     */
    public function edit(ImeiDevice $imeiDevice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImeiDevice  $imeiDevice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImeiDevice $imeiDevice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImeiDevice  $imeiDevice
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImeiDevice $imeiDevice)
    {
        //
    }

    public function loginOtentikasiHrd()
    {
        // $loginType = filter_var(request('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';
        // $login = [
        //     $loginType => request('email'),
        //     'password' =>  request('password')
        // ];
        $loginType = Employee::where('nik', request('email'))->first();

        if (isset($loginType)) {
            
            $checkImei = ImeiDevice::where('id_employee', $loginType->id)->where('imei', request('imei'))->where('status', 1)->first();

            if(isset($checkImei)){
                return response()->json([
                    'success' => false,
                    'message' => 'Anda Sudah Terdaftar',
                ], 404);

            }else{
                $createImei = ImeiDevice::create([
                    'id_employee' => $loginType->id,
                    'imei' => request('imei'),
                    'device' => request('device'),
                    'status' => 1,
                    'created_at' => Carbon::now()
                ]);    
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Daftar',
                ], 200);
            }
        }
        else {
            //if authentication is unsuccessfull, notice how I return json parameters
            return response()->json([
                'success' => false,
                'message' => 'Anda Tidak Terdaftar',
            ], 404);
        }
    }

    public function loginUser(Request $request)
    {
        $dataNik = Employee::where('nik', $request->nikEmployee)->first();
        $tmpNik = $dataNik->id;
        $dataUser = Employee::whereHas('ImeiDevice', function($query) use ($tmpNik){
            $query->where('id_employee', $tmpNik);
            $query->where('status', 2);
        })->get();

        if(count($dataUser) > 0){
            return response()->json([
                'success' => true,
                'data' => $dataUser,
                'message' => 'Anda Terdaftar',
            ], 200);
        }else {
            return response()->json([
                'success' => false,
                'data' => $dataUser,
                'message' => 'Anda Belum Terdaftar',
            ], 404);
        }
    }

    public function getImei(Request $request){
        $nik = $request->nik;
        $imei = $request->imei;

        $nikEmployee = Employee::where('nik', $nik)->first();

        if(isset($nikEmployee->id)){
            $dataImei1 = ImeiDevice::where('id_employee', $nikEmployee->id)->where('device', $imei)->where('status', 1)->first();
            $dataImei2 = ImeiDevice::where('id_employee', $nikEmployee->id)->where('device', $imei)->where('status', 2)->first();

            if(isset($dataImei1)){
                return response()->json([
                    'status' => 406,
                    'success' => false,
                    'message' => 'Anda Sudah Terdaftar, Silakan Hubungi Hrd'
                ], 406);
            }elseif(isset($dataImei2)){
                $dataEmployee = Employee::where('id', $dataImei2->id_employee)->get();
                return response()->json([
                    'success' => true,
                    'data' => $dataEmployee,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'success' => false,
                    'message' => 'Data Tidak Ada',
                ], 404);
            }
        }else{
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Nik Anda Tidak Ada, Silakan Hubungi HRD',
            ], 401);
        }
    }

    public function getOtentikasiEmployee()
	{
        // $dataEmployee = Employee::whereDoesntHave('ImeiDevice')->orderBy('full_name', 'ASC')->get();
        $dataEmployee = ImeiDevice::with('Employee2')->where('status', 1)->get();
		if(count($dataEmployee) > 0){
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
        $id_employee = $request->id_employee;
        if($request->status == 0){
            $dataEmployee = ImeiDevice::where('id_employee', $id_employee)->where(function ($query){
                $query->where('status' , 1)->orWhere('status', 2);
            })->first();

            if(isset($dataEmployee)){
                // foreach($request->imei as $imeis){
                    $dataEmployee->delete();
                // }

                return response()->json([
                    'success' => true,
                    'message' => 'Delete Data Berhasil...',
                ], 200);
            }
        }else if($request->status == 1){
            $dataEmployee = ImeiDevice::where('id_employee', $id_employee)->where('status', 1)->first();

            if(isset($dataEmployee)){
                // foreach($request->imei as $imeis){
                    $dataEmployee->status = 2;
                    $dataEmployee->save();
                // }

                return response()->json([
                    'success' => true,
                    'message' => 'Register Berhasil...',
                ], 200);
            }
        } else if($request->status == 3){
            $dataEmployee = ImeiDevice::where('id_employee', $id_employee)->where('status', 2)->first();

            if(isset($dataEmployee)){
                // foreach($request->imei as $imeis){
                    $dataEmployee->status = 3;
                    $dataEmployee->save();
                // }

                return response()->json([
                    'success' => true,
                    'message' => 'Terminate Berhasil...',
                ], 200);
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Status Failed...',
            ], 404);
        }
    }

    public function getImeiApproved()
    {
        $dataEmployee = ImeiDevice::with('Employee2')->where('status', 2)->get();
		if(count($dataEmployee) > 0){
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
}
