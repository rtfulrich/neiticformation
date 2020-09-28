@extends('adminlte::page')

@section('title') Les Anciennes Vagues @stop
@section('content_header')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="../../home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Formation</a></li>
        <li class="breadcrumb-item active">Vague(s) expiré(e)s</li>
    </ol>
</div>
@stop

@section('content')
    <div class="table table-hover table-responsive">
        <table class="w-100">
            <thead class="bg-dark">
                <tr class="vertical-align-middle">
                    <th>Vn°</th>
                    <th>Fin</th>
                    <th>Début</th>
                    <th>Titre Formation</th>
                    <th>Le prof</th>
                    <th>Frais (Ar)</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fsessions as $fsession)
                <tr class="font-weight-bold vertical-align-middle">
                    <td scope="row">{{ $fsession->session_number }}</td>
                    <td @if (!$fsession->date_end) class="text-center text-danger" @endif>
                        {{ $fsession->date_end ? date_format(date_create($fsession->date_end) ,'d/m/Y') : '?' }}
                    </td>
                    <td>
                        {{ date_format(date_create($fsession->date_debut) ,'d/m/Y') }} 
                    </td>
                    <td class="text-capitalize">{{ $fsession->formation->title }}</td>
                    <td>{{ $fsession->teacher->full_name }}</td>
                    <td>{{ $fsession->fee }}</td>
                    <td @if (!$fsession->description) class="text-center text-danger" @endif>{{ (strlen($fsession->description) > 30 ? substr($fsession->description, 0, 40) . ' ...' : $fsession->description) ?? '...' }}</td>
                </td>
                <td><a href="{{ route('formation.session.showOne', $fsession->id) }}" class="btn-sm btn-success" title="Cette vague compte {{ $fsession->student()->count() }} étudiant(s)"><i class="fas fa-eye"></i> <span class="badge badge-warning ml-2">{{ $fsession->student()->count() }}</span></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<style type="text/css">
.col-sm-6 {
    margin-left: 540px;
    position: relative;
    top: 4px;
}
.content{
    margin-top: 33px;
}
</style>

@stop
