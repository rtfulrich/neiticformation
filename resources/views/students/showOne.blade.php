@extends('adminlte::page')

@section('title') 
    {{ $student->fname }} {{ $student->lname }} | Détails
@stop

@section('content')
    <div id="confirm-delete">
        <div class="confirmation position-fixed d-flex justify-content-center align-items-center vh-100 vw-100" style="margin-top: -100px; margin-bottom: 50px; z-index: 4; background: rgba(0, 0, 0, 0.7);">
            <div class="row d-flex justify-content-center d-md-block">
                <div class="col-10 offset-md-1 col-md-6">
                    <div class="card" style="margin-top: -20px">
                        <header class="card-header bg-danger">
                            <h2 class="text-center text-dark font-weight-bold">
                                Voulez-vous vraiment supprimer <span class="text-capitalize text-light">{{ $student->fname }} <span class="text-uppercase">{{ $student->lname }}</span></span> parmi les étudiants ?
                            </h2>
                        </header>
                        <div class="card-body d-flex justify-content-center px-3">
                            <form id="form-delete" action="{{ route('student.delete', $student->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-success mr-5 font-weight-bold">OUI, JE CONFIRME</button>
                            </form>
                            <button id="delete-cancel" onclick="cancelDelete()" class="btn btn-primary ml-5 font-weight-bold">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <header class="card-header bg-warning">
                    <h1 class="h2 font-weight-bold text-center text-capitalize">{{ $student->fname }} <span class="text-uppercase">{{ $student->lname }}</span></h1>
                </header>
                <div class="card-body py-0 pt-2">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('storage/default.png') }}" class="img-fluid">
                        </div>
                        <div class="col-9">
                            <div class="font-weight-normal d-flex">
                                Ecolage (AR) : <span class="font-weight-bold mx-1">{{ number_format($student->school_fee_paid, 0, ',', '.') }}</span> sur <span class="font-weight-bold mx-1">{{ number_format($total_fee, 0, ',', '.') }}</span> 
                                <span class="font-weight-bold text-info ml-auto d-block"> ({{ round($student->school_fee_paid / $total_fee * 100) }} %)</span>
                            </div>
                            <div class="bg-dark" style="height: 10px; width:100%">
                                <span class="bg-info d-inline-block" style="height: 100%; max-width: 100%; width: {{ $student->school_fee_paid / $total_fee * 100 }}%; position: relative; top: -8px"></span>
                            </div>
                            <form action="{{ route('student.pay', $student->id) }}" method="post" >
                                @csrf @method('PUT')
                                <div class="form-group mt-md-2 mt-lg-3">
                                    <label for="school_fee_paid">Payer Une Somme De :</label>
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control" placeholder="Somme à Payer" aria-label="Recipient's username" name="school_fee_paid" id="school_fee_paid" aria-describedby="basic-addon2" step="1000" autofocus>
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text font-weight-bold">AR</button>
                                            <button type="submit" class="btn btn-success" title="Ajouter La Somme" type="button"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-sm table-hover">
                        <tbody>
                            <tr class="font-weight-bold">
                                <td>Formation : </td>
                                <td class="text-capitalize"><a href="{{ route('formation.session.showWithFormationId', $student->formationSession->formation->id) }}" class="text-info">{{ $student->formationSession->formation->title }}</a> | Vn° {{ $student->formationSession->session_number }} | <a class="mx-2" href="{{ route('formation.session.showOne', $student->formation_session_id) }}"><i class="fas fa-eye"></i></a></td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td>Date de Naissance : </td>
                                <td>{{ date_create($student->birth_date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td>Sexe / Situation : </td>
                                <td>{{ $student->sex == 'man' ? 'Homme' : 'Femme' }} / {{ $student->family_situation == 'single' ? 'Célibataire' : 'Marié(e)' }}</td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td>Machine : </td>
                                <td>{{ $student->machine_number ? 'Numéro '.$student->machine_number : 'Il/Elle utilise la sienne' }}</td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td style="vertical-align: middle">Email :</td>
                                <td @if (!$student->email) class="text-danger" @endif>{{ $student->email ?? '????????'}}    </td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td style="vertical-align: middle">Téléphone :</td>
                                <td @if (!$student->phone) class="text-danger" @endif>{{ $student->phone ?? '????????'}}    </td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td style="vertical-align: middle">Nombre d'Enfants :</td>
                                <td @if (!$student->children_number) class="text-danger" @endif>{{ $student->children_number ?? 'Aucun'}}    </td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td style="vertical-align: middle">Niveau d'Etude :</td>
                                <td @if (!$student->study_level) class="text-danger" @endif>{{ $student->study_level ?? '????????'}}    </td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td style="vertical-align: middle">Adresse :</td>
                                <td @if (!$student->address) class="text-danger" @endif>{{ $student->address ?? '????????'}}    </td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td style="vertical-align: middle">CIN :</td>
                                <td @if (!$student->cin) class="text-danger" @endif>{{ $student->cin ?? '????????'}}    </td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td style="vertical-align: middle">Job Actuel :</td>
                                <td @if (!$student->cin) class="text-danger" @endif>{{ $student->cin ?? '????????'}}    </td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td style="vertical-align: middle">Inscrit Le :</td>
                                <td>{{ date_create($student->created_at)->format('d/m/Y') }}   </td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td style="vertical-align: middle">Dernière Modification :</td>
                                <td>{{ date_create($student->updated_at)->format('d/m/Y') }}   </td>
                            </tr>
                            <tr class="font-weight-bold text-primary">
                                <td style="vertical-align: middle">Certifié(e) ? </td>
                                <td>{{ $student->certified ? 'OUI    >>   le '.date_create($student->certified_at)->format('d/m/Y') : 'NON' }}   </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button id="delete-student-button" class="btn btn-danger" title="Supprimer {{ $student->fname }} {{ $student->lname }}"><i class="fas fa-trash"></i></button>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header bg-warning">
                    <div class="d-flex">
                        <h1 class="text-capitalize text-center h2 font-weight-bold mb-2 mx-auto">Formulaire de Modification</h1>
                    </div>
                </div>
                <div class="card-body bg-dark text-light">
                    <form id="form-section-student" action="{{ route('student.update', $student->id) }}" method="post" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="fname">Prénoms</label>
                                    <input type="text" id="fname" name="fname" class="form-control  font-weight-bold @if ($errors->has('fname')) border border-danger @endif" @if ($errors->any()) value="{{ old('fname') }}" @else value="{{ $student->fname }}" @endif autofocus>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="lname">Nom</label>
                                    <input type="text" id="lname" name="lname"  @if ($errors->any()) value="{{ old('lname') }}" @else value="{{ $student->lname ?? '' }}" @endif  class="form-control  font-weight-bold @if ($errors->has('lname')) border border-danger @endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <small class="text-info">(facultatif)</small></label>
                                    <input type="email" id="email" name="email"  @if ($errors->any()) value="{{ old('email') }}" @else value="{{ $student->email ?? '' }}" @endif  class="form-control  font-weight-bold @if ($errors->has('email')) border border-danger @endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group input-group">
                                    <label for="phone">Téléphone <small class="text-info">(facultatif)</small></label>
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-secondary"><i class="fas fa-phone"></i></button>
                                        <input type="text" name="phone"  @if ($errors->any()) value="{{ old('phone') }}" @else value="{{ $student->phone ?? '' }}" @endif placeholder="03x xx xxx xx" class="form-control  font-weight-bold @if ($errors->has('phone')) border border-danger @endif">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="birth_date">Date De Naissance <small class="text-info">(obligatoire)</small></label>
                                    <input type="date" name="birth_date"  @if ($errors->any()) value="{{ old('birth_date') }}" @else value="{{ $student->birth_date ?? '' }}" @endif id="birth_date" class="form-control  font-weight-bold @if ($errors->has('birth_date')) border border-danger @endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="address">Adresse <small class="text-info">(facultatif)</small></label>
                                    <input type="text" id="address" name="address"  @if ($errors->any()) value="{{ old('address') }}" @else value="{{ $student->address ?? '' }}" @endif  class="form-control  font-weight-bold @if ($errors->has('address')) border border-danger @endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="cin">CIN <small class="text-info">(facultatif)</small> </label>
                                    <input type="text" id="cin" name="cin"  @if ($errors->any()) value="{{ old('cin') }}" @else value="{{ $student->cin ?? '' }}" @endif placeholder="ex: 137.920.392.902" class="form-control  font-weight-bold @if ($errors->has('cin')) border border-danger @endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="sex">Sexe <small class="text-info">(obligatoire)</small></label>
                                    <select name="sex" id="sex" class="form-control @if ($errors->has('sex')) border border-danger @endif">
                                        <option>Sélectionner le sexe ici : </option>
                                        <option value="man" @if ($errors->any()) @if (old('sex') == 'man') selected @endif @elseif ($student->sex == 'man') selected @endif class="font-weight-bold">Homme</option>
                                        <option value="woman" @if ($errors->any()) @if (old('sex') == 'woman') selected @endif @elseif ($student->sex == 'woman') selected @endif class="font-weight-bold">Femme</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="actual_job">Job Actuel <small class="text-info">(facultatif)</small></label>
                                    <input type="text" id="actual_job" name="actual_job"  @if ($errors->any()) value="{{ old('actual_job') }}" @else value="{{ $student->actual_job ?? '' }}" @endif  class="form-control  font-weight-bold @if ($errors->has('actual_job')) border border-danger @endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="photo">Photo <small class="text-info">(facultatif)</small></label>
                                    <input type="file" id="photo" name="photo" @if ($errors->any()) value="{{ old('photo') }}" @endif class="form-control  font-weight-bold bg-dark @if ($errors->any()) border border-danger @endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="machine_number">Numéro machine <small class="text-info">(facultatif)</small></label>
                                    <input type="number" id="machine_number" @if ($errors->any()) value="{{ old('machine_number') }}" @else value="{{ $student->machine_number ?? '' }}" @endif  min="0" class="form-control  font-weight-bold @if ($errors->has('machine_number')) border border-danger @endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="family_situation">Situation familiale <small class="text-info">(obligatoire)</small></label>
                                    <select name="family_situation" id="family_situation" class="form-control @if ($errors->has('family_situation')) border border-danger @endif">
                                        <option>Situation Familiale : </option>
                                        <option value="single" @if ($errors->any()) @if (old('family_situation') == 'single') selected @endif @elseif ($student->family_situation == 'single') selected @endif class="font-weight-bold">Célibataire</option>
                                        <option value="married" @if ($errors->any()) @if (old('family_situation') == 'married') selected @endif @elseif ($student->family_situation == 'married') selected @endif class="font-weight-bold">Marié(e)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="children_number">Nombre d'enfants <small class="text-info">(facultatif)</small></label>
                                    <input type="number" id="children_number" name="children_number"  @if ($errors->any()) value="{{ old('children_number') }}" @else value="{{ $student->children_number ?? '' }}" @endif min="1" class="form-control  font-weight-bold @if ($errors->has('childer_number')) border border-danger @endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                        <label for="study_level">Niveau d'Etude <small class="text-info">(facultatif)</small></label>
                                    <input type="text" id="study_level" name="study_level" @if ($errors->any()) value="{{ old('study_level') }}" @else value="{{ $student->study_level ?? '' }}" @endif class="form-control  font-weight-bold @if ($errors->has('study_level')) border border-danger @endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="certified">Certifié(e) ? <small class="text-info">(facultatif)</small></label>
                                    <select name="certified" id="certified" class="form-control @if ($errors->has('certified')) border border-danger @endif">
                                        <option>Donner la Certification ? </option>
                                        <option value="0" @if ($errors->any()) @if (old('certified') == '0') selected @endif @elseif ($student->certified == 0) selected @endif class="font-weight-bold">NON</option>
                                        <option value="1" @if ($errors->any()) @if (old('certified') == '1') selected @endif @elseif ($student->certified == '1') selected @endif class="font-weight-bold">OUI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group" style="height: 70px; margin-top: -32px">
                                    <label style="visibility: hidden">sfsjflk</label>
                                    <button type="submit" class="btn btn-success form-control h-100 align-bottom">MODIFIER</button>
                                </div>
                            </div>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    const confirmDelete = $('#confirm-delete');
    const deleteStudentButton = $('#delete-student-button');
    const deleteCancel = $('#delete-cancel');

    confirmDelete.toggle();

    $(document).ready( () => {
        deleteStudentButton.click( () => {
            confirmDelete.toggle('slow');
        });

        deleteCancel.click( () => {
            confirmDelete.toggle('slow');
        });
    });
</script>
@stop