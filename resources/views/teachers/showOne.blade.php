@extends('adminlte::page')

@section('title')
    {{ $teacher->full_name }} | Prof
@stop

@section('content')

    @if (session('success'))
    <div id="msg" style="position: absolute; top: 0; right: 0; z-index: 3">
        <div class="alert alert-success d-inline-block">
            {{ session('success') }}
        </div>
    </div>
    @elseif (session('danger'))
    <div id="msg" style="position: absolute; top: 0; right: 0; z-index: 3">
        <div class="alert alert-danger d-inline-block">
            {{ session('danger') }}
        </div>
    </div>
    @elseif ($errors->any())
    <div id="msg" style="position: absolute; top: 0; right: 0; z-index: 3">
        <div class="alert alert-danger d-inline-block">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card font-weight-bold">
                <div class="card-header bg-warning text-center ">
                    <h2 class="font-weight-bold">A Propos</h2>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <tr>
                            <td>Nom Complet :</td>
                            <td class="text-capitalize">{{ $teacher->full_name }}</td>
                        </tr>
                        <tr>
                            <td>Email :</td>
                            <td {{ $teacher->email ? 'class="text-danger"' : '' }}>{{ $teacher->email ?? '??????????' }}</td>
                        </tr>
                        <tr>
                            <td>Téléphone :</td>
                            <td {{ $teacher->phone ? 'class="text-danger"' : '' }}>{{ $teacher->phone ?? '??????????' }}</td>
                        </tr>
                        <tr>
                            <td>Formation(s) <br> entreprise(s) :</td>
                            <td class="text-capitalize {{ $formations[0] ? '' : 'text-danger' }}">
                                {{ $formations[0] ? '' : '??????????' }}
                                <ul class="list-unstyled">
                                    @php $tab = []; @endphp
                                    @foreach ($formations as $formation)
                                        @foreach ($formation->formationSession()->where('formation_id', $formation->id)->where('teacher_id', $teacher->id)->get() as $item)
                                        @php 
                                            if (in_array($item->id, $tab)) continue;
                                            else $tab[] = $item->id;
                                        @endphp
                                        <li class="d-flex">
                                            * {{ $formation->title }} 
                                            <span class="ml-auto d-inline-block">
                                                <a href="{{ route('formation.session.showOne', $item->id) }}" class="ml-2"><i class="fas fa-eye"></i></a>
                                                <span class="badge badge-success ml-1">{{ $item->id }}</span>
                                            </span>
                                        </li>
                                        @endforeach
                                    @endforeach 
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-center">
                    <h2 class="font-weight-bold">Formulaire de modification</h2>
                </div>
                <div class="card-body bg-dark">
                    <form action="{{ route('teacher.update', $teacher->id) }}" method="POST" >
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label for="full_name">Nom Complet :</label>
                            <input type="text" name="full_name" id="full_name" value="{{ $teacher->full_name }}" class="form-control font-weight-bold">
                        </div>
                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="email" name="email" id="email" value="{{ $teacher->email ?? '' }}" class="form-control font-weight-bold">
                        </div>
                        <div class="form-group">
                            <label for="phone">Téléphone :</label>
                            <input type="text" name="phone" id="phone" value="{{ $teacher->phone ?? '' }}" class="form-control font-weight-bold">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success font-weight-bold">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    const msg = $('#msg') ? $('#msg') : null;
    if (msg) {
        msg.toggle();
        $(document).ready( () => {
            msg.toggle('slow');
            setTimeout( () => {
                msg.toggle('slow');
            }, 5000);
        });
    }

</script>
@stop