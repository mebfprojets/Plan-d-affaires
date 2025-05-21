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
                                    <td>{{ $businessplan->montant_emprunt }}</td>
                                    <td>{{ $businessplan->created_at }}</td>
                                    <td>
                                        <a href="{{ route('business_plans.edit', $businessplan->id) }}" class="btn-actions"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ route('businessplans.show', $businessplan->id) }}" class="btn-actions"><i class="fa fa-eye"></i></a>
                                        <a href="#" title="Imputer" data-toggle="modal" data-target="#bs-imput-modal" class="btn-actions" onclick="getPA('{{ $businessplan->id }}')"><i class="fa fa-user"></i></a>
                                        @can('businessplans.download')
                                            <a href="{{ route('businessplans.download', $businessplan->id) }}" class="btn-actions"><i class="fa fa-book"></i></a>
                                        @endcan
                                        <button type="button" class="btn-actions btn-danger" style="color:#fff; border:0; cursor: pointer;" onclick="deleteLinge('{{ $businessplan->id }}', 'plan_affaire', 'Voulez-vous vraiment supprimer ce plan d\'affaire?')"><i class="fa fa-trash"></i></button>
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

<!-- sample modal content -->
<div id="bs-imput-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Imputer un plan d'affaire à un conseiller</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="p-3" style="display: table-cell; box-shadow: 12px 0 15px -15px rgba(0,0,0,0.4);">
                            <h4 id="imput-title">PACK</h4>
                            <hr>
                            <b class="text-black mt-5 fw-bold">Idée du projet</b>
                            <p id="imput-idea"></p>
                            <b class="text-black mt-5 fw-bold">Objectifs du projet</b>
                            <p id="imput-object"></p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <form>
                            <input type="hidden" id="id_plan_affaire">
                            <div class="form-group">
                                <label for="id_conseiller" class="control-label">Conseiller:</label>
                                <select class="select2 form-control custom-select" id="id_conseiller" style="width: 100%; height:36px;">
                                    <option>Select</option>
                                    @foreach ($admins as $admin)
                                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date_imput" class="control-label">Date d'imputation:</label>
                                <input type="date" class="form-control" id="date_imput">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect text-left btn-sm" onclick="saveImputation();">Enregistrer</button>
                <button type="button" class="btn btn-danger waves-effect text-left btn-sm" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection
