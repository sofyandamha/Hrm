<?php

namespace App\Exports;

use App\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        return view('employee.eksport', [
            'data' => Employee::all()
        ]);
    }
}
