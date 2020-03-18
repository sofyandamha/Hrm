<?php

namespace App\Http\Controllers;

use App\Symbol;
use App\Allowance;
use Illuminate\Http\Request;
use App\Exports\AllowanceExport;
use App\Imports\AllowanceImport;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class AllowanceController extends Controller
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

    public function insertAllowance(Request $request)
    {
        $data = new Allowance();
        $data->allowance_name = $request->allowance_name;
        $data->allowance_amount = $request->allowance_amount;
        $data->id_symbol = $request->symbol;
        $data->save();

        return redirect()->route('show_taxsetup')->withInput(['tabName'=>'allowance2']);
    }

    public function editAllowance($id)
    {
        $editAllowance = Allowance::find($id);
        $editSymbol = Symbol::all();
        return view('payroll.allowance.update', compact('editAllowance','editSymbol'));
    }

    public function updateAllowance(Request $request)
    {
        $data = Allowance::find($request->id);
        $data->allowance_name = $request->allowance_name;
        $data->allowance_amount = $request->allowance_amount;
        $data->id_symbol = $request->symbol;
        $data->save();

        return redirect()->route('show_taxsetup')->withInput(['tabName'=>'allowance2']);
    }

    public function deleteAllowance($id)
    {
        $data = Allowance::find($id);
        $data->delete();
        return redirect()->back()->withInput(['tabName'=>'allowance2']);
    }

    public function importAllowance(Request $request)
    {
        // dd($request->hasFile('namaStaff'));
        if ($request->hasFile('namaAllowance')) {
            try{
                Excel::import(new \App\Imports\AllowanceImport, $request->file('namaAllowance'));
                // toast('Data Has Been Uploaded!','success');
            }
            catch(\Exception $e)
            {
                Alert::error('Error', $e->getMessage());
            }
        }
        else{
        }
        return redirect()->back()->withInput(['tabName'=>'allowance2']);
    }

    public function eksportAllowance()
    {
        return Excel::download(new AllowanceExport, 'Allowance.xlsx');
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
     * @param  \App\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function show(Allowance $allowance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function edit(Allowance $allowance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Allowance $allowance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Allowance $allowance)
    {
        //
    }
}
