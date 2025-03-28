@extends('backend.layouts.layout')
@section('roles', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Rôles d'utilisateurs</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Rôles d'utilisateurs</a></li>
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
                    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="form-horizontal" novalidate>
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-body">
                            <h3 class="box-title">Modification rôle</h3>
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
                            <input type="hidden" name="guard_name" id="guard_name" value="admin">
                            <div class="form-group row">
                                <label class="control-label col-md-2" for="nom_role">Libellé <span class="text-danger">*</span></label>
                                <div class="col-md-4 controls">
                                    <input type="text" name="nom_role" id="nom_role" class="form-control" placeholder="Nom rôle" required data-validation-required-message="Le champ libellé est obligatoire" value="{{ old('nom_role')?old('nom_role'):$role->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-2" for="description">Description</label>
                                <div class="col-md-4">
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="5" placeholder="Description du rôle">{{ old('description', $role->description) }}</textarea>
                                </div>
                            </div>
                            <!--/row-->
                            <hr>
                            <div class="form-group row">
                                <label class="control-label col-md-2" for="confirmation_password">Permission </label>
                                <div class="col-md-9 controls">
                                    <div class="row">
                                        @foreach($permissions as $key => $permission)
                                        <div class="col-lg-4">
                                            <div class="m-b-10">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="permission_{{ $permission->id }}" name="permissions[]" class="custom-control-input" value="{{ $permission->name }}"
                                                    @foreach($role->permissions as $role_permit)
                                                       @if($role_permit->id == $permission->id)
                                                        checked
                                                       @endif
                                                    @endforeach>
                                                    <span class="custom-control-label" style="text-transform: initial; font-weight: 500;">{{ $permission->libelle}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                        <hr>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-primary btn-sm">Modifier</button>
                                            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">Annuler</a>
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
