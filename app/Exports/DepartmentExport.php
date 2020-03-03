<?php

namespace App\Exports;

use App\Department;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class DepartmentExport implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        return view('department.eksport', [
            'data' => Department::all()
        ]);
    }
}
