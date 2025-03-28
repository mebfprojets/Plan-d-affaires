@extends('backend.layouts.layout')
@section('admins', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Utilisateurs</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">Utilisateurs</a></li>
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
                    <form action="{{ route('admins.update', $admin->id) }}" method="POST" class="form-horizontal" novalidate>
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-body">
                            <h3 class="box-title">Modifier utilisateur</h3>
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
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="name">Nom et Prénom <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Nom et prénom" required data-validation-required-message="Le champ nom est obligatoire" value="{{ old('name')?old('name'):$admin->name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="email">Email <span class="text-danger">*</span></label>
                                        <div class="col-md-9 controls">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="user@email.com" required data-validation-required-message="Le champ email est obligatoire" value="{{ old('email')?old('email'):$admin->email }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="statut">Actif? </label>
                                        <div class="col-md-9 controls">
                                            <input type="checkbox" id="md_checkbox_29" name="statut" class="filled-in chk-col-teal" checked value="1" />
                                            <label for="md_checkbox_29"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3" for="role">Rôle </label>
                                        <div class="col-md-9 controls">
                                            <div class="row">
                                                @foreach($roles as $key => $role)
                                                <div class="col-lg-4">
                                                    <input type="checkbox" id="role_{{ $role->id }}" name="roles[]" class="filled-in chk-col-blue-grey" value="{{ $role->name }}"
                                                    @foreach($admin->roles as $admin_role)
                                                       @if($admin_role->id == $role->id)
                                                        checked
                                                       @endif
                                                    @endforeach />
                                                    <label for="role_{{ $role->id }}" style="text-transform: initial;">{{ $role->name }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->

                            </div>
                            <!--/row-->
                        <hr>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-primary btn-sm">Modifier</button>
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
