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
    <div class="my-3 text-right">
        @can('businessplans.valider')
        @if(!$business_plan->is_valide && $business_plan->id_admin_imput>0)<a class="btn btn-primary btn-sm" href="{{ route('businessplans.valider', $business_plan->id) }}">Valider</a>@endif
        @endcan
        <a class="btn btn-danger btn-sm" href="{{ route('businessplans.print', $business_plan->id) }}" target="_blank">Imprimer</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-black fw-bold">Plans d'affaire</h4>
                    <h4 class="card-title text-black fw-bold" id="1" style="color:#">I. PRÉSENTATION DU PROJET</h4>
                    <h4 class="card-title text-black fw-bold" id="1">1. Idée du projet</h4>
                    <p>{{ $business_plan->business_idea }}</p>

                    <h4 class="card-title text-black fw-bold m-t-40" id="22">2. Objectifs du projet</h4>
                    <p>{{ $business_plan->business_object }}</p>
                    <h4 class="card-title text-black fw-bold m-t-40" id="3">3. Calendrier des réalisations</h4>
                    <div class="table-responsive w-75">
                        <table class="table table-bordered">
                            <tr>
                                <th class="fw-bold">N°</th>
                                <th class="fw-bold">Étapes des activités</th>
                                <th class="fw-bold">Dates indicatives</th>
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
                    <div class="mt-4"></div>
                    <h4 class="card-title text-black fw-bold" id="1">II. PRÉSENTATION DU PROMOTEUR ET DE L'ENTREPRISE</h4>
                    <h4 class="card-title text-black fw-bold m-t-40" id="3">1. Entreprise</h4>
                    @if($business_plan->entreprise )
                    <div class="row">
                        <div class="col-lg-4 py-2"><span class="fw-bold">Dénomination</span></div><div class="col-lg-8 py-2">{{ $business_plan->entreprise->denomination }}</div>
                        <div class="col-lg-4 py-2"><span class="fw-bold">Forme juridique</span></div><div class="col-lg-8 py-2">{{ $business_plan->entreprise->forme_juridique }}</div>
                        <div class="col-lg-4 py-2"><span class="fw-bold">Date de création prévue</span></div><div class="col-lg-8 py-2">{{ $business_plan->entreprise->date_creation_prevue }}</div>
                        <div class="col-lg-4 py-2"><span class="fw-bold">Localisation</span></div>
                        <div class="col-lg-8 py-2">
                            {{ $business_plan->entreprise->region? $business_plan->entreprise->region->nom_structure:'...' }} |
                            {{ $business_plan->entreprise->province? $business_plan->entreprise->province->nom_structure:'...' }} |
                            {{ $business_plan->entreprise->commune? $business_plan->entreprise->commune->nom_structure:'...' }} |
                            {{ $business_plan->entreprise->arrondissement? $business_plan->entreprise->arrondissement->nom_structure:'...' }}
                        </div>
                        <div class="col-lg-4"><span class="fw-bold">Engagement en cours </span></div>
                        <div class="col-lg-8">
                            @if($business_plan->entreprise && ($business_plan->entreprise->engagements)->count()>0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="fw-bold">N°</th>
                                        <th scope="col" class="fw-bold">Banque</th>
                                        <th scope="col" class="fw-bold">Montant emprunt</th>
                                        <th scope="col" class="fw-bold">Durée</th>
                                        <th scope="col" class="fw-bold">Mois / Année</th>
                                        <th scope="col" class="fw-bold">Montant Restant</th>
                                    </tr>
                                    <tbody>
                                    @foreach ($business_plan->entreprise->engagements as $key => $business_plan_engagement)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $business_plan_engagement->nom_banque }}</td>
                                            <td>{{ $business_plan_engagement->montant_emprunt }}</td>
                                            <td>{{ $business_plan_engagement->id_situation_famille }}</td>
                                            <td>{{ ($business_plan_engagement->duree && $business_plan_engagement->type_duree == 'mois')?'Mois':'Année'  }}</td>
                                            <td>{{ $business_plan_engagement->montant_restant }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <span class="alert-warning">Aucun engagement enregistré!</span>
                            @endif
                        </div>
                    </div>

                    @endif
                    <h4 class="card-title text-black fw-bold m-t-40" id="3">3. Promoteurs</h4>
                    @if($business_plan->activities->count()>0 )
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="fw-bold">N°</th>
                                <th class="fw-bold">Âge</th>
                                <th class="fw-bold">Sexe</th>
                                <th class="fw-bold">Situation de famille</th>
                                <th class="fw-bold">Domicile</th>
                                <th class="fw-bold">Adresse</th>
                                <th class="fw-bold">Niveau de formation</th>
                                <th class="fw-bold">Expérience dans le secteur d’activités </th>
                                <th class="fw-bold">Activité actuelle</th>
                                <th class="fw-bold">Motivation pour la création</th>
                                <th class="fw-bold">Garantie, aval ou caution à présenter</th>
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
                    <h4 class="card-title text-black fw-bold" id="1">III. DOSSIER COMMERCIAL</h4>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title text-black fw-bold">Produits/Services</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-lg-4 py-2"><span class="fw-bold">Description détaillée</span></div><div class="col-lg-8 py-2">{{ $business_plan->produit_service }}</div>
                            </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title text-black fw-bold">Analyse du marché</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-lg-4 py-2"><span class="fw-bold">Situation du secteur d’activité</span></div><div class="col-lg-8 py-2">{{ $business_plan->situation_secteur_activite }}</div>
                                <div class="col-lg-4 py-2"><span class="fw-bold">Évaluation du marché potentiel</span></div><div class="col-lg-8 py-2">{{ $business_plan->evaluation_marche_potentiel }}</div>
                                <div class="col-lg-4 py-2"><span class="fw-bold">Profil du marché cible</span></div><div class="col-lg-8 py-2">{{ $business_plan->profil_marche_cible }}</div>
                                <div class="col-lg-4 py-2"><span class="fw-bold">Marché visé</span></div><div class="col-lg-8 py-2">{{ $business_plan->marche_vise }}</div>
                            </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title text-black fw-bold">Situation concurrentielle</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-lg-4 py-2"><span class="fw-bold">Concurrents directs et indirects</span></div><div class="col-lg-8 py-2">{{ $business_plan->situation_concurrentielle }}</div>
                            </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title text-black fw-bold">Analyse concurrentielle de l’entreprise</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-lg-4 py-2"><span class="fw-bold">Avantages concurrentiels</span></div><div class="col-lg-8 py-2">{{ $business_plan->analyse_concurrentielle }}</div>
                            </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title text-black fw-bold">Stratégie marketing</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-lg-4 py-2"><span class="fw-bold">Politique de produit</span></div><div class="col-lg-8 py-2">{{ $business_plan->politique_produit }}</div>
                                <div class="col-lg-4 py-2"><span class="fw-bold">Politique de prix</span></div><div class="col-lg-8 py-2">{{ $business_plan->politique_prix }}</div>
                                <div class="col-lg-4 py-2"><span class="fw-bold">Politique de promotion</span></div><div class="col-lg-8 py-2">{{ $business_plan->politique_promotion }}</div>
                                <div class="col-lg-4 py-2"><span class="fw-bold">Politique de distribution</span></div><div class="col-lg-8 py-2">{{ $business_plan->politique_distribution }}</div>
                            </div>
                            </div>
                        </div>
                    <h4 class="card-title text-black fw-bold" id="1">IV. DOSSIER TECHNIQUE</h4>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title text-black fw-bold">Informations sur l'activité</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-lg-4 py-2"><span class="fw-bold">Description des infrastructures et des aménagements existants et à réaliser</span></div><div class="col-lg-8 py-2">{{ $business_plan->description_infrastructure }}</div>
                                <div class="col-lg-4 py-2"><span class="fw-bold">Description des équipements existants et à acquérir</span></div><div class="col-lg-8 py-2">{{ $business_plan->description_equipement }}</div>
                                <div class="col-lg-4 py-2"><span class="fw-bold">Description du processus d’approvisionnement</span></div><div class="col-lg-8 py-2">{{ $business_plan->description_process }}</div>
                                <div class="col-lg-4 py-2"><span class="fw-bold">Présentation du processus de production</span></div><div class="col-lg-8 py-2">{{ $business_plan->processus_production }}</div>
                                <div class="col-lg-4 py-2"><span class="fw-bold">Réglementation</span></div><div class="col-lg-8 py-2">{{ $business_plan->reglementation }}</div>
                            </div>
                            </div>
                        </div>
                        <?php
                            $employee_exists = null;
                            $employee_recs = null;
                            if($business_plan->employes && $business_plan->employes->count()>0){
                                // EXIST
                                $employee_exists = $business_plan->employes->filter(function ($employee_ex) {
                                    return ($employee_ex->type_employee == 'existent') !== false;
                                });

                                // AQ
                                $employee_recs = $business_plan->employes->filter(function ($employee_rec) {
                                    return ($employee_rec->type_employee == 'recruter') !== false;
                                });
                            }
                        ?>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title text-black fw-bold">Personnel : Organisation, effectif, qualification et tâches prévues</h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-black fw-bold m-t-40" id="3">a. Personnel existant</h4>
                                @if($employee_exists && ($employee_exists)->count()>0)
                                <table class="table table-bordered" id="personnelTable">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold">N°</th>
                                            <th scope="col" class="fw-bold">Poste</th>
                                            <th scope="col" class="fw-bold">Qualification</th>
                                            <th scope="col" class="fw-bold">Effectif</th>
                                            <th scope="col" class="fw-bold">Salaires mensuels</th>
                                            <th scope="col" class="fw-bold">Tâches prévues</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($employee_exists as $key => $business_plan_employe)
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $business_plan_employe->poste }}</td>
                                        <td>{{ $business_plan_employe->qualification }}</td>
                                        <td>{{ $business_plan_employe->effectif }}</td>
                                        <td>{{ $business_plan_employe->salaire_mensuel }}</td>
                                        <td>{{ $business_plan_employe->tache_prevu }}</td>
                                        @endforeach

                                    </tbody>
                                </table>
                                @else
                                <span class="alert alert-warning">Aucun employé existent!</span>
                                @endif

                                <h4 class="card-title text-black fw-bold m-t-40" id="3">b. Personnel à recruter</h4>
                                @if($employee_recs && ($employee_recs)->count()>0)
                                <table class="table table-bordered" id="personnelTable">
                                    <thead>
                                        <tr>
                                            <th class="fw-bold">N°</th>
                                            <th scope="col" class="fw-bold">Poste</th>
                                            <th scope="col" class="fw-bold">Qualification</th>
                                            <th scope="col" class="fw-bold">Effectif</th>
                                            <th scope="col" class="fw-bold">Salaires mensuels</th>
                                            <th scope="col" class="fw-bold">Tâches prévues</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employee_recs as $key => $employee_rec)
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $employee_rec->poste }}</td>
                                        <td>{{ $employee_rec->qualification }}</td>
                                        <td>{{ $employee_rec->effectif }}</td>
                                        <td>{{ $employee_rec->salaire_mensuel }}</td>
                                        <td>{{ $employee_rec->tache_prevu }}</td>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <span class="alert alert-warning">Aucun employé à recruter!</span>
                                @endif
                            </div>
                        </div>
                    <h4 class="card-title text-black fw-bold" id="1">V. DOSSIER FINANCIER</h4>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title text-black fw-bold">Estimation </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="personnelTable">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="fw-bold">Quel est le montant de l’emprunt que vous envisagez ?</th>
                                            <th scope="col" class="fw-bold">En combien d’année souhaitez-vous rembourser votre emprunt ?</th>
                                            <th scope="col" class="fw-bold">Avantages concurrentiels</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td>{{ $business_plan->montant_emprunt }}</td>
                                        <td>{{ $business_plan->nombre_year_remb }}</td>
                                        <td>{{ $business_plan->estimation_chiffre_affaire }}</td>
                                    </tbody>
                                </table>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title text-black fw-bold">Avez-vous déjà ciblé un ou des partenaires (financiers, techniques, commerciaux) ? si oui, lesquels  </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 py-2"><span class="fw-bold">Avez-vous déjà ciblé un ou des partenaires ?</span></div><div class="col-lg-8 py-2">{{ $business_plan->cible_partenaire }}</div>
                                <div class="col-lg-4"><span class="fw-bold">Financiers, techniques, commerciaux </span></div>
                                <div class="col-lg-8">
                                     @if($business_plan->partenaire && ($business_plan->partenaire)->count()>0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="fw-bold">N°</th>
                                                <th scope="col" class="fw-bold">Nom du partenaire</th>
                                                <th scope="col" class="fw-bold">Montant emprunt</th>
                                                <th scope="col" class="fw-bold">Nombre d'année remb.</th>
                                            </tr>
                                            <tbody>
                                            @foreach($business_plan->partenaire as $key => $business_plan_part)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $business_plan_part->nom_partenaire }}</td>
                                                    <td>{{ $business_plan_part->montant_emprunt }}</td>
                                                    <td>{{ $business_plan_part->nombre_year_remb }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <span class="alert-warning">Aucun partenaire enregistré!</span>
                                    @endif
                        </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title text-black fw-bold">Chiffre d’affaires de la première année </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="estimationFirstTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Produits  </th>
                                        <th scope="col">Unité</th>
                                        <th scope="col">Quantité </th>
                                        <th scope="col">Prix unitaire</th>
                                        <th scope="col">Chiffre d'affaires</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(($business_plan->chiffre_affaire_first_years)->count()>0)
                                        @foreach($business_plan->chiffre_affaire_first_years as $key => $business_plan_chiffre_affaire_first_year)
                                        <tr>
                                            <td>{{ $business_plan_chiffre_affaire_first_year->produit }}</td>
                                            <td>{{ $business_plan_chiffre_affaire_first_year->unite_first }}</td>
                                            <td>{{ $business_plan_chiffre_affaire_first_year->quantite }}</td>
                                            <td>{{ $business_plan_chiffre_affaire_first_year->prix_unitaire }}</td>
                                            <td>{{ $business_plan_chiffre_affaire_first_year->chiffre_affaire_first }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title text-black fw-bold">Estimation du chiffre d’affaires (Sur les cinq premières années d’activités, les chiffres d’affaires sont progressives avec une évolution annuelle de 25%) </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="estimationTable">
                            <thead>
                                <tr>
                                    <th scope="col">Produits</th>
                                    <th scope="col">AN 1</th>
                                    <th scope="col">AN 2</th>
                                    <th scope="col">AN 3</th>
                                    <th scope="col">AN 4</th>
                                    <th scope="col">AN 5</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(($business_plan->chiffre_affaires)->count()>0)
                                    @foreach($business_plan->chiffre_affaires as $key => $business_plan_chiffre_affaire)
                                    <tr>
                                        <td>{{ $business_plan_chiffre_affaire->produit}}</td>
                                        <td>{{ $business_plan_chiffre_affaire->an_1 }}</td>
                                        <td>{{ $business_plan_chiffre_affaire->an_2 }}</td>
                                        <td>{{ $business_plan_chiffre_affaire->an_3 }}</td>
                                        <td>{{ $business_plan_chiffre_affaire->an_4 }}</td>
                                        <td>{{ $business_plan_chiffre_affaire->an_5 }}</td>
                                    </tr>
                                    @endforeach
                                @elseif(($business_plan->chiffre_affaire_first_years)->count()>0)
                                    @foreach($business_plan->chiffre_affaire_first_years as $key => $business_plan_chiffre_affaire_first_year)
                                    <tr>
                                        <td>{{ $business_plan_chiffre_affaire_first_year->produit}}</td>
                                        <td>{{ $business_plan_chiffre_affaire_first_year->chiffre_affaire_first }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                        $equipement_exists = null;
                        $equipement_aqs = null;
                        if($business_plan->equipement && $business_plan->equipement->count()>0){
                            // EXIST
                            $equipement_exists = $business_plan->equipement->filter(function ($equipement_ex) {
                                return ($equipement_ex->type_equipement == 'existent') !== false;
                            });

                            // AQ
                            $equipement_aqs = $business_plan->equipement->filter(function ($equipement_a) {
                                return ($equipement_a->type_equipement == 'acquerir') !== false;
                            });
                        }
                    ?>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title text-black fw-bold">Equipements de production</h5>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title text-black fw-bold m-t-40" id="3">a. Description de l’équipement de production existant</h4>
                            @if($equipement_exists && $equipement_exists->count()>0)

                            <table class="table table-bordered" id="personnelTable">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 30%;">N°</th>
                                        <th scope="col">Désignation</th>
                                        <th scope="col">Unité</th>
                                        <th scope="col">Quantité</th>
                                        <th scope="col">Etat de fonctionnement </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($equipement_exists as $key=>$equipement_exist)
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $equipement_exist->description }}</td>
                                        <td>{{ $equipement_exist->unite }}</td>
                                        <td>{{ $equipement_exist->quantite }}</td>
                                        <td>{{ $equipement_exist->etat_fonctionnement }}</td>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <span class="alert alert-warning">Aucun équipement existent!</span>
                            @endif

                            <h4 class="card-title text-black fw-bold m-t-40" id="3">b. Description de l’équipement de production à acquérir</h4>
                            @if($equipement_aqs && $equipement_aqs->count()>0)
                            <table class="table table-bordered" id="personnelTable">
                                <thead>
                                <tr>
                                    <th scope="col" style="width: 30%;">N°</th>
                                    <th scope="col">Désignation</th>
                                    <th scope="col">Unité</th>
                                    <th scope="col">Quantité</th>
                                    <th scope="col">Sources d’approvisionnement </th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($equipement_aqs as $key=>$equipement_aq)
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $equipement_aq->description }}</td>
                                    <td>{{ $equipement_aq->unite }}</td>
                                    <td>{{ $equipement_aq->quantite }}</td>
                                    <td>{{ $equipement_aq->etat_fonctionnement }}</td>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <span class="alert alert-warning">Aucun équipement à recruter!</span>
                            @endif
                        </div>
                    </div>

                    @foreach ($groupedCharges as $id_valeur => $charges)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title">{{ $charges->first()->valeur_libelle }}</h5>
                            <small>{{ $charges->first()->description }}</small>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="charge[]" value="{{ $charges->first()->id_valeur }}">
                            <table class="table table-bordered" id="chargeTable{{ $charges->first()->id_valeur }}">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 30%;">Désignation</th>
                                        <th scope="col">Unité</th>
                                        <th scope="col">Quantité</th>
                                        <th scope="col">Coût unitaire</th>
                                        <th scope="col">Coût total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($charges->first()->id)
                                    @foreach ($charges as $charge_exploitation)
                                    <tr>
                                        <td>{{ $charge_exploitation->designation }}</td>
                                        <td>{{ $charge_exploitation->unite }}</td>
                                        <td>{{ $charge_exploitation->quantite }}</td>
                                        <td>{{ $charge_exploitation->cout_unitaire }}</td>
                                        <td>{{ number_format(floatval($charge_exploitation->cout_total), 0, ',', ' ') }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
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
