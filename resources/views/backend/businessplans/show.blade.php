@extends('backend.layouts.layout')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Plan d'affaire</h3>
    </div>
    <div class="col-md-7 col-4 align-self-center">
        <div class="d-flex m-t-10 justify-content-end">
            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                <div class="chart-text m-r-10">
                    <h6 class="m-b-0"><small>PACK</small></h6>
                    <h4 class="m-t-0 text-info">{{ $business_plan->pack->libelle }}</h4></div>
                <div class="spark-chart">
                    <div id="monthchart"></div>
                </div>
            </div>
            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                <div class="chart-text m-r-10">
                    <h6 class="m-b-0"><small>MONTANT</small></h6>
                    <h4 class="m-t-0 text-primary">{{ $business_plan->pack->cout_pack }}</h4></div>
                <div class="spark-chart">
                    <div id="lastmonthchart"></div>
                </div>
            </div>
            <div class="">
                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    @can('businessplans.valider')
    <div class="my-3 text-right">
        @if(!$business_plan->is_valide)<a class="btn btn-primary" href="{{ route('businessplans.valider', $business_plan->id) }}">Valider</a>@endif
    </div>
    @endcan
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Plans d'affaire</h4>
                    <h4 class="card-title" id="1">I. PRÉSENTATION DU PROJET</h4>
                    <h4 class="card-title" id="1">1. Idée du projet</h4>
                    <p>{{ $business_plan->business_idea }}</p>

                    <h4 class="card-title m-t-40" id="22">2. Objectifs du projet</h4>
                    <p>{{ $business_plan->business_object }}</p>
                    <h4 class="card-title m-t-40" id="3">3. Calendrier des réalisations</h4>
                    <div class="table-responsive w-75">
                        <table class="table table-bordered">
                            <tr>
                                <th>N°</th>
                                <th>Étapes des activités</th>
                                <th>Dates indicatives</th>
                            </tr>
                            <tbody>
                            @if($business_plan->activities->count()>0 )
                            @foreach ($business_plan->activities as $key=>$planning)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $planning->step_activity }}</td>
                                    <td>{{ $planning->date_indicative }}</td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <h4 class="card-title" id="1">II. PRÉSENTATION DU PROMOTEUR ET DE L'ENTREPRISE</h4>
                    <h4 class="card-title m-t-40" id="3">1. Entreprise</h4>
                    @if($business_plan->entrepris )
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <tr><th class="w-75 fw-bold">Dénomination <td>{{ $business_plan->entreprise->denomination }}</td></th></tr>
                                <tr><th class="w-75 fw-bold">Forme juridique <td>{{ $business_plan->entreprise->forme_juridique }}</td></th></tr>
                                <tr><th class="w-75 fw-bold">Date de création prévue <td>{{ $business_plan->entreprise->date_creation_prevue }}</td></th></tr>
                                <tr><th class="w-75 fw-bold">Localisation <td>{{ $business_plan->entreprise->localisation }}</td></th></tr>
                                <tr><th class="w-75 fw-bold">Engagement en cours <td>{{ $business_plan->entreprise->engagement_institution }}</td></th></tr>
                            </tr>
                        </table>
                    </div>
                    @endif
                    <h4 class="card-title m-t-40" id="3">3. Promoteurs</h4>
                    @if($business_plan->activities->count()>0 )
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>N°</th>
                                <th>Âge</th>
                                <th>Sexe</th>
                                <th>Situation de famille</th>
                                <th>Domicile</th>
                                <th>Adresse</th>
                                <th>Niveau de formation</th>
                                <th>Expérience dans le secteur d’activités </th>
                                <th>Activité actuelle</th>
                                <th>Motivation pour la création</th>
                                <th>Garantie, aval ou caution à présenter</th>
                            </tr>
                            <tbody>
                            @foreach ($business_plan->promoteurs as $key=>$business_plan_promoteur)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $business_plan_promoteur->age }}</td>
                                    <td>{{ $business_plan_promoteur->id_sexe }}</td>
                                    <td>{{ $business_plan_promoteur->id_situation_famille }}</td>
                                    <td>{{ $business_plan_promoteur->domicile }}</td>
                                    <td>{{ $business_plan_promoteur->adresse }}</td>
                                    <td>{{ $business_plan_promoteur->niveau_formation }}</td>
                                    <td>{{ $business_plan_promoteur->experience_secteur_activite }}</td>
                                    <td>{{ $business_plan_promoteur->activite_actuelle }}</td>
                                    <td>{{ $business_plan_promoteur->motivation_creation }}</td>
                                    <td>{{ $business_plan_promoteur->garantie_aval }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <h4 class="card-title" id="1">III. DOSSIER COMMERCIAL</h4>
                    <h4 class="card-title" id="1">IV. DOSSIER TECHNIQUE</h4>
                    <h4 class="card-title" id="1">V. DOSSIER FINANCIER</h4>
                    @foreach ($groupedCharges as $parametreId => $charges)
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">{{ $charges->first()->parametre_libelle ?? 'Paramètre #' . $parametreId }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="personnelTable">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col" style="width: 30%;">Désignation</th>
                                    <th scope="col">Unité</th>
                                    <th scope="col">Quantité</th>
                                    <th scope="col">Coût unitaire</th>
                                    <th scope="col">Coût total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($charges as $key => $charge)
                                <tr>
                                    <td>{{ $key+1 }} </td>
                                    <td>{{ $charge->libelle }}</td>
                                    <td>{{ $charge->unite }}</td>
                                    <td>{{ $charge->quantite }}</td>
                                    <td>{{ $charge->cout_unitaire }}</td>
                                    <td>{{ $charge->cout_total }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
@endsection
