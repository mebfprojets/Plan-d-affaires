@extends('backend.layouts.layout')
@section('valeurs', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Valeurs</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Valeurs</li>
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
                    <h4 class="card-title float-left">Liste des valeurs</h4>
                    <div class="dt-buttons float-right">
                        <a href="{{ route('valeurs.create') }}" class="dt-button buttons-copy buttons-html5"><i class="fa fa-plus"></i> Ajouter</a>
                    </div>
                    <div class="table-responsive m-t-20">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Slug</th>
                                    <th>Paramètre</th>
                                    <th>Date de création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($valeurs as $key => $valeur)
                                <tr>
                                    <td>{{ $valeur->id }}</td>
                                    <td>{{ $valeur->libelle }}</td>
                                    <td>{{ $valeur->slug }}</td>
                                    <td>{{ $valeur->libelle_parametre }}</td>
                                    <td>{{ $valeur->created_at }}</td>
                                    <td>
                                        <a href="{{ route('valeurs.edit', $valeur->id) }}" class="btn-actions"><i class="fa fa-edit"></i></a>
                                        <button type="button" class="btn-actions btn-danger" style="color:#fff; border:0; cursor: pointer;" onclick="deleteLinge('{{ $valeur->id }}', 'valeur', 'Voulez-vous vraiment supprimer cette valeur?')"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
@endsection
