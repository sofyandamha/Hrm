<?php

namespace App\Http\Controllers;

use App\Symbol;
use Illuminate\Http\Request;

class SymbolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Symbol::all();
        // return view('payroll.index', compact('data'));
    }

    public function insertSymbol(Request $request)
    {
        $data = new Symbol();
        $data->symbol_name = $request->symbol_name;
        $data->save();

        return redirect()->route('show_taxsetup')->withInput(['tabName'=>'symbol2']);
    }

    public function editSymbol($id)
    {
        $editSymbol = Symbol::find($id);
        return view('payroll.symbol.update', compact('editSymbol'));
    }

    public function updateSymbol(Request $request)
    {
        $data = Symbol::find($request->id);
        $data->symbol_name = $request->symbol_name;
        $data->save();

        return redirect()->route('show_taxsetup')->withInput(['tabName'=>'symbol2']);
    }

    public function deleteSymbol($id)
    {
        $data = Symbol::find($id);
        $data->delete();
        return redirect()->back()->withInput(['tabName'=>'symbol2']);
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
     * @param  \App\Symbol  $symbol
     * @return \Illuminate\Http\Response
     */
    public function show(Symbol $symbol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Symbol  $symbol
     * @return \Illuminate\Http\Response
     */
    public function edit(Symbol $symbol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Symbol  $symbol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Symbol $symbol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Symbol  $symbol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Symbol $symbol)
    {
        //
    }
}
