<?php

namespace App\Http\Controllers;

use App\Exports\ActualStudentsExport;
use App\Exports\CertifiedStudentsExport;
use App\Exports\OldStudentExport;
use DateTime;
use App\Student;
use App\Formation;
use App\FormationSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\AddStudentRequest;
use App\Exports\StudentsWithProblemsExport;
use App\Http\Requests\UpdateStudentRequest;
use Intervention\Image\ImageManagerStatic;

class StudentController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
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
        return view('students.currentStudents', compact('students'));
    }

    public function exportActualStudents()
    {
        return Excel::download(new ActualStudentsExport, 'Etudiants actuel __ ' .(new DateTime())->format('d-m-Y H\h i\m\i\n s\s'). ' .xlsx');
    }

    public function exportOldStudents()
    {
        return Excel::download(new OldStudentExport, 'Anciens étudiants __ ' .(new DateTime())->format('d-m-Y H\h i\m\i\n s\s'). ' .xlsx');
    }

    public function exportCertifiedStudents()
    {
        return Excel::download(new CertifiedStudentsExport, 'Etudiants certifiés __ '.(new DateTime())->format('d-m-Y H\h i\m\i\n s\s'). ' .xlsx');
    }

    public function exportStudentsWithProblems()
    {
        return Excel::download(new StudentsWithProblemsExport, 'Les étudiants en retard de paiement __ '.(new DateTime())->format('d-m-Y H\h i\m\i\n s\s'). ' .xlsx');
    }

    public function certifiedStudents()
    {
        $formations = Formation::all();
        $fsessions = FormationSession::all();
        $certifiedStudents = Student::where('certified', true)->orderBy('certified_at', 'desc')->get();

        foreach ($formations as $formation) {
            $formation->certifiedStudentsCount = 0;
            foreach ($certifiedStudents as $student) {
                foreach ($fsessions as $fsession) {
                    if ($fsession->formation_id == $formation->id && $student->formation_session_id == $fsession->id)
                        $formation->certifiedStudentsCount++;
                }
            }
        }    
        return view('students.certifiedStudents', compact('formations', 'fsessions', 'certifiedStudents'));
    }

    public function oldStudents()
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
        return view('students.oldStudents', compact('students'));
    }

    public function add(AddStudentRequest $request, int $id)
    {
        $reqData = $request->except('_token');
        $reqData['formation_session_id'] = $id;
        $reqData['created_at'] = now();
        $reqData['updated_at'] = now();
        if (!$reqData['school_fee_paid']) $reqData['school_fee_paid'] = 0;
        if (!$reqData['children_number']) $reqData['children_number'] = 0;
        if ($request->hasFile('photo')) { 
            $filename = time() . rand(11111, 99999) . '.jpg';
            $filepath = 'storage/' . $filename;
            ImageManagerStatic::make($request->file('photo'))
            ->resize(500, 500)
            ->save($filepath, 50);
            // $file = $request->file('photo');
            // $destinationPath = storage_path('app/public');
            // $file->move($destinationPath, $name);
            $reqData['photo'] = $filename;
        }
        $newItem = DB::table('students')->insert($reqData);
        if ($newItem) {
            $request->session()->flash('success', 'Ajout d\'un Nouvel Etudiant Avec Succès !!!');
        } else {
            $request->session()->flash('error', 'Ajout d\'un Nouvel Etudiant => ECHEC !!!');
        }
        // $student->save();

        return redirect(route('formation.session.showOne', $id));
    }

    public function showOne(int $id)
    {
        $student = Student::findOrFail($id);
        $total_fee = $student->formationSession->fee; 
        $fee_paid_percentage = $student->school_fee_paid / $total_fee * 100;
        return view('students.showOne', compact('student', 'total_fee', 'fee_paid_percentage'));
    }

    public function pay(int $id, Request $request) 
    {
        $request->validate(['school_fee_paid' => 'required|integer|min:0']);

        $student = Student::findOrFail($id); 
        $student->school_fee_paid += $request->school_fee_paid;
        $student->save();
        return back()->with('success', 'Payment Ecolage Succès !!!');
    }

    public function update(int $id, UpdateStudentRequest $request)
    {
        $reqData = $request->except(['_token', '_method']);
        if ($reqData['certified'] === "1") $reqData['certified_at'] = (new DateTime())->format('Y-m-d');
        if ($reqData['certified'] === "0") $reqData['certified_at'] = null;
        if ($reqData['children_number'] === null) $reqData['children_number'] = 0;
        $reqData['updated_at'] = new DateTime(); 

        if ($request->hasFile('photo')) {
            // Storing the new Photo
            $file = $request->file('photo');
            $name = time() . rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $destinationPath = storage_path('app\public');
            $file->move($destinationPath, $name);
            $reqData['photo'] = $name;
            // Deleting old photo
            $oldPhoto = Student::where('id', $id)->get('photo')[0]->photo;
            if (file_exists(public_path('storage/'.$oldPhoto)) and $oldPhoto !== 'default.png') unlink(public_path('storage/'.$oldPhoto));
        }
        $newItem = DB::table('students')->where('id', $id)->update($reqData);
        if ($newItem) {
            $request->session()->flash('success', 'Modification Avec Succès !!!');
        } else {
            $request->session()->flash('error', 'Modification => ECHEC !!!');
        }
        // $student->save();

        return back()/*->with('msg', 'Ajout d\'un Nouvel Etudiant Avec Succès !!!')*/;
    }

    public function delete(int $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        // if (file_exists(public_path('storage/'.$student->photo))) unlink(public_path(). '\storage\\'.$student->photo);
        // dd('yes'); else dd('non');

        if ($student->photo !== 'default.png' and File::exists(public_path('storage/'.$student->photo)))
            File::delete(public_path('storage/'.$student->photo));

        return redirect(route('formation.session.showOne', $student->formationSession->id))->with('info', $student->fname . ' ' .$student->lname .' a été supprimé(e) de cette vague de formation !!!');
    }

    public static function oldStudentsCount() 
    {
        $oldSessionsIds = FormationSession::where('date_end', '<', new DateTime())->get('id');
        $students = []; $arrayResults = [];
        foreach ($oldSessionsIds as $id) {
            $arrayResults[] = Student::where('formation_session_id', $id->id)->get();
        }
        foreach ($arrayResults as $collections) {
            foreach ($collections as $item) $students[] = $item;
        } 
        return count($students);
    }

    public static function currentStudentsCount() 
    {
        return Student::count() - self::oldStudentsCount();
    }

    public static function certifiedStudentsCount() 
    {
        return Student::where('certified', true)->count();
    }

}
