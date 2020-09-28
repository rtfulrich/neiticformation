<?php

namespace App\Http\Controllers;

use App\FormationSession;
use App\Student;
use DateTime;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function welcomeToApp() {
        return redirect('/login');
    }

    public function index()
    {
        $actualSessions = FormationSession::where('date_end', null)->orWhere('date_end', '>=', new DateTime())->get();
        $actualStudents = [];
        foreach ($actualSessions as $s) {
            $studentsOfThis = [];
            $studentsOfThis[] = $s->student()->orderBy('fname')->get();
            foreach ($studentsOfThis as $st) {
                foreach ($st as $i) $actualStudents[] = $i;
            }
        }
        $actualStudentsCount = count($actualStudents);

        $oldSessions = FormationSession::where('date_end', '<', new DateTime())->get();
        $oldStudents = [];
        foreach ($oldSessions as $s) {
            $studentsOfThis = [];
            $studentsOfThis[] = $s->student()->orderBy('fname')->get();
            foreach ($studentsOfThis as $st) {
                foreach ($st as $i) $oldStudents[] = $i;
            }
        }
        $oldStudentsCount = count($oldStudents);
        $certifiedStudentsCount = StudentController::certifiedStudentsCount();
        $studentsWithFeeProblems = FeeController::studentsWithFeeProblems('count');
        $countActualSessions = FormationSessionController::countActualSessions();

        return view('home', compact('actualStudentsCount', 'oldStudentsCount','certifiedStudentsCount','studentsWithFeeProblems','countActualSessions'));
    }

}
