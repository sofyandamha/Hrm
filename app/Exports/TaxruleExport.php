<?php

namespace App\Exports;

use App\Tax_setup;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TaxruleExport implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        return view('payroll.taxsetup.eksport', [
            'data' => Tax_setup::all()
        ]);
    }
}
