@extends('adminlte::page')

@section('title') Etudiants en Retard de Paiement 
@stop
@section('content_header')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Fees</a></li>
        <li class="breadcrumb-item active">Retard Paiment</li>
    </ol>
</div>
@stop

@section('content')
    <h1 class="d-flex justify-content-center">Liste des étudiants en retard de paiement</h1>
    <table class="table table-sm table-dark table-hover">
        @if (count($students) === 0) 
        
        <h3 class="text-info my-5 h1 font-weight-bold text-center">Rien A Afficher</h3>
            
        @else
            <h4 class="text-center"><a href="{{ route('fees.studentsWithProblems.export') }}" target="_blank" class="btn btn-sm btn-info">Télécharger le fichier Excel</a></h4>
            <thead class="bg-warning">
                <tr class="font-weight-bold">
                    <th>#</th>
                    <th>Nom </th>
                    <th>Formation</th>
                    <th>Etat Ecolage (en AR)</th>
                    <th>Date départ du retard</th>
                    <th>Repère du retard</th>
                </tr>
            </thead>

            @foreach ($students as $student)
            <tbody>
                <tr class="font-weight-bold">
                    <td>{{ $student->id }}</td>
                    <td><a href="{{ route('student.showOne', $student->id) }}">
                        {{ $student->fname }} <span class="text-uppercase">{{ $student->lname }}</span></a></td>
                    <td>
                        <a href="{{ route('formation.session.showWithFormationId', $student->formationSession->formation->id) }}">
                            {{ $student->formationSession->formation->title }}
                        </a> 
                        | <a href="{{ route('formation.session.showOne', $student->formationSession->id) }}">
                            Vn° {{ $student->formationSession->session_number }}
                        </a>
                    </td>
                    <td>
                        {{ $student->school_fee_paid }} sur {{ $student->formationSession->fee }} 
                        ({{ $student->school_fee_paid / $student->formationSession->fee * 100 }}%)
                    </td>
                    <td>{{ $student->dateLateGo }} ({{ str_replace('before', 'ago', $student->lateDuration) }})</td>
                    <td>{{ $student->lateStatus }}</td>
                </tr>
            </tbody>
            @endforeach
        @endif
    </table>
<style type="text/css">
.col-sm-6 {
    margin-left: 540px;
    position: relative;
    top: 4px;
}
</style>
@stop