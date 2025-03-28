@extends('backend.layouts.layout')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Plans d'affaire</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Plans d'affaire</li>
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
                    <h4 class="card-title float-left">Liste des plans d'affaire</h4>
                    <div class="dt-buttons float-right">
                        <a href="#" class="dt-button buttons-copy buttons-html5"><i class="fa fa-plus"></i> Ajouter</a>
                    </div>
                    <div class="table-responsive m-t-20">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Pack</th>
                                    <th>Idée du projet</th>
                                    <th>Promoteur</th>
                                    <th>Montant emprunt</th>
                                    <th>Date création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($businessplans as $key => $businessplan)
                                <tr>
                                    <td>{{ $businessplan->pack?$businessplan->pack->libelle:'' }}</td>
                                    <td>{{ $businessplan->business_idea }}</td>
                                    <td>{{ $businessplan->business_idea }}</td>
                                    <td>{{ $businessplan->montant_emprunt }}</td>
                                    <td>{{ $businessplan->created_at }}</td>
                                    <td>
                                        <a href="{{ route('packs.edit', $businessplan->id) }}" class="btn-actions"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('businessplans.download', $businessplan->id) }}" class="btn-actions"><i class="fa fa-book"></i></a>
                                        <button type="button" class="btn-actions btn-danger" style="color:#fff; border:0; cursor: pointer;" onclick="deleteLinge({{ $businessplan->id }}, 'pack', 'Voulez-vous vraiment supprimer cette pack?')"><i class="fa fa-trash"></i></button>
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
