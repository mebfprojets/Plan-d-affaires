@extends('backend.layouts.layout')
@section('permissions', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Permissions des rôles</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions des rôles</a></li>
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
                    <form action="{{ route('permissions.store') }}" method="POST" class="form-horizontal" novalidate>
                        {{ csrf_field() }}
                        <div class="form-body">
                            <h3 class="box-title">Nouvelle permission</h3>
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
                                        <label class="control-label col-md-3" for="nom_permission">Libellé <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="nom_permission" id="nom_permission" class="form-control" placeholder="Nom permission" required data-validation-required-message="Le champ libellé est obligatoire" value="{{ old('nom_permission') }}">
                                        </div>
                                    </div>
                                    <!--/Libelle-->
                                    <!--Description-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="description">Description</label>
                                        <div class="col-md-9">
                                            <textarea name="description" id="description" class="form-control" cols="30" rows="5" placeholder="Description de la permission"></textarea>
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
