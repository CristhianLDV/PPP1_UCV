<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceExport implements FromView
{
    protected $data;

    public function __construct($attendances)
    {
        $this->data = $attendances;
    }

    public function view(): View
    {
        return view('exports.attendances', [
            'attendances' => $this->data
        ]);
    }
}
