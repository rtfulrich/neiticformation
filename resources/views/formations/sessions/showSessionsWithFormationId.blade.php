@extends('adminlte::page')

@section('title') 
    {{ $formation }} | Les Vagues
@stop

@section('content')

    @if (session('msg'))
    <div id="msg">
        <div class="alert alert-info d-inline-block position-absolute" style="top: 0; right: 0">
            {{ session('msg') }}
        </div>
    </div>
    @endif

    <h1 class="text-center mb-4 font-weight-bold">Les Vagues de Formation en <span class="text-capitalize text-primary">{{ $formation }}</span></h1>

    <div class="table table-hover table-responsive">
        <table class="w-100">
            <thead class="bg-dark">
                <tr>
                    <th>#</th>
                    <th>Date de Fin</th>
                    <th>Date de Début</th>
                    <th>Le prof</th>
                    <th class="text-center">Frais (Ar)</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr class="font-weight-bold">
                    <td>{{ $data->session_number }}</td>
                    <td @if (!$data->date_end) class="text-danger" @endif>
                        {{ $data->date_end ?? 'INCONNUE' }} 
                        @if (!$data->date_end)
                        <a href="#" title="Définir la fin de la vague" class="ml-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                    </td>
                    <td>{{ $data->date_debut }}</td>
                    <td>{{ $data->teacher->full_name }}</td>
                    <td class="text-right">{{ $data->fee }}</td>
                    <td>{{ strlen($data->description) > 30 ? substr($data->description, 0, 40) . ' ...' : $data->description }}</td>
                    <td><a href="{{ route('formation.session.showOne', $data->id) }}" class="btn-sm btn-success">Voir Détails</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@stop

@section('js')
<script>
    const msg = $('#msg');
    msg.toggle();
    $(document).ready( () => {
        msg.toggle('slow');
        setTimeout( () => {
            msg.toggle('slow');
        }, 5000);
    });
</script>
@stop