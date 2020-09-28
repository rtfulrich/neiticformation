<?php

namespace App\Http\Controllers;

use App\Student;
use App\Formation;
use App\FormationSession;
use App\Http\Requests\NewFormationTitleValidation;
use Carbon\Carbon;
use DateTime;

class FormationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $fs = Formation::all();
        $fst = [];
        foreach ($fs as $f) {
            $fst[$f->id] = $f->title;
        }

        $formations = Formation::withCount('formationSession')->get();
        
        $diffMonths = []; $diffYears = [];
        foreach ($formations as $f) {
            $start_date = Carbon::createFromFormat('Y-m-d', $f->created_at->format('Y-m-d'), null, 'Africa/Antananarivo');
            $end_date = Carbon::createFromFormat('Y-m-d', (new DateTime)->format('Y-m-d'), null, 'Africa/Antananarivo');
            $diffMonths[$f->id] = $start_date->diffInMonths($end_date, false); $diffYears[$f->id] = null;
            if ($diffMonths[$f->id] > 12) $diffYears[$f->id] = $start_date->diffInYears($end_date, false);

            $f->actualSessionsCount = FormationSession::where('formation_id', $f->id)->where('date_end', '>', new DateTime())->count();
            $f->expiredSessionsCount = FormationSession::where('formation_id', $f->id)->where('date_end', '<=', new DateTime())->count();
        }

        $formationsCount = Formation::all()->count();
        $fsessions = FormationSession::all();
        $students = Student::all();
        return view('formations.home', compact('formations', 'formationsCount', 'fst', 'students', 'fsessions', 'diffYears', 'diffMonths'));
    }

    public function add(NewFormationTitleValidation $request) 
    {
        $formation = new Formation();
        $formation->title = $request->title;
        $formation->save();
        return redirect('formation')->with('msg', 'Nouvelle Formation Ajoutée avec Succès !');
    }

    public function delete(int $id) 
    {
        Formation::where('id', $id)->delete();
        return redirect(route('formation.showAll'))->with('msg', 'Suppression de formation avec succès !!!');
    }

}
