@extends('backend.layouts.layout')
@section('promoteurs', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Promoteurs</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Promoteurs</li>
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
                    <h4 class="card-title float-left">Liste des promoteurs</h4>
                    <div class="table-responsive m-t-20">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Entreprise</th>
                                    <th>Sexe</th>
                                    <th>Age</th>
                                    <th>Domicile</th>
                                    <th>Adresse</th>
                                    <th>Niveau formation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($promoteurs as $key => $promoteur)
                                <tr>
                                    <td>{{ $promoteur->id }}</td>
                                    <td>{{ $promoteur->entreprise->denomination }}</td>
                                    <td>{{ $promoteur->sexe->libelle }}</td>
                                    <td>{{ $promoteur->age }}</td>
                                    <td>{{ $promoteur->domicile }}</td>
                                    <td>{{ $promoteur->adresse }}</td>
                                    <td>{{ $promoteur->niveau_formation }}</td>
                                    <td>
                                        <a href="{{ route('promoteurs.show', $promoteur->id) }}" class="btn-actions"><i class="fa fa-eye"></i></a>
                                        <button type="button" class="btn-actions btn-danger" style="color:#fff; border:0; cursor: pointer;" onclick="deleteLinge({{ $promoteur->id }}, 'promoteur', 'Voulez-vous vraiment supprimer cette promoteur?')"><i class="fa fa-trash"></i></button>
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
