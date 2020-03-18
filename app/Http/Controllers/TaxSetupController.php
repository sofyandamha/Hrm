<?php

namespace App\Http\Controllers;

use App\Symbol;
use App\Allowance;
use App\Deduction;
use App\Tax_setup;
use App\Late_config;
use Illuminate\Http\Request;
use App\Exports\TaxruleExport;
use App\Imports\TaxsetupImport;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class TaxSetupController extends Controller
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
        $taxsetup = Tax_setup::all();
        $symbol = Symbol::all();
        $lateconfig = Late_config::all();
        $allowance = Allowance::all();
        $deduction = Deduction::all();
        return view('payroll.index', compact('taxsetup','symbol','lateconfig','allowance','deduction'));
    }

    public function insertTaxsetup(Request $request)
    {
        $data = new Tax_setup();
        $data->tax_rule = $request->tax_rule;
        $data->tax_rate = $request->tax_rate;
        $data->id_symbol = $request->symbol;
        $data->save();

        return redirect()->route('show_taxsetup')->withInput(['tabName'=>'taxRule2']);
    }

    public function editTaxsetup($id)
    {
        $editTax = Tax_setup::find($id);
        $editSymbol = Symbol::all();
        return view('payroll.taxsetup.update', compact('editTax','editSymbol'));
    }

    public function updateTaxsetup(Request $request)
    {
        $data = Tax_setup::find($request->id);
        $data->tax_rule = $request->tax_rule;
        $data->tax_rate = $request->tax_rate;
        $data->id_symbol = $request->symbol;
        $data->save();

        return redirect()->route('show_taxsetup')->withInput(['tabName'=>'taxRule2']);
    }

    public function deleteTaxsetup($id)
    {
        $data = Tax_setup::find($id);
        $data->delete();
        return redirect()->back()->withInput(['tabName'=>'taxRule2']);
    }

    public function importTaxsetup(Request $request)
    {
        // dd($request->hasFile('namaStaff'));
        if ($request->hasFile('namaTax')) {
            try{
                Excel::import(new \App\Imports\TaxsetupImport, $request->file('namaTax'));
                // toast('Data Has Been Uploaded!','success');
            }
            catch(\Exception $e)
            {
                Alert::error('Error', $e->getMessage());
            }
        }
        else{
        }
        return redirect()->back()->withInput(['tabName'=>'taxRule2']);
    }

    public function eksportTaxsetup()
    {
        return Excel::download(new TaxruleExport, 'Taxrule.xlsx');
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
     * @param  \App\Tax_setup  $tax_setup
     * @return \Illuminate\Http\Response
     */
    public function show(Tax_setup $tax_setup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tax_setup  $tax_setup
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax_setup $tax_setup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tax_setup  $tax_setup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax_setup $tax_setup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tax_setup  $tax_setup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax_setup $tax_setup)
    {
        //
    }
}
