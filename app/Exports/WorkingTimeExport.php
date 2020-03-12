<?php

namespace App\Exports;

use App\WorkingTime;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkingTimeExport implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view(): View
    {
        return view('working_time.eksport', [
            'data' => WorkingTime::all()
        ]);
    }
}
