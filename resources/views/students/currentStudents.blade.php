@extends('adminlte::page')

@section('title')
    Liste des étudiants actuels
@stop   
@section('content_header')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="../../home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Students</a></li>
        <li class="breadcrumb-item active">Actuel(s)</li>
    </ol>
</div>
@stop
@section('content')
    <h2 class="text-center"><a target="_blank" href="{{ route('student.export.actualStudents') }}" class="btn btn-sm btn-info">Exporter en fichier Excel</a></h2>
    <table class="table table-sm table-hover table-dark font-weight-bold">
        <thead class="bg-warning">
            <tr>
                <th>n°</th>
                <th>Prénoms & Nom</th>
                <th>Formation</th>
                <th>Etat Ecolage</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>
                    <a href="{{ route('student.showOne', $student->id) }}" class="text-light">
                        <span class="text-capitalize">{{ $student->fname }}</span> <span class="text-uppercase">{{ $student->lname }}</span> <span class="text-primary ml-3"><i class="fas fa-eye"></i></span>
                    </a>
                </td>
                <td class="text-capitalize">
                    {{ $student->formationSession->formation->title }} | <a href="{{ route('formation.session.showOne', $student->formation_session_id) }}" class="text-light">Vn° {{ $student->formationSession->session_number }} <span class="text-primary ml-3"><i class="fas fa-eye"></i></span></a>
                </td>
                <td>
                    {{ round($student->school_fee_paid * 100 / $student->formationSession->fee) }} %
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
<style type="text/css">
.col-sm-6 {
    margin-left: 540px;
    position: relative;
    top: 4px;
}
</style>
@stop