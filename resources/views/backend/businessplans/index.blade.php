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
                    <div class="table-responsive m-t-20">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#to_imput" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">PA à imputer</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#imput" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">PA imputés</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#finish" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">PA terminés</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#all" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Tous</span></a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">


                            <!-- PA TO IMPUT -->
                            <div class="tab-pane active p-20" id="to_imput" role="tabpanel">
                                @php
                                    $ibusinessplans = $businessplans->filter(function ($ibusinessplan) {
                                        return ($ibusinessplan->id_admin_imput == null) !== false;
                                    });
                                @endphp
                                <h2>Plans d'affaires à imputer</h2>
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
                                        @foreach($ibusinessplans as $key => $ibusinessplan)
                                        <tr>
                                            <td>{{ $ibusinessplan->pack?$ibusinessplan->pack->libelle:'' }}</td>
                                            <td style="white-space: pre-line;">{!! nl2br(e(Str::limit($ibusinessplan->business_idea, 100))) !!}</td>
                                            <td>{{ $ibusinessplan->montant_emprunt }}</td>
                                            <td>{{ $ibusinessplan->created_at }}</td>
                                            <td>
                                                @can('businessplans.index')
                                                <a href="{{ route('businessplans.show', $ibusinessplan->id) }}" class="btn-actions"><i class="fa fa-eye"></i></a>
                                                @endcan
                                                @can('businessplans.imputer')
                                                <a href="#" title="Imputer" data-toggle="modal" data-target="#bs-imput-modal" class="btn-actions @if($ibusinessplan->id_admin_imput) btn-primary @endif" onclick="getPA('{{ $ibusinessplan->id }}', 'imputer')" @if($ibusinessplan->id_admin_imput) style="color:#fff; border:0; cursor: pointer;" @endif><i class="fa fa-user"></i></a>
                                                @endcan
                                                @can('businessplans.delete')
                                                <button type="button" class="btn-actions btn-danger" style="color:#fff; border:0; cursor: pointer;" onclick="deleteLinge('{{ $ibusinessplan->id }}', 'plan_affaire', 'Voulez-vous vraiment supprimer ce plan d\'affaire?')"><i class="fa fa-trash"></i></button>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- PA IMPUT -->
                            <div class="tab-pane p-20" id="imput" role="tabpanel">
                                @php
                                    $imbusinessplans = $businessplans->filter(function ($imbusinessplan) {
                                        return ($imbusinessplan->id_admin_imput != null) !== false;
                                    });
                                @endphp
                                <h2>Plans d'affaires imputés</h2>
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
                                        @foreach($imbusinessplans as $key => $imbusinessplan)
                                        <tr>
                                            <td>{{ $imbusinessplan->pack?$imbusinessplan->pack->libelle:'' }}</td>
                                            <td style="white-space: pre-line;">{!! nl2br(e(Str::limit($imbusinessplan->business_idea, 100))) !!}</td>
                                            <td>{{ $imbusinessplan->montant_emprunt }}</td>
                                            <td>{{ $imbusinessplan->created_at }}</td>
                                            <td>
                                                @can('businessplans.editer')
                                                @if($imbusinessplan->id_admin_imput && !$imbusinessplan->is_valide)
                                                <a href="{{ route('business_plans.edit', $imbusinessplan->id) }}" class="btn-actions"><i class="fa fa-pencil"></i></a>
                                                @endif
                                                @endcan
                                                @can('businessplans.index')
                                                <a href="{{ route('businessplans.show', $imbusinessplan->id) }}" class="btn-actions"><i class="fa fa-eye"></i></a>
                                                @endcan
                                                @can('businessplans.imputer')
                                                <a href="#" title="Imputer" data-toggle="modal" data-target="#bs-imput-modal" class="btn-actions @if($imbusinessplan->id_admin_imput) btn-primary @endif" onclick="getPA('{{ $imbusinessplan->id }}', 'imputer')" @if($imbusinessplan->id_admin_imput) style="color:#fff; border:0; cursor: pointer;" @endif><i class="fa fa-user"></i></a>
                                                @endcan
                                                @can('businessplans.download')
                                                    @if($imbusinessplan->is_valide)
                                                        <a href="{{ route('businessplans.download', $imbusinessplan->id) }}" class="btn-actions"><i class="fa fa-book"></i></a>
                                                    @endif
                                                @endcan
                                                @can('businessplans.delete')
                                                <button type="button" class="btn-actions btn-danger" style="color:#fff; border:0; cursor: pointer;" onclick="deleteLinge('{{ $imbusinessplan->id }}', 'plan_affaire', 'Voulez-vous vraiment supprimer ce plan d\'affaire?')"><i class="fa fa-trash"></i></button>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- FINAL PA -->
                            <div class="tab-pane p-20" id="finish" role="tabpanel">
                                @php
                                    $vbusinessplans = $businessplans->filter(function ($vbusinessplan) {
                                        return ($vbusinessplan->is_paye == true) !== false;
                                    });
                                @endphp
                                <h2>Plans d'affaires terminés</h2>
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
                                        @foreach($vbusinessplans as $key => $vbusinessplan)
                                        <tr>
                                            <td>{{ $vbusinessplan->pack?$vbusinessplan->pack->libelle:'' }}</td>
                                            <td style="white-space: pre-line;">{!! nl2br(e(Str::limit($vbusinessplan->business_idea, 100))) !!}</td>
                                            <td>{{ $vbusinessplan->montant_emprunt }}</td>
                                            <td>{{ $vbusinessplan->created_at }}</td>
                                            <td>
                                                @can('businessplans.index')
                                                <a href="{{ route('businessplans.show', $vbusinessplan->id) }}" class="btn-actions"><i class="fa fa-eye"></i></a>
                                                @endcan

                                                @can('businessplans.download')
                                                    @if($vbusinessplan->is_valide)
                                                        <a href="{{ route('businessplans.download', $vbusinessplan->id) }}" class="btn-actions"><i class="fa fa-book"></i></a>
                                                    @endif
                                                @endcan
                                                @can('businessplans.cloturer')
                                                <a href="#" title="Clôtuer" data-toggle="modal" data-target="#bs-cloture-modal" class="btn-actions" onclick="getPA('{{ $vbusinessplan->id }}', 'cloturer')"><i class="fa fa-upload"></i></a>
                                                @endcan
                                                @can('businessplans.delete')
                                                <button type="button" class="btn-actions btn-danger" style="color:#fff; border:0; cursor: pointer;" onclick="deleteLinge('{{ $vbusinessplan->id }}', 'plan_affaire', 'Voulez-vous vraiment supprimer ce plan d\'affaire?')"><i class="fa fa-trash"></i></button>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- ALL PA -->
                            <div class="tab-pane" id="all" role="tabpanel">
                                <h2>Tous les plans d'affaires</h2>
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
                                            <td style="white-space: pre-line;">{!! nl2br(e(Str::limit($businessplan->business_idea, 100))) !!}</td>
                                            <td>{{ $businessplan->montant_emprunt }}</td>
                                            <td>{{ $businessplan->created_at }}</td>
                                            <td>
                                                @can('businessplans.editer')
                                                @if($businessplan->id_admin_imput && !$businessplan->is_valide)
                                                <a href="{{ route('business_plans.edit', $businessplan->id) }}" class="btn-actions"><i class="fa fa-pencil"></i></a>
                                                @endif
                                                @endcan
                                                @can('businessplans.index')
                                                <a href="{{ route('businessplans.show', $businessplan->id) }}" class="btn-actions"><i class="fa fa-eye"></i></a>
                                                @endcan
                                                @can('businessplans.imputer')
                                                <a href="#" title="Imputer" data-toggle="modal" data-target="#bs-imput-modal" class="btn-actions @if($businessplan->id_admin_imput) btn-primary @endif" onclick="getPA('{{ $businessplan->id }}', 'imputer')" @if($businessplan->id_admin_imput) style="color:#fff; border:0; cursor: pointer;" @endif><i class="fa fa-user"></i></a>
                                                @endcan
                                                @can('businessplans.download')
                                                    @if($businessplan->is_valide)
                                                        <a href="{{ route('businessplans.download', $businessplan->id) }}" class="btn-actions"><i class="fa fa-book"></i></a>
                                                    @endif
                                                @endcan
                                                @can('businessplans.cloturer')
                                                <a href="#" title="Clôtuer" data-toggle="modal" data-target="#bs-cloture-modal" class="btn-actions" onclick="getPA('{{ $businessplan->id }}', 'cloturer')"><i class="fa fa-upload"></i></a>
                                                @endcan
                                                @can('businessplans.delete')
                                                <button type="button" class="btn-actions btn-danger" style="color:#fff; border:0; cursor: pointer;" onclick="deleteLinge('{{ $businessplan->id }}', 'plan_affaire', 'Voulez-vous vraiment supprimer ce plan d\'affaire?')"><i class="fa fa-trash"></i></button>
                                                @endcan
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
                                    <option>Selectionner un conseiller</option>
                                    @foreach ($admins as $admin)
                                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date_imput" class="control-label">Date d'imputation:</label>
                                <input type="date" class="form-control" id="date_imput">
                            </div>
                            <div class="form-group" id="motif_area" style="display: none;">
                                <label for="motif_imput" class="control-label">Motif de  réimputation:</label>
                                <textarea class="form-control" id="motif_imput" placeholder="Motif de la réimputation"></textarea>
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
<!-- sample modal content -->
<div id="bs-cloture-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('businessplans.cloturer') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Importer un plan d'affaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="p-3" style="display: table-cell; box-shadow: 12px 0 15px -15px rgba(0,0,0,0.4);">
                            <h4 id="imput-title_clos">PACK</h4>
                            <hr>
                            <b class="text-black mt-5 fw-bold">Idée du projet</b>
                            <p id="imput-idea_clos"></p>
                            <b class="text-black mt-5 fw-bold">Objectifs du projet</b>
                            <p id="imput-object_clos"></p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <input type="hidden" id="id_plan_affaire_clos" name="id_plan_affaire_clos">
                        <div class="form-group">
                            <label for="date_cloture" class="control-label">Date de clôture:</label>
                            <input type="date" class="form-control" id="date_cloture" name="date_cloture" value="{{ date('Y-m-d') }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="file_path" class="control-label">Plan d'affaire:</label>
                            <input type="file" class="form-control" name="file_path" accept="application/pdf">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" type="submit" class="btn btn-primary waves-effect text-left btn-sm">Clôturer</button>
                <button type="button" class="btn btn-danger waves-effect text-left btn-sm" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection
