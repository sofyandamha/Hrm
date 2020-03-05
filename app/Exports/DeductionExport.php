<?php

namespace App\Exports;

use App\Deduction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DeductionExport implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        return view('payroll.deduction.eksport', [
            'data' => Deduction::all()
        ]);
    }
}
