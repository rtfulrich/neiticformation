@extends('adminlte::page')

@section('title') Les Etudiants Certifiés
@stop
@section('content_header')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="../../home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Students</a></li>
        <li class="breadcrumb-item active">Certifiés</li>
    </ol>
</div>
@stop

@section('content')
    <h1 class="d-flex justify-content-center">Liste des Etudiants Certifiés</h1>
    <h2 class="text-center">
      <a href="{{ route('students.export.certifiedStudents') }}" class="btn-sm btn-info">Exporter en fichier Excel</a>
    </h2>
    @php $i = 0; @endphp
    <div class="accordion" id="accordionExample">
        @foreach ($formations as $formation)
        @php $i++; @endphp
        <div class="card">
          <div class="card-header bg-warning p-0" id="heading{{$i}}">
            <div class="m-0 d-flex justify-content-center">
              <button class="btn btn-link h1 text-capitalize font-weight-bold text-dark" type="button" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="true" aria-controls="collapse{{$i}}" style="font-size: 1.3rem">
                {{ $formation->title }} 
                <span class="bagde badge-info px-1 mx-2">{{ $formation->certifiedStudentsCount }}</span>
                <span class="mx-3"><i class="fas fa-arrow-down"></i></span>
              </button>
            </div>
          </div>
      
          <div id="collapse{{$i}}" class="collapse hide" aria-labelledby="heading{{$i}}" data-parent="#accordionExample">
            <div class="card-body p-0">
              @if (count($certifiedStudents) > 0)
                <table class=" table-sm table-dark table-hover w-100 px-3" style="margin-bottom: 0rem">
                  <thead class="bg-warning">
                    <tr>
                      <th>N°</th>
                      <th>Nom et Prénoms</th>
                      <th>Formation</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($certifiedStudents as $student)
                        @php
                            $count++;
                        @endphp
                        @foreach ($fsessions as $fsession) 
                            @if ($fsession->formation_id == $formation->id && $student->formation_session_id == $fsession->id)
                            <tr>
                              <td>{{ $student->id }}</td>
                              <td class="text-capitalize font-weight-bold">
                                  {{ $student->fname . ' ' .strtoupper($student->lname) }}
                                  <a href="{{ route('student.showOne', $student->id) }}"><i class="fas fa-eye mx-3"></i></a>
                              </td>
                              <td>
                                {{ $student->formationSession->formation->title }} | Vn° {{ $student->formationSession->session_number }}
                              </td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                  </tbody>
                </table>
              @endif
            </div>
          </div>
        </div>
        @endforeach
        {{-- <div class="card">
          <div class="card-header" id="headingTwo">
            <h2 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Collapsible Group Item #2
              </button>
            </h2>
          </div>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
              Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="headingThree">
            <h2 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Collapsible Group Item #3
              </button>
            </h2>
          </div>
          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
            </div>
          </div>
        </div> --}}
    </div> 
@stop

@section('js')
<style type="text/css">
.col-sm-6 {
    margin-left: 540px;
    position: relative;
    top: 4px;
}
</style>
@stop