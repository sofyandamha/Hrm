<?php

namespace App\Exports;

use App\Allowance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AllowanceExport implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        return view('payroll.allowance.eksport', [
            'data' => Allowance::all()
        ]);
    }
}
