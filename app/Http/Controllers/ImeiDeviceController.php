<?php

namespace App\Http\Controllers;

use App\Employee;
use App\ImeiDevice;
use Illuminate\Http\Request;
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
        $loginType = filter_var(request('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';
        $login = [
            $loginType => request('email'),
            'password' =>  request('password')
        ];
        if (Auth::attempt($login)) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'data' => [ $user ],
            ]);
        }
        else {
            //if authentication is unsuccessfull, notice how I return json parameters
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
    }

    public function loginUser(Request $request)
    {
        $dataNik = Employee::where('nik', $request->nikEmployee)->first();
        $tmpNik = $dataNik->id;
        $dataUser = Employee::whereHas('ImeiDevice', function($query) use ($tmpNik){
            $query->where('id_employee', $tmpNik);
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
        $imei = $request->imei;
        
        $dataImei = ImeiDevice::where('imei', $imei)->first();
        
        if(isset($dataImei)){
            $dataEmployee = Employee::where('id', $dataImei->id_employee)->get();
            return response()->json([
                'success' => true,
                'data' => $dataEmployee,
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ada',
            ], 404);
        }
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
			// foreach($request->imei as $imeis){
				$dataImei = ImeiDevice::create([
					'id_employee' => $dataEmployee->id,
					'imei' => $request->imei,
				]);
			// }

			return response()->json([
				'success' => true,
				'message' => 'Register Berhasil...',
			], 200);
		}
	}
}
