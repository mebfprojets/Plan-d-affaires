@extends('backend.layouts.layout')
@section('entreprises', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Entreprises</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Entreprises</li>
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
                    <h4 class="card-title float-left">Liste des entreprises</h4>
                    <div class="table-responsive m-t-20">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dénomination</th>
                                    <th>Forme juridique</th>
                                    <th>Date création prévue</th>
                                    <th>Localisation</th>
                                    <th>Engagement Inst.</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($entreprises as $key => $entreprise)
                                <tr>
                                    <td>{{ $entreprise->id }}</td>
                                    <td>{{ $entreprise->denomination }}</td>
                                    <td>{{ $entreprise->forme_juridique }}</td>
                                    <td>{{ $entreprise->date_creation_prevue }}</td>
                                    <td>{{ $entreprise->localisation }}</td>
                                    <td>{{ $entreprise->engagement_institution }}</td>
                                    <td>
                                        <a href="{{ route('entreprises.show', $entreprise->id) }}" class="btn-actions"><i class="fa fa-eye"></i></a>
                                        <button type="button" class="btn-actions btn-danger" style="color:#fff; border:0; cursor: pointer;" onclick="deleteLinge({{ $entreprise->id }}, 'entreprise', 'Voulez-vous vraiment supprimer cette entreprise?')"><i class="fa fa-trash"></i></button>
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
