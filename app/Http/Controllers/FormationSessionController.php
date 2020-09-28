<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use App\Student;
use App\Teacher;
use App\Formation;
use App\FormationSession;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateFormationSessionRequest;
use App\Http\Requests\UpdateFormationSessionRequest;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FormationSessionController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function generateBadgeView() {
    //     return view('formations.sessions.generateBadge');
    // }

    public function generateBadgePdf(int $fsessionId) {

        \ini_set('memory_limit', -1);
        
        // Processing datas to send to view
        $data = [];
        $fsession = FormationSession::find($fsessionId);
        if (!$fsession) abort(404, 'Incorrect parameter !');

        $data["formationTitle"] = $fsession->formation->title;
        $data['promotion'] = $fsession->session_number;

        $date_debut_year = (new DateTime($fsession->date_debut))->format('Y');
        $date_debut_month = (new DateTime($fsession->date_debut))->format('m');
        $date_debut_day = (new DateTime($fsession->date_debut))->format('d');
        $data['month_debut'] = Carbon::create($date_debut_year, $date_debut_month, $date_debut_day)->locale('fr_FR')->monthName;
        
        $date_end_year = (new DateTime($fsession->date_end))->format('Y');
        $date_end_month = (new DateTime($fsession->date_end))->format('m');
        $date_end_day = (new DateTime($fsession->date_end))->format('d');
        $data['month_end'] = Carbon::create($date_end_year, $date_end_month, $date_end_day)->locale('fr_FR')->monthName;

        $data['year'] = $date_debut_year;

        $students = collect($fsession->student)->toArray();
        $i = 1;
        $counter = 0;
        foreach ($students as $student) {
            $counter++;
            $data['students']["page$i"][] = $student;
            if ($counter % 8 === 0) $i++;
        }

        $pdf = App::make('dompdf.wrapper');
        view()->share('data', $data);
        $pdf->loadView('formations.sessions.generateBadge', []);

        $pdfFilename = ucwords($data['formationTitle']) . ' - Promotion n°' . $data['promotion'] . ' - Badges .pdf';

        // download PDF file with download method
        return $pdf->stream($pdfFilename);
    }

    public function create()
    {
        extract($this->checkNonEmptyTeachersTable());
        extract($this->checkNonEmptyFormationsTable());

        if ($data_teachers and !$data_formations) return view('formations.sessions.create', compact('teachers', 'data_teachers'));
        elseif (!$data_teachers and $data_formations) return view('formations.sessions.create', compact('formations', 'data_formations'));
        elseif ($data_teachers and $data_formations) return view('formations.sessions.create', compact('formations', 'teachers', 'data_formations', 'data_teachers'));
        return view('formations.sessions.create');
    }

    public function store(CreateFormationSessionRequest $request)
    {
        try {
            $formation_session = new FormationSession();
            
            // TITLE
            if (preg_match('#^s[1-9]+$#' , $request->title)) {
                $request->title = str_replace('s', '', $request->title);
                $formation_session->formation_id = (int) $request->title;
                $last_id_of_f = DB::table('formation_sessions')->where('formation_id', $request->title)->max('session_number');
                if ($last_id_of_f != null) $formation_session->session_number = $last_id_of_f + 1;
                else $formation_session->session_number = 1;
            } else {;
                $formation = new Formation();
                $formation->title = $request->title;
                $formation->save();

                $formation_session->formation_id = DB::table('formations')->max('id');
            }
            
            // DATE DEBUT
            $formation_session->date_debut = $request->date_debut;
            // DATE END
            $formation_session->date_end = $request->date_end;
            // FEE
            $formation_session->fee = $request->fee;

            // DESCRIPTION
            if ($request->description) $formation_session->description = $request->description;
            
            // TEACHER
            if (preg_match('#^s[1-9]+$#' , $request->teacher)) {
                $request->teacher = str_replace('s', '', $request->teacher);
                
                $formation_session->teacher_id = (int) $request->teacher;
            } else {
                $teacher = new Teacher();
                $teacher->full_name = $request->teacher;
                $teacher->email = $request->email;
                $teacher->phone = $request->phone;
                $teacher->save();
                
                $formation_session->teacher_id = DB::table('teachers')->max('id');
            }

            $formation_session->save();
            
            return redirect(route('formation.session.showOne', FormationSession::latest()->first()->id))->with('success', 'Création d\'une nouvelle vague avec succès !');
        } catch(Exception $e) {
            die('ERROR : ' .$e->getMessage());
        }
    }

    public function update(UpdateFormationSessionRequest $request, int $id)
    {
        $formation_session = FormationSession::findOrFail($id);
        // TEACHER
        if (preg_match('#^s[1-9]+$#' , $request->teacher)) {
            $request->teacher = str_replace('s', '', $request->teacher);
            
            $formation_session->teacher_id = (int) $request->teacher;
        } else {
            $teacher = new Teacher();
            $teacher->full_name = $request->teacher;
            $teacher->email = $request->email;
            $teacher->phone = $request->phone;
            $teacher->save();
            
            $formation_session->teacher_id = DB::table('teachers')->max('id');
        }

        // OTHERS (no problemo)
        $formation_session->date_debut = $request->date_debut;
        $formation_session->date_end = $request->date_end;
        $formation_session->fee = $request->fee;
        $formation_session->description = $request->description;

        $formation_session->save();
        return redirect(route('formation.session.showOne', $id))->with('msg', 'Modification Avec Succès !!!');
    }

    public function delete(int $id)
    {
        $fsession = FormationSession::findOrFail($id); 
        $fsession->delete();
        return redirect(route('formation.session.showWithFormationId', $fsession->formation_id))->with('msg', 'Vague de formation n° ' .$fsession->session_number.', en '.$fsession->formation->title. ', supprimée avec succès !!!');
    }

    public function showSessionWithFormationId(int $id, string $order = 'date_end')
    {
        $formation_sessions = new FormationSession();
        $formation = Formation::findOrFail($id);
        $formation = $formation->title;
        $datas = $formation_sessions->where('formation_id', $id)->orderBy($order)->get();
        foreach ($datas as $data) {
            $data->date_debut = (new DateTime($data->date_debut))->format('d-m-Y');
            $data->date_end = (new DateTime($data->date_end))->format('d-m-Y');
        }
        return view('formations.sessions.showSessionsWithFormationId', compact('datas', 'formation'));
    }

    public function showAllSessions()
    {
        $fsessionsWithEnd = FormationSession::
            where('date_end', '>', new DateTime())
            ->orderBy('date_end', 'desc')
            ->get(); 
        $fsessionsWithoutEnd = FormationSession:: 
            where('date_end', null)
            ->orderBy('date_debut', 'desc')
            ->get();
        return view('formations.sessions.showAllSessions', compact('fsessionsWithEnd','fsessionsWithoutEnd'));
    }

    public static function countActualSessions() {
        $fsessionsWithEnd = FormationSession::
            where('date_end', '>', new DateTime())
            ->count();
        $fsessionsWithoutEnd = FormationSession::
            where('date_end', null)
            ->count();
        return $fsessionsWithEnd + $fsessionsWithoutEnd;
    }

    public static function countExpiredSessions() {
        return FormationSession::where('date_end', '<', new DateTime())->count();
    }

    public function showExpiredSessions()
    {
        $fsessions = FormationSession::where('date_end', '<', new DateTime())
            ->orderBy('date_end', 'desc')
            ->get();
        return view('formations.sessions.showExpiredSessions', compact('fsessions'));
    }

    public function showASession(int $id)
    {
        $teachers = Teacher::all();
        $fsession = FormationSession::findOrFail($id);
        $students = Student::where('formation_session_id', $id)->orderBy('fname')->get();
        return view('formations.sessions.showOneSession', compact('fsession', 'teachers', 'students', 'id'));
    }

    // ----------------------------------------- //
    private function checkNonEmptyTeachersTable() :array
    {
        $teachers = DB::table('teachers')->get();
        $data_teachers = false;
        foreach ($teachers as $teacher) $data_teachers = true;
        return compact('teachers', 'data_teachers');
    }

    private function checkNonEmptyFormationsTable() :array
    {
        $formations = DB::table('formations')->get();
        $data_formations = false;
        foreach ($formations as $formation) $data_formations = true;
        return compact('formations', 'data_formations');
    }

    private function checkNonEmptyFormationSessionsTable() :array
    {
        $formation_sessions = DB::table('formation_sessions')->get();
        $data_formation_sessions = false;
        foreach ($formation_sessions as $formation) $data_formation_sessions = true;
        return compact('formation_sessions', 'data_formation_sessions');
    }

}
