@extends('adminlte::page')

@section('title') Toutes les vagues actuelles @stop
@section('content_header')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="../home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Formation</a></li>
        <li class="breadcrumb-item active">Actuel(s)</li>
    </ol>
</div>
@stop

@section('content')

    <h1 class="font-weight-bold text-center mb-4">Les vagues de formation actuelles</h1>
        
    <div class="text-right h5 mb-2">
        <span class="bg-info p-2">Aujourd'hui c'est le : <span id="current-date"class="font-weight-bold text-dark text-capitalize">Vendredi 20 Mars 2020</span></span>
    </div>
    
    <div class="table table-sm table-hover table-responsive">
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
                @foreach ($fsessionsWithoutEnd as $fsession)
                <tr class="font-weight-bold vertical-align-middle">
                    <td scope="row">{{ $fsession->session_number }}</td>
                    <td class="text-center text-danger">
                        ...
                        {{-- {{ date_format(date_create($fsession->date_end) ,'d/m/Y') }} --}}
                    </td>
                    <td>
                        {{ date_format(date_create($fsession->date_debut) ,'d/m/Y') }} 
                    </td>
                    <td class="text-capitalize">
                        <a href="{{ route('formation.session.showWithFormationId', $fsession->formation->id) }}">{{ $fsession->formation->title }}</a>
                    </td>
                    <td>{{ $fsession->teacher->full_name }}</td>
                    <td>{{ $fsession->fee }}</td>
                    <td @if (!$fsession->description) class="text-center text-danger" @endif>{{ (strlen($fsession->description) > 30 ? substr($fsession->description, 0, 40) . ' ...' : $fsession->description) ?? '...' }}</td>
                    {{-- <td><a href="{{ route('formation.session.showOne', $fsession->id) }}" class="btn-sm btn-success"><i class="fas fa-eye"></i></a></td> --}}
                    <td><a href="{{ route('formation.session.showOne', $fsession->id) }}" title="Cette vague compte {{ $fsession->student()->count() }} étudiant(s)" class="btn-sm btn-success "><i class="fas fa-eye"></i> <span class="badge badge-warning m-2">{{ $fsession->student()->count() }}</span></a></td>
                </tr>
                @endforeach
                @foreach ($fsessionsWithEnd as $fsession)
                <tr class="font-weight-bold vertical-align-middle">
                    <td scope="row">{{ $fsession->session_number }}</td>
                    <td class="text-center">
                        {{ date_format(date_create($fsession->date_end) ,'d/m/Y') }}
                    </td>
                    <td>
                        {{ date_format(date_create($fsession->date_debut) ,'d/m/Y') }} 
                    </td>
                    <td class="text-capitalize">
                        <a href="{{ route('formation.session.showWithFormationId', $fsession->formation->id) }}">{{ $fsession->formation->title }}</a>
                    </td>
                    <td>{{ $fsession->teacher->full_name }}</td>
                    <td>{{ $fsession->fee }}</td>
                    <td @if (!$fsession->description) class="text-center text-danger" @endif>{{ (strlen($fsession->description) > 30 ? substr($fsession->description, 0, 40) . ' ...' : $fsession->description) ?? '...' }}</td>
                    </td>
                    <td><a href="{{ route('formation.session.showOne', $fsession->id) }}" title="Cette vague compte {{ $fsession->student()->count() }} étudiant(s)" class="btn-sm btn-success "><i class="fas fa-eye"></i> <span class="badge badge-warning m-2">{{ $fsession->student()->count() }}</span></a></td>
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
</style>
@stop


@section('js')
<script>

// function stringDay(int day = null)
// {
//     const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
//     return days[day - 1];
// }

// function month(int month = null) {
//     const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
//     return months[month - 1];
// }


let date = new Date();
const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
let today = date.toLocaleDateString('fr-FR', options); 
$('#current-date').text(today);
</script>
@stop