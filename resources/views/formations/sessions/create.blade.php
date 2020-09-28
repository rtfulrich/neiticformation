@extends('adminlte::page')

@section('title') Créer une nouvelle vague @stop
@section('content_header')
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="../../home">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Formation</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
</div>
@stop

{{-- CONTENT SECTION --}}
@section('content')
    
    <h1 class="mb-3 d-flex justify-content-center">
        <span style="font-size: 30px;" class="m-auto text-uppercase border-left border-right border-bottom border-dark font-weight-bold px-2">
            Création d'une nouvelle vague de formation
        </span>
    </h1>

    @if(session('success'))
    <div id="success" class="alert alert-primary position-absolute" style="top: 0; right: 0">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('formation.session.store') }}" method="post">
        @csrf
        <div class="row">
            
            <div class="col-12 col-md-6">
                
                <div class="form-group">
                    <div class="form-group d-flex justify-content-center">
                        <label class="h4">A propos de la formation</label>
                    </div>                 
                </div>

                @isset($data_formations)
                <div class="form-group d-flex justify-content-end">
                    <button type="button" class="btn-sm btn-info button-select-formation">
                        <small class="font-weight-bold text-dark">Choisir parmi celles qui existent déjà</small>
                    </button>
                    <button type="button" class="btn-sm btn-info button-new-formation">
                        <small class="font-weight-bold text-dark">Créer une toute nouvelle formation</small>
                    </button>
                </div>
                @endisset   
                
                <div id="title-field">
                    <div class="form-group input-group new-formation-input">
                        <input type="text" name="title" id="title_new" class="form-control" placeholder="Titre de la formation (ex: Développement Web) (obligatoire)" @if ($errors->any()) value="{{ old('title') }}" @endif autofocus>                
                    </div>
                    @isset($data_formations)
                    <div class="form-group select-formation">
                        <select name="title" id="title_select" class="form-control">
                            <option value="s0">Sélectionner la formation ici (obligatoire)</option>
                            @foreach($formations as $formation)
                            <option value="s{{ $formation->id }}" class="font-weight-bold text-lowercase text-capitalize" @if ($errors->any() && old('title') == 's'.$formation->id) selected @endif >
                                {{ $formation->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endisset
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="debut">Début de la formation</label>
                            <input type="date" id="debut" name="date_debut" class="form-control" @if ($errors->any()) value="{{ old('date_debut') }}" @endif required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="end">Fin de la formation <small class="text-info">(Obligatoire)</small></label>
                            <input type="date" id="end" name="date_end" class="form-control" @if ($errors->any()) value="{{ old('date_end') }}" @endif required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <input type="number" name="fee" step="5000" min="0" id="fee" class="form-control" placeholder="Frais de la formation en Ariary (obligatoire)" @if ($errors->any()) value="{{ old('fee') }}" @endif required>
                </div>
                
                <div class="form-group">
                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Description de la formation (facultatif)

C'est ici que l'on mettra les informations détaillées sur la vague, telles que les jours de séances, les horaires, etc ...
">@if ($errors->any()) {{ old('description') }} @endif</textarea>
                </div>

            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <div class="form-group d-flex justify-content-center">
                        <label class="h4">A propos du professeur</label>
                    </div>
                </div>

                @isset($data_teachers)
                    <div class="form-group d-flex justify-content-end">
                        <button type="button" class="btn-sm btn-info button-select-teacher">
                            <small class="font-weight-bold text-dark">Choisir parmi ceux qui existent déjà</small>
                        </button>
                        <button type="button" class="btn-sm btn-info button-new-teacher">
                            <small class="font-weight-bold text-dark">Ajouter un nouveau prof</small>
                        </button>
                    </div>
                @endisset

                <div id="teacher-name-field">
                    <div class="form-group new-teacher-input">
                        <input type="text" name="teacher" class="form-control" placeholder="Nom Complet (obligatoire)" @if ($errors->any()) value="{{ old('teacher') }}" @endif>
                    </div>
                    @isset($teachers)
                    <div class="form-group select-teacher">
                        <select name="teacher" class="form-control">
                            <option value="s0">Selectionner le prof ici (obligatoire)</option>
                            @foreach ($teachers as $teacher)
                            <option value="s{{ $teacher->id }}" class="font-weight-bold text-capitalize" @if ($errors->any() && old('teacher') == 's'.$teacher->id) selected @endif>
                                {{ $teacher->full_name }}
                            </option>
                            @endforeach                          
                        </select>
                    </div>
                    @endisset
                </div>

                <div class="form-group teacher-email-field">
                    <input type="email" name="email" class="form-control" placeholder="Email (obligatoire)" @if ($errors->any()) value="{{ old('email') }}" @endif>
                </div>

                <div class="form-group teacher-phone-field">
                    <input type="text" name="phone" class="form-control" placeholder="Téléphone (10 chiffres) (obligatoire)" @if ($errors->any()) value="{{ old('phone') }}" @endif>
                </div>

                <div class="form-group position-absolute-md" style="height: 75px;width: 100%; bottom: 0">
                    <button type="submit" class="btn btn-success form-control h-100">
                        <span class="h3 text-uppercase font-weight-bold">Créer</span>
                    </button>
                </div>
                  
            </div>
        </div>

    </form>
<style type="text/css">
.col-sm-6 {
    margin-left: 540px;
    position: relative;
    top: 4px;
}
h1{
    width: 79%;
}
.h-100 {
    height: 67% !important;
    margin-top: 24px;
}
h4, .h4:hover {
    font-size: 1.5rem;
    background: aquamarine;
}
</style>
@endsection

{{-- JAVASCRIPT SECTION --}}
@section ('js')

    @if (session('success'))
    <script>
        let $success = $('#success');
        $success.hide();
        $(document).ready(function() {
            $success.fadeIn()
            $success.fadeTo(4000, 0.9);
            $success.fadeTo(1000, 0.5);
            $success.fadeOut();
        });
    </script>
    @endif

    <script>
        // ACTIONS JUST AFTER PAGE IS LOADED
            // declaring variables
            let $buttonNewTeacher = $('.button-new-teacher');
            let $buttonNewFormation = $('.button-new-formation');
            let $selectTeacher = $('.select-teacher');
            let $selectFormation = $('.select-formation');

            let $buttonSelectFormation = $('.button-select-formation');
            let $buttonSelectTeacher = $('.button-select-teacher');
            let $newFormationInput = $('.new-formation-input');
            let $newTeacherInput = $('.new-teacher-input');

            let $teacherEmailField = $('.teacher-email-field');
            let $teacherPhoneField = $('.teacher-phone-field');
    </script>

    @if (!isset($data_teachers))
    <script>
        $(document).ready(function() {
            $newTeacherInput.show();
            $teacherEmailField.show();
            $teacherPhoneField.show();
        });
    </script>
    @else 
    <script>
        $(document).ready(function() {
            $buttonSelectTeacher.toggle();
            $buttonSelectFormation.toggle(); //
            $newTeacherInput.hide();
            $teacherEmailField.hide();
            $teacherPhoneField.hide();
        });
    </script>
    @endif

    @if (!isset($data_formations))
    <script>
        $(document).ready(function() {
            $newFormationInput.show();
        });
    </script>
    @else
    <script>
        $(document).ready(function() {
            $newFormationInput.hide();            
        });
    </script>
    @endif

    <script>
        $(document).ready(function() {
        // ACTIONS JUST AFTER PAGE IS LOADED
            // declaring variables
            // let $buttonNewTeacher = $('.button-new-teacher');
            // let $buttonNewFormation = $('.button-new-formation');
            // let $selectTeacher = $('.select-teacher');
            // let $selectFormation = $('.select-formation');

            // let $buttonSelectFormation = $('.button-select-formation');
            // let $buttonSelectTeacher = $('.button-select-teacher');
            // let $newFormationInput = $('.new-formation-input');
            // let $newTeacherInput = $('.new-teacher-input');

            // let $teacherEmailField = $('.teacher-email-field');
            // let $teacherPhoneField = $('.teacher-phone-field');
            // // actions
            // $buttonSelectTeacher.toggle();
            // $buttonSelectFormation.toggle();
            //     newFormationInput.toggle();
            //     $newTeacherInput.toggle();
            //     $teacherEmailField.toggle();
            //     $teacherPhoneField.toggle();
        // ------------------------------
        // ACTIONS WHEN EVENTS HAPPEN
            // when click of $buttonSelectFormation (1)
            $buttonSelectFormation.click(function() {
                // exchange input and select place : input->last , select->first
                $selectFormation.appendTo('#title-field');
                // animations
                $buttonSelectFormation.toggle('slow');
                $buttonNewFormation.toggle('slow');
                $newFormationInput.toggle('slow');
                $selectFormation.toggle('slow');
            });
            // when click of $buttonNewFormation [the reverse of (1)]
            $buttonNewFormation.click(function() {
                // exchange input and select place : input->first , select->last
                $newFormationInput.appendTo('#title-field');
                // animations
                $buttonNewFormation.toggle('slow');
                $buttonSelectFormation.toggle('slow');
                $selectFormation.toggle('slow');
                $newFormationInput.toggle('slow');
            });

            // when click of $buttonSelectTeacher (2)
            $buttonSelectTeacher.click(function() {
                // exchange input and select place : input->first , select->last
                $selectTeacher.appendTo('#teacher-name-field');
                // animations
                $buttonSelectTeacher.toggle('slow');
                $buttonNewTeacher.toggle('slow');
                $newTeacherInput.toggle('slow');
                $selectTeacher.toggle('slow');
                // No need of these fields when we just have to select from existing teachers
                $teacherEmailField.toggle('slow');
                $teacherPhoneField.toggle('slow');
            });
            // when click of $buttonNewTeacher [the reverse of (2)]
            $buttonNewTeacher.click(function() {
                // exchange input and select place : input->last , select->first
                $newTeacherInput.appendTo('#teacher-name-field');
                // animations
                $buttonNewTeacher.toggle('slow');
                $buttonSelectTeacher.toggle('slow');
                $selectTeacher.toggle('slow');
                $newTeacherInput.toggle('slow');
                // Show these fields when creating a new teacher
                $teacherEmailField.toggle('slow');
                $teacherPhoneField.toggle('slow');
            });
        });
    </script>

@stop