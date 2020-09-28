<?php

namespace App\Exports;

use DateTime;
use App\FormationSession;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OldStudentExport implements FromView
{
    public function view() :View
    {
        $fsessions = FormationSession::where('date_end', '<', new DateTime())->get();
        $students = [];
        foreach ($fsessions as $s) {
            $studentsOfThis = [];
            $studentsOfThis[] = $s->student()->orderBy('fname')->get();
            foreach ($studentsOfThis as $st) {
                foreach ($st as $i) $students[] = $i;
            }
        } 
        return view('exports.oldStudents', compact('students'));
    }
}
