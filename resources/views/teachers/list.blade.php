@extends('adminlte::page')

@section('title') Liste De Tous Les Profs
@stop
@section('content_header')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Teachers</a></li>
        <li class="breadcrumb-item active">Listes</li>
    </ol>
</div>
@stop

@section('content')
    @if(session('msg'))
        <p class="alert alert-success">{{ session('msg') }}</p>
    @endif

    <table class="table table-sm table-hover table-dark font-weight-bold">
        <thead class="bg-warning">
            <tr>
                <th>N°</th>
                <th>Prénom | Nom</th>
                <th>Formations à Enseigner</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teachers as $teacher)
            <tr>
                <td>{{ $teacher->id }}</td>
                <td class="text-capitalize">
                    <a href="{{ route('teacher.showOne', $teacher->id) }}" class="text-light">
                        {{ $teacher->full_name }}
                        <span class="text-primary ml-3"><i class="fas fa-eye"></i></span>
                    </a>
                </td>
                <td>
                    @php $tab = []; @endphp
                    @foreach ($formations::where('teacher_id', $teacher->id)->get() as $item)
                        @if (in_array($item->formation->title, $tab)) @php continue; @endphp 
                        @else 
                            <a href="{{ route('formation.session.showWithFormationId', $formations::where('formation_id', $item->formation->id)->get()[0]->formation()->get('id')[0]) }}" class="text-capitalize text-light">
                                {{ $item->formation->title }}
                                <span class="text-primary ml-3"><i class="fas fa-eye"></i></span>
                            </a> <br>
                            @php $tab[] = $item->formation->title ; @endphp
                        @endif
                    @endforeach
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
.content{
    margin-top: 30px;
}
</style>
@stop