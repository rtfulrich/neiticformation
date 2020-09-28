@extends('adminlte::page')

@section('title') Les formations disponibles @stop
@section('content_header')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Formation</a></li>
        <li class="breadcrumb-item active">Liste</li>
    </ol>
</div>
@stop

{{-- CONTENT OF THE PAGE --}}
@section('content')
    <div id="confirm-delete">
        <div class="confirmation position-fixed d-flex justify-content-center align-items-center vh-100 vw-100" style="margin-top: -100px; margin-bottom: 50px; z-index: 3; background: rgba(0, 0, 0, 0.7);">
            <div class="row d-flex justify-content-center d-md-block">
                <div class="col-10 offset-md-1 col-md-6">
                    <div class="card" style="margin-top: -20px">
                        <header class="card-header bg-danger">
                            <h2 class="text-center text-dark font-weight-bold">
                                Voulez-vous vraiment supprimer cette formation en 
                                {{-- <span id="f0" class="formation-name font-weight-bold">Dev Web</span> ? --}}
                                @foreach ($fst as $key => $value)
                                <span id="_f{{ $key }}" class="text-capitalize font-weight-bold text-light">{{ $value }}</span>
                                @endforeach
                            </h2>
                        </header>
                        <div class="card-body d-flex justify-content-center px-3">
                            <form id="form-delete" action="" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-success mr-5 font-weight-bold">Valider</button>
                            </form>
                            <button id="delete-cancel" onclick="cancelDelete()" class="btn btn-primary ml-5 font-weight-bold">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
    <div class="flash-msg">
        <div class="alert alert-danger d-inline-block position-absolute" style="top: 0; right: 0">
            <ul>
                @foreach ($errors->all() as $error)
                <li class="font-weight-bold">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    @if (session('msg'))
    <div class="flash-msg">
        <div class="alert alert-success d-inline-block position-absolute font-weight-bold" style="top: 0; right: 0">
            {{ session('msg') }}
        </div>
    </div>
        
    @endif
    
    <h1 class="text-center font-weight-bold mb-4">Liste de toutes les formations disponibles <span class="text-success">({{ $formationsCount }})</span></h1>
    <div class="d-flex flex-column align-items-end">
        <div id="new-formation" class="form-group">
            <button class="btn btn-sm btn-info"><small>Ajouter une nouvelle formation</small></button>
        </div>
        <div id="new-formation-form" class="form-group">
            <form action="{{ route('formation.add') }}" method="post" style="width: 400px" class="d-inline-block">
                @csrf
                <div class="input-group text-right">
                    <input type="text" name="title" class="form-control" placeholder="Titre de la nouvelle formation" autofocus>
                    <div  id="new-formation-confirm" class="input-group-prepend">
                        <button type="submit" class="input-group-text btn-default"><i class="fas fa-vote-yea text-primary"></i></button>
                    </div>
                    <div  id="new-formation-cancel" class="input-group-prepend">
                        <button type="button" class="input-group-text btn-default"><i class="fa fa-window-close text-danger"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
    @foreach ($formations as $formation)
        <div class="col-12 col-md-6">
            <div class="card">
                <header class="card-header bg-warning d-flex">
                    <h3 class="text-capitalize font-weight-bold">{{ $formation->title }}</h3>
                    <div class="ml-auto d-flex">
                        <div>
                            <a href="{{ route('formation.session.showWithFormationId', $formation->id) }}" class="btn btn-success" title="Voir toutes les vagues de cette formation"><i class="fa fa-eye"></i></a>
                        </div>
                        @if ($formation->formation_session_count == 0)
                        <div id="del-{{ $formation->id }}" onclick="processAll(this);" class="ml-3">
                            <button type="button" class="btn btn-danger px-3"><i class="fas fa-trash"></i></button>
                        </div>
                        @endif
                    </div>
                </header>
                <div class="card-body p-0">
                    <table class="table table-dark table-hover">
                        <tbody>
                            <tr class="font-weight-bold">
                                <td style="vertical-align: middle">Créée depuis le : </td>
                                <td>
                                    {{ $formation->created_at->format('d/m/Y') }} <br> 
                                    <span style="font-style: italic">
                                        @if ($diffYears[$formation->id]) 
                                            Il y a {{ $diffYears[$formation->id] }} an(s) 
                                        @else
                                            @if ($diffMonths[$formation->id] == 0) Ce mois-ci
                                            @else Il y a {{ $diffMonths[$formation->id] }} mois
                                            @endif
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td>Nombre de vagues actuel : </td>
                                <td>{{ $formation->actualSessionsCount }}</td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td>Nombre d'anciennes vagues : </td>
                                <td>{{ $formation->expiredSessionsCount }}</td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td>Nombre d'étudiants ayant été certifiés : </td>
                                @php 
                                    $i = 0;
                                    foreach ($students as $student) {
                                        foreach ($fsessions as $fsession) {
                                            if ($fsession->formation_id == $formation->id && $student->formation_session_id == $fsession->id && $student->certified) $i++; 
                                        }
                                    }
                                @endphp
                                <td>{{ $i }}</td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td>Nombre d'étudiants actuel : </td>
                                @php 
                                    $i = 0;
                                    foreach ($students as $student) {
                                        foreach ($fsessions as $fsession) {
                                            if ($fsession->formation_id == $formation->id && (!$fsession->date_end || $fsession->date_end >= now()) && $student->formation_session_id == $fsession->id) $i++; 
                                        }
                                    }
                                @endphp
                                <td>{{ $i }}</td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td>Nombre d'anciens étudiants :</td>
                                @php 
                                    $i = 0;
                                    foreach ($students as $student) {
                                        foreach ($fsessions as $fsession) {
                                            if ($fsession->formation_id == $formation->id && $fsession->date_end && $fsession->date_end < now() && $student->formation_session_id == $fsession->id) $i++; 
                                        }
                                    }
                                @endphp
                                <td>{{ $i }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
    </div>
<style type="text/css">
.col-sm-6 {
    margin-left: 540px;
    position: relative;
    top: 4px;
}
h1{
    font-size: 30px;
    margin-left: -189px;
    margin-top: -17px;
}
</style>
    
@stop
{{-- END CONTENT --}}

{{-- JAVASCRIPT SECTION --}}
@section('js')
<script>
    const confirmDelete = $('#confirm-delete');
    confirmDelete.hide();

    function cancelDelete() {
        confirmDelete.hide('slow');
        $('span[id*=_f]').hide();
    }

    $('span[id*=_f]').hide();

    function processAll(element) {
        let idAttr = $(element).attr('id');
        confirmDelete.show('slow');
        var id = idAttr.replace('del-', '');
        $('#form-delete').attr('action', `/formation/delete/${id}`);
        const spanElement = $('span[id*=_f'+id);
        spanElement.show();
    }

    /*$(document).ready( () => {
        $('#delete-cancel').click( () => {
            $('#formation-name').text("{{ DB::table('formations')->where('id', 3)->get('title') }}");
        });
    });*/  

    $('.flash-msg').hide();
    $(document).ready( () => {
        $('.flash-msg').show('slow');
        setTimeout( () => $('.flash-msg').hide(5000), 3000);
    });

    // ADD A NEW FORMATION (just title)
    $('#new-formation-form').hide();

    $(document).ready(() => {
        $('#new-formation').click(() => {
            $('#new-formation').hide('slow');
            $('#new-formation-form').show('slow');
        });
        $('#new-formation-cancel').click(() => {
            $('#new-formation-form').hide('slow');
            $('#new-formation').show('slow');
        });
    });
</script>

@foreach ($formations as $formation)
<script>

    // EDIT TITLE
    $('#edit{{ $formation->id }}-cancel').hide();
    $('#form{{ $formation->id }}').hide();

    $(document).ready(function() {
        $('#edit{{ $formation->id }}').click(function() {
            $('#edit{{ $formation->id }}').hide('slow');
            $('#form{{ $formation->id }}').show('slow');
            $('#edit{{ $formation->id }}-cancel').show();
        });
        $('#edit{{ $formation->id }}-cancel').click(function() {
            $('#form{{ $formation->id }}').hide('slow');
            $('#edit{{ $formation->id }}-cancel').hide('slow');
            $('#edit{{ $formation->id }}').show('slow');
        });
    });
</script>
@endforeach

@stop
{{-- END JAVASCRIPT --}}