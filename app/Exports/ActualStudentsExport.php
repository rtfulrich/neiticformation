<?php

namespace App\Exports;

use App\FormationSession;
use DateTime;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ActualStudentsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }

    public function view(): View
    {
        $fsessions = FormationSession::where('date_end', null)->orWhere('date_end', '>=', new DateTime())->get();
        $students = [];
        foreach ($fsessions as $s) {
            $studentsOfThis = [];
            $studentsOfThis[] = $s->student()->orderBy('fname')->get();
            foreach ($studentsOfThis as $st) {
                foreach ($st as $i) $students[] = $i;
            }
        }
        return view('exports.actualStudents', compact('students'));
    }
}
