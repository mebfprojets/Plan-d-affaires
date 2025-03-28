@extends('backend.layouts.layout')
@section('packs', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Packs de plans d'affaire</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('packs.index') }}">Packs de plans d'affaire</a></li>
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
                    <form action="{{ route('packs.store') }}" method="POST" class="form-horizontal" novalidate>
                        {{ csrf_field() }}
                        <div class="form-body">
                            <h3 class="box-title">Nouveau pack</h3>
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
                                        <label class="control-label col-md-3" for="libelle">Libellé <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="libelle" id="libelle" class="form-control" placeholder="Nom pack" required data-validation-required-message="Le champ libellé est obligatoire" value="{{ old('libelle') }}">
                                        </div>
                                    </div>
                                    <!--/Libelle-->
                                    <!--Libelle-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="cout_pack">Coût <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="number" name="cout_pack" id="cout_pack" class="form-control" placeholder="FCFA" required data-validation-required-message="Le champ libellé est obligatoire" value="{{ old('cout_pack') }}">
                                        </div>
                                    </div>
                                    <!--/Libelle-->
                                    <!--Description-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="description">Description</label>
                                        <div class="col-md-9">
                                            <textarea name="description" id="description" class="form-control" cols="30" rows="5" placeholder="Description de la pack"></textarea>
                                        </div>
                                    </div>
                                    <!--/Description-->
                                    <hr>
                                    <!--Objectifs-->
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">N°</th>
                                                    <th scope="col">Objectifs du pack</th>
                                                </tr>
                                            </thead>
                                            <tbody id="objectifs-table">
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td><input type="text" name="objectifs_pack[]" class="form-control" placeholder="Objectif"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="addObjectRow()">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--/Objectifs-->
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
                                            <a href="{{ route('packs.index') }}" class="btn btn-secondary btn-sm">Annuler</a>
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
