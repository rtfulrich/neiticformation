<?php

namespace App\Http\Controllers;

use App\Teacher;
use App\FormationSession;
use App\Http\Requests\UpdateTeacherRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $teachers = Teacher::all();

        // $teachers = DB::table('formation_sessions')
        //             ->join('teachers', 'formation_sessions.teacher_id', '=', 'teachers.id')
        //             ->select('teachers.*', 'formation_sessions.*')
        //             ->get();
        $formations = new FormationSession(); 
        // dd($formations::where('teacher_id', 3)->get()[0]->formation()->get('title')[0]->title);
        return view('teachers.list', compact('teachers', 'formations'));
    }

    public function showOne(int $id)
    {
        $teacher = Teacher::findOrFail($id);
        $fsessions = FormationSession::where('teacher_id', $teacher->id)->orderBy('date_end')->get();
        $formations = []; $fs = [];
        foreach ($fsessions as $fss) {
            $fs[] = $fss->formation()->get();
        } 
        foreach ($fs as $f) $formations[] = $f[0];
        return view('teachers.showOne', compact('teacher', 'formations'));
    }

    public function update(UpdateTeacherRequest $request, int $id)
    { 
        $data = [];
        $data = $request->except(['_token', '_method']);
        $updated = DB::table('teachers')->where('id', $id)->update($data);
        if ($updated) $request->session()->flash('success', 'Modification Succès !!!');
        else $request->session()->flash('danger', 'Erreur Modification !!!');
        return redirect(route('teacher.showOne', $id));
    } 

    public static function countTeachers()
    {
        return Teacher::count();
    }

}
