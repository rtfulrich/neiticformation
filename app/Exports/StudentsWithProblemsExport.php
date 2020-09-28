<?php

namespace App\Exports;

use App\Student;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\FeeController;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsWithProblemsExport implements FromView// FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /*public function collection()
    {
        return collect(FeeController::studentsWithFeeProblems('get'));
    }

    public function headings(): array
    {
        return [
            'id',
            'formation_session_id',
            'fname',
            'lname',
            'email',
            'phone', 
            'address',
            'birth_date',
            'cin', 
            'sex',
            'photo',
            'machine_number',
            'actual_job',
            'family_situation',
            'children_number', 
            'study_level',
            'school_fee_paid',
            'certified',
            'certified_at',
            'created_at',
            'updated_at'
        ];
    }*/

    public function view(): View
    {
        return view('exports.studentsWithProblems', [
            'students' => FeeController::studentsWithFeeProblems('get')
        ]);
    }
}
