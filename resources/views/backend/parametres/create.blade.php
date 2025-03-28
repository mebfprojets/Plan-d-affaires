@extends('backend.layouts.layout')
@section('parametres', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Paramètres des valeurs</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('parametres.index') }}">Paramètres des valeurs</a></li>
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
                    <form action="{{ route('parametres.store') }}" method="POST" class="form-horizontal" novalidate>
                        {{ csrf_field() }}
                        <div class="form-body">
                            <h3 class="box-title">Nouveau paramètre</h3>
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
                                    <!--Libelle-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="nom_parametre">Libellé <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="nom_parametre" id="nom_parametre" class="form-control" placeholder="Nom paramètre" required data-validation-required-message="Le champ libellé est obligatoire">
                                        </div>
                                    </div>
                                    <!--/Libelle-->
                                    <!--/Description-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="description">Description</label>
                                        <div class="col-md-9">
                                            <textarea name="description" id="description" class="form-control" cols="30" rows="5" placeholder="Description du paramètre"></textarea>
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
                                            <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                                            <button type="button" class="btn btn-default btn-sm">Annuler</button>
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
