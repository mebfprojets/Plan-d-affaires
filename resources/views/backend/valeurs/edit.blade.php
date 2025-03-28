@extends('backend.layouts.layout')
@section('valeurs', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Valeurs des valeurs</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('valeurs.index') }}">Valeurs des valeurs</a></li>
            <li class="breadcrumb-item active">Créer</li>
        </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('valeurs.update', $valeur->id) }}" method="POST" class="form-horizontal" novalidate>
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-body">
                            <h3 class="box-title">Modifier une valeur de paramètre</h3>
                            <hr class="m-t-0 m-b-40">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <!--Parametre-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="id_parametre">Paramètre <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <select class="select2 form-control custom-select" name="id_parametre" name="id_parametre" style="width: 100%; height:36px;">
                                                <option>Selectionner une valeur</option>
                                                @foreach($parametres as $parametre)
                                                    <option value="{{ $parametre->id }}" @if($parametre->id == $valeur->id_parametre) selected @endif>{{ $parametre->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--/Parametre-->
                                    <!--Libelle-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="nom_valeur">Libellé <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="nom_valeur" id="nom_valeur" class="form-control" placeholder="Nom valeur" required data-validation-required-message="Le champ libellé est obligatoire" value="{{ old('nom_valeur')?old('nom_valeur'):$valeur->libelle }}">
                                        </div>
                                    </div>
                                    <!--/Libelle-->
                                    <!--Description-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="description">Description</label>
                                        <div class="col-md-9">
                                            <textarea name="description" id="description" class="form-control" cols="30" rows="5" placeholder="Description du paramètre">{{ old('description')?old('description'):$valeur->description }}</textarea>
                                        </div>
                                    </div>
                                    <!--/Description-->
                                </div>


                            </div>
                            <!--/row-->
                        <hr>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-primary btn-sm">Modifier</button>
                                            <a href="{{ route('valeurs.index') }}" class="btn btn-secondary btn-sm">Annuler</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"> </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
@endsection
