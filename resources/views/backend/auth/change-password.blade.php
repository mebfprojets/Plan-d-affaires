@extends('backend.layouts.layout')
@section('valeurs', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Changement de mot de passwe</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('valeurs.index') }}">Changement de mot de passwe</a></li>
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
                    <form action="{{ route('password.update') }}" method="POST" class="form-horizontal" novalidate>
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-body">
                            <h3 class="box-title">Changement de mot de passe</h3>
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
                                <div class="col-md-8">
                                    <!--Ancien-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-4" for="current_password">Mot de passe actuel <span class="text-danger">*</span></label>
                                        <div class="col-md-8 controls">
                                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="********" required data-validation-required-message="L'ancien mot de passe est obligatoire">
                                            @error('current_password') <small>{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <!--/Ancien-->
                                    <!--Nouveau-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-4" for="password">Nouveau mot de passe <span class="text-danger">*</span></label>
                                        <div class="col-md-8 controls">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="********" required data-validation-required-message="Le nouveau mot de passe est obligatoire">
                                            @error('password') <small>{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <!--/Nouveau-->
                                    <!--Confirmation-->
                                    <div class="form-group row">
                                        <label class="control-label col-md-4" for="password_confirmation">Confirmer le mot de passe</label>
                                        <div class="col-md-8">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="********" required data-validation-required-message="Le champ libellé est obligatoire">
                                            @error('password_confirmation') <small>{{ $message }}</small> @enderror
                                        </div>
                                    </div>
                                    <!--/Confirmation-->
                                </div>


                            </div>
                            <!--/row-->
                        <hr>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-primary btn-sm">Changer</button>
                                            <a href="{{ route('admins.index') }}" class="btn btn-secondary btn-sm">Annuler</a>
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
