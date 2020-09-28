<?php

namespace App\Http\Controllers;

use App\FormationSession;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    
    public function index() 
    {
        // $dateMiddle = $this->getMiddleOfTwoDates($fsession->date_debut, $fsession->date_end);
        // echo $dateMiddle; OK

        // dd($fsession->student()->where('certified', true)->get()); OK
        
        $students = self::studentsWithFeeProblems('get');
        return view('fees.home', compact('students'));
    }

    public static function studentsWithFeeProblems(string $resultType)
    {
        $arrayStudents = [];
        $arrayStudents[] = (new self)->studentsWithFeeProblemsAfterMiddleOfSession();
        $arrayStudents[] = (new self)->studentsWithFeeProblemsAfterFullOfSession();
        $students = [];
        foreach ($arrayStudents as $array) {
            foreach ($array as $item) {
                $students[] = $item;
            }
        }
        if ($resultType === 'get') return $students;
        elseif ($resultType === 'count') return count($students);
        else throw new Exception('FeeController::studentWithProblems parameter should be one of "get" or "count" !!!');
    }

    private function studentsWithFeeProblemsAfterMiddleOfSession()
    {
        $fsessions = FormationSession::where('date_end', '>=', new DateTime())->get();
        $arrayStudents = [];
        $students = [];
        foreach ($fsessions as $fsession) {
            $date_debut = $fsession->date_debut;
            $date_end = $fsession->date_end;
            $middle_date = (new self)->getMiddleOfTwoDates($date_debut, $date_end); //dd($middle_date);
            if ($middle_date < new DateTime()) // echo 'middle is future : '.$middle_date; else echo 'middle is passed : ' .$middle_date; exit();
                $arrayStudents[] = $fsession->student()->where('school_fee_paid', '<', $fsession->fee / 2)->get();
        }
        foreach ($arrayStudents as $array) {
            foreach ($array as $item) {
                $students[] = $item;
            }
        }
        foreach ($students as $student) {
            $student->dateLateGo = (new DateTime($middle_date))->format('d/m/Y');
            $student->lateDuration = $middle_date->diffForHumans(new DateTime());
            $student->lateStatus = '1ere tranche';
        } 
        return $students;
    }

    private function studentsWithFeeProblemsAfterFullOfSession()
    {
        $fsessions = FormationSession::where('date_end', '<=', new DateTime())->get();
        $arrayStudents = [];
        $students = [];
        foreach ($fsessions as $fsession) {
            // $date_debut = $fsession->date_debut;
            $date_end = $fsession->date_end;
            // $middle_date = (new self)->getMiddleOfTwoDates($date_debut, $date_end);
            if ($date_end < new DateTime())
                $arrayStudents[] = $fsession->student()->where('school_fee_paid', '<', $fsession->fee)->get();
        }
        foreach ($arrayStudents as $array) {
            foreach ($array as $item) {
                $students[] = $item;
            }
        }
        foreach ($students as $student) {
            $date_end = $student->formationSession->date_end;
            $student->dateLateGo = (new DateTime($date_end))->format('d/m/Y');
            $student->lateDuration = Carbon::parse($date_end)->diffForHumans(now());
            $student->lateStatus = 'Session entière';
        }
        return $students;
    }

    private function getMiddleOfTwoDates($dateDebut, $dateEnd) 
    {
        $debutYear = (new DateTime($dateDebut))->format('Y');
        $debutMonth = (new DateTime($dateDebut))->format('m');
        $debutDay = (new DateTime($dateDebut))->format('d');
        $endYear = (new DateTime($dateEnd))->format('Y');
        $endMonth = (new DateTime($dateEnd))->format('m');
        $endDay = (new DateTime($dateEnd))->format('d');

        $date_debut = Carbon::create($debutYear, $debutMonth, $debutDay);
        $date_end = Carbon::create($endYear, $endMonth, $endDay);
        $diffDays = $date_end->diffInDays($date_debut);
        $halfDiffDays = round($diffDays / 2);
        $dateMiddle = $date_debut->addDays($halfDiffDays);
        return $dateMiddle;
    }

}
