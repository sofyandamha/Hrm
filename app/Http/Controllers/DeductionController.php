<?php

namespace App\Http\Controllers;

use App\Symbol;
use App\Deduction;
use Illuminate\Http\Request;
use App\Exports\DeductionExport;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class DeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function insertDeduction(Request $request)
    {
        $data = new Deduction();
        $data->deduction_name = $request->deduction_name;
        $data->deduction_amount = $request->deduction_amount;
        $data->id_symbol = $request->symbol;
        $data->save();

        return redirect()->route('show_taxsetup')->withInput(['tabName'=>'deduction2']);
    }

    public function editDeduction($id)
    {
        $editDeduction = Deduction::find($id);
        $editSymbol = Symbol::all();
        return view('payroll.deduction.update', compact('editDeduction','editSymbol'));
    }

    public function updateDeduction(Request $request)
    {
        $data = Deduction::find($request->id);
        $data->deduction_name = $request->deduction_name;
        $data->deduction_amount = $request->deduction_amount;
        $data->id_symbol = $request->symbol;
        $data->save();

        return redirect()->route('show_taxsetup')->withInput(['tabName'=>'deduction2']);
    }

    public function deleteDeduction($id)
    {
        $data = Deduction::find($id);
        $data->delete();
        return redirect()->back()->withInput(['tabName'=>'deduction2']);
    }

    public function importDeduction(Request $request)
    {
        // dd($request->hasFile('namaStaff'));
        if ($request->hasFile('namaDeduction')) {
            try{
                Excel::import(new \App\Imports\DeductionImport, $request->file('namaDeduction'));
                // toast('Data Has Been Uploaded!','success');
            }
            catch(\Exception $e)
            {
                Alert::error('Error', $e->getMessage());
            }
        }
        else{
        }
        return redirect()->back()->withInput(['tabName'=>'deduction2']);
    }

    public function eksportDeduction()
    {
        return Excel::download(new DeductionExport, 'Deduction.xlsx');
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
     * @param  \App\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function show(Deduction $deduction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function edit(Deduction $deduction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deduction $deduction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deduction $deduction)
    {
        //
    }
}
