<?php

namespace App\Exports;

use App\Student;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CertifiedStudentsExport implements FromView
{
    public function view() :View
    {
        $students = Student::where('certified', true)->get();
        return view('exports.certifiedStudents', compact('students'));
    }
}
