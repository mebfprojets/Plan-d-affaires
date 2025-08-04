@extends('frontend.layouts.layout')
@section('content')
<!-- Page Title -->
<div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">SOUSCRIPTION AU PACK START </h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Accueil</a></li>
          <li class="current">Les packs de plan d'affaire</li>
        </ol>
      </nav>
    </div>
</div><!-- End Page Title -->
  <!-- Features Section -->
  <section id="features" class="section" style="padding: 30px 0 0 0;">
    <div class="container" data-aos="fade-up" data-aos-delay="100" style="padding-bottom: 30px;">
        <form action="{{ route('businessplans.update', $business_plan->id) }}" method="POST">
            {{ csrf_field() }}
        <!-- Onglets (tabs) -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="presentation-tab" data-bs-toggle="tab" data-bs-target="#presentation" type="button" role="tab" aria-controls="presentation" aria-selected="true">I.	Présentation du projet</button>
            </li>
            <li class="nav-item" role="promoteur">
                <button class="nav-link active" id="promoteur-tab" data-bs-toggle="tab" data-bs-target="#promoteur" type="button" role="tab" aria-controls="promoteur" aria-selected="false">II.	Présentation du promoteur et de l’entreprise</button>
            </li>
            <li class="nav-item" role="commercial">
                <button class="nav-link" id="commercial-tab" data-bs-toggle="tab" data-bs-target="#commercial" type="button" role="tab" aria-controls="commercial" aria-selected="false">III.	Dossier commercial</button>
            </li>
            <li class="nav-item" role="technique">
                <button class="nav-link" id="technique-tab" data-bs-toggle="tab" data-bs-target="#technique" type="button" role="tab" aria-controls="technique" aria-selected="false">IV.	Dossier technique</button>
            </li>
            <li class="nav-item" role="finance">
                <button class="nav-link" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance" type="button" role="tab" aria-controls="finance" aria-selected="false">V.	Dossier financier</button>
            </li>
            <li class="nav-item" role="finance">
                <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab" aria-controls="payment" aria-selected="false">VI.	Payer</button>
            </li>
        </ul>

        <!-- Contenu des onglets -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade p-3" id="presentation" role="tabpanel" aria-labelledby="presentation-tab">
                <h5>Présentation du projet</h5>
                    <input type="hidden" name="id_pack" value="{{ $business_plan->id }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="business_idea" class="fw-bold">Idée de projet <span class="text-danger">*</span></label>
                                <p>Dire comment est venue l’idée de projet et en quoi consiste le projet ?</p>
                                <textarea name="business_idea" id="business_idea" rows="6" class="form-control">{{ $business_plan->business_idea }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mt-5">
                                <label for="business_object" class="fw-bold">Objectifs du projet </label>
                                <p>Formuler des objectifs mesurables et réalisables pour votre future entreprise, quelles sont les cibles à atteindre, les résultats à obtenir ?</p>
                                <textarea name="business_object" id="business_object" rows="6" class="form-control">{{ $business_plan->business_object }}</textarea>
                            </div>
                        </div>
                    </div>
                    <label for="jobTitle2" class="fw-bold">Calendrier des réalisations</label>
                    <p><i>Décrivez ce qui a déjà été réalisé, ce qui est en cours et ce qui est à venir (Exemple : élaboration du plan d’affaires, mobilisation du financement, construction et aménagement, achat des équipements, négociation avec les fournisseurs, élaboration du plan de communication, recrutement du personnel, démarrage de la production, ouverture officielle).</i></p>
                    <div class="table-responsive">
                        <div class="btn-actions text-right">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="addStepRow()">
                                <i class="bi bi-plus"></i> Ajouter une activité
                            </button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Étapes des activités</th>
                                    <th scope="col">Dates indicatives</th>
                                </tr>
                            </thead>
                            <tbody id="activities-table">
                                @if($business_plan->activities && $business_plan->activities->count()>0)
                                @foreach($business_plan->activities as $key=>$act)
                                <tr>
                                    <th scope="row">{{ $key+1 }}</th>
                                    <td><input type="text" name="etapes_activites[]" class="form-control" placeholder="Etape de l'activité" value="{{ $act->step_activity }}"></td>
                                    <td><input type="date" name="dates_indicatives[]" class="form-control" placeholder="jj/mm/aaaa" value="{{ $act->date_indicative }}"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <th scope="row">1</th>
                                    <td><input type="text" name="etapes_activites[]" class="form-control" placeholder="Etape de l'activité"></td>
                                    <td><input type="date" name="dates_indicatives[]" class="form-control" placeholder="jj/mm/aaaa"></td>
                                    <td></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="tab-pane show active fade p-3" id="promoteur" role="tabpanel" aria-labelledby="promoteur-tab">
                <h5>Présentation du promoteur et de l’entreprise</h5>
                <div class="container mt-4">
                    <!-- Première carte : Informations personnelles -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary">
                            <h5 class="text-white">Informations Promoteurs</h5>
                        </div>
                        <div class="card-body">
                            <div class="btn-actions text-right mb-2">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="addPromoteurRow()">
                                    <i class="bi bi-plus"></i> Ajouter un promoteur
                                </button>
                            </div>
                            @if($business_plan->promoteurs && $business_plan->promoteurs->count()>0)
                            @foreach($business_plan->promoteurs as $business_plan_promoteur)


                            <div class="promo mt-3">
                                <div class="row mb-3">
                                    <label for="age" class="col-lg-3 col-form-label">Âge</label>
                                    <div class="col-lg-8">
                                        <input type="number" min="0" class="form-control" id="age" name="age[]" placeholder="Entrez votre âge" value="{{ $business_plan_promoteur->age }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="sexe" class="col-lg-3 col-form-label">Sexe</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="sexe" name="sexe[]">
                                            <option value="">Selectionner le sexe...</option>
                                            @foreach($sexes as $sexe)
                                            <option value="{{ $sexe->id }}" @if($sexe->id == $business_plan_promoteur->id_sexe) selected @endif>{{ $sexe->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="situation" class="col-lg-3 col-form-label">Situation de famille</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="situation_famille" name="situation_famille[]">
                                            <option value="">Selectionner la situation ...</option>
                                            @foreach($situation_familles as $situation_famille)
                                            <option value="{{ $situation_famille->id }}" @if($situation_famille->id == $business_plan_promoteur->id_situation_famille) selected @endif>{{ $situation_famille->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="domicile" class="col-lg-3 col-form-label">Domicile</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="domicile" name="domicile[]" placeholder="Lieu de domicile" value="{{ $business_plan_promoteur->domicile }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="adresse" class="col-lg-3 col-form-label">Adresse</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="adresse" name="adresse[]" placeholder="Adresse complète" value="{{ $business_plan_promoteur->adresse }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="niveau_formation" class="col-lg-3 col-form-label">Niveau de formation</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="niveau_formation" name="niveau_formation[]" placeholder="Niveau formation" value="{{ $business_plan_promoteur->niveau_formation }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="experience_secteur_activite" class="col-lg-3 col-form-label">Expérience dans le secteur d’activités </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="experience_secteur_activite" name="experience_secteur_activite[]" placeholder="Expérience secteur activité" value="{{ $business_plan_promoteur->experience_secteur_activite }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="activite_actuelle" class="col-lg-3 col-form-label">Activité actuelle</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="activite_actuelle" name="activite_actuelle[]" placeholder="Activité actuelle" value="{{ $business_plan_promoteur->activite_actuelle }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="motivation_creation" class="col-lg-3 col-form-label">Motivation pour la création</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="motivation_creation" name="motivation_creation[]" placeholder="Motivation pour la création" value="{{ $business_plan_promoteur->motivation_creation }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="garantie_aval" class="col-lg-3 col-form-label">Garantie, aval ou caution à présenter</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="garantie_aval" name="garantie_aval[]" placeholder="Garantie, aval ou caution à présenter" value="{{ $business_plan_promoteur->garantie_aval }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="promo mt-3">
                                <div class="row mb-3">
                                    <label for="age" class="col-lg-3 col-form-label">Âge</label>
                                    <div class="col-lg-8">
                                        <input type="number" min="0" class="form-control" id="age" name="age[]" placeholder="Entrez votre âge">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="sexe" class="col-lg-3 col-form-label">Sexe</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="sexe" name="sexe[]">
                                            <option value="">Selectionner le sexe...</option>
                                            @foreach($sexes as $sexe)
                                            <option value="{{ $sexe->id }}">{{ $sexe->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="situation" class="col-lg-3 col-form-label">Situation de famille</label>
                                    <div class="col-lg-8">
                                        <select class="form-select" id="situation_famille" name="situation_famille[]">
                                            <option value="">Selectionner la situation ...</option>
                                            @foreach($situation_familles as $situation_famille)
                                            <option value="{{ $situation_famille->id }}">{{ $situation_famille->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="domicile" class="col-lg-3 col-form-label">Domicile</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="domicile" name="domicile[]" placeholder="Lieu de domicile">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="adresse" class="col-lg-3 col-form-label">Adresse</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="adresse" name="adresse[]" placeholder="Adresse complète">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="niveau_formation" class="col-lg-3 col-form-label">Niveau de formation</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="niveau_formation" name="niveau_formation[]" placeholder="Niveau formation">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="experience_secteur_activite" class="col-lg-3 col-form-label">Expérience dans le secteur d’activités </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="experience_secteur_activite" name="experience_secteur_activite[]" placeholder="Expérience secteur activité">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="activite_actuelle" class="col-lg-3 col-form-label">Activité actuelle</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="activite_actuelle" name="activite_actuelle[]" placeholder="Activité actuelle">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="motivation_creation" class="col-lg-3 col-form-label">Motivation pour la création</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="motivation_creation" name="motivation_creation[]" placeholder="Motivation pour la création">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="garantie_aval" class="col-lg-3 col-form-label">Garantie, aval ou caution à présenter</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="garantie_aval" name="garantie_aval[]" placeholder="Garantie, aval ou caution à présenter">
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div id="promoteurs">

                            </div>
                        </div>
                    </div>

                    <!-- Deuxième carte : Informations sur l'entreprise -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary">
                            <h5 class="text-white">Informations sur l'Entreprise</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="denomination" class="col-lg-3 col-form-label">Dénomination</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="denomination" name="denomination" placeholder="Nom de l'entreprise" value="{{ $business_plan->entreprise?$business_plan->entreprise->denomination:'' }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="forme_juridique" class="col-lg-3 col-form-label">Forme juridique</label>
                                <div class="col-lg-9">
                                    <select class="form-select" id="forme_juridique" name="forme_juridique">
                                        <option value="">Selectionner la forme juridique...</option>
                                        @foreach($forme_juridiques as $forme_juridique)
                                        <option value="{{ $forme_juridique->id }}" @if($business_plan->entreprise && $forme_juridique->id == $business_plan->entreprise->id_forme_juridique) selected @endif>{{ $forme_juridique->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="date_creation" class="col-lg-3 col-form-label">Date de création prévue</label>
                                <div class="col-lg-9">
                                    <input type="date" class="form-control" id="date_creation" name="date_creation" max="{{ date('Y-m-d') }}" value="{{ $business_plan->entreprise?$business_plan->entreprise->date_creation_prevue:'' }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="localisation" class="col-lg-3 col-form-label">Localisation</label>
                                <div class="col-lg-9">
                                    <div class="row">
                                        <!-- REGION -->
                                        <div class="col-lg-3">
                                            <select class="form-select" id="id_region" name="id_region" onchange="changeValue('id_region', 'id_province', 'province');">
                                                <option value="">Selectionner la région ...</option>
                                                @foreach($regions as $region)
                                                <option value="{{ $region->id }}" @if($business_plan->entreprise && $region->id == $business_plan->entreprise->id_region) selected @endif>{{ $region->nom_structure }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- PROVINCE -->
                                        <div class="col-lg-3">
                                            <select class="form-select" id="id_province" name="id_province" onchange="changeValue('id_province', 'id_commune', 'commune');">
                                                <option value="">Selectionner la province ...</option>
                                                @if($provinces)
                                                    @foreach($provinces as $province)
                                                    <option value="{{ $province->id }}" @if($business_plan->entreprise && $province->id == $business_plan->entreprise->id_province) selected @endif>{{ $province->nom_structure }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <!-- COMMUNE -->
                                        <div class="col-lg-3">
                                            <select class="form-select" id="id_commune" name="id_commune" onchange="changeValue('id_commune', 'id_arrondissement', 'arrondissement');">
                                                <option value="">Selectionner la commune ...</option>
                                                @if($communes)
                                                    @foreach($communes as $commune)
                                                    <option value="{{ $commune->id }}" @if($business_plan->entreprise && $commune->id == $business_plan->entreprise->id_commune) selected @endif>{{ $commune->nom_structure }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <!-- ARRDONDISSEMENT -->
                                        <div class="col-lg-3">
                                            <select class="form-select" id="id_arrondissement" name="id_arrondissement">
                                                <option value="">Selectionner l'arrdondissement ...</option>
                                                @if($arrondissements)
                                                    @foreach($arrondissements as $arrondissement)
                                                    <option value="{{ $arrondissement->id }}" @if($business_plan->entreprise && $arrondissement->id == $business_plan->entreprise->id_arrondissement) selected @endif>{{ $arrondissement->nom_structure }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="engagement" class="col-lg-3 col-form-label">Engagement en cours</label>
                                <div class="col-lg-9">
                                    <table class="table table-bordered" id="banqueTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Banque</th>
                                                <th scope="col">Montant emprunt</th>
                                                <th scope="col">Durée</th>
                                                <th scope="col">Mois / Année</th>
                                                <th scope="col">Montant Restant</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="banque_area">
                                            @if($business_plan->entreprise && ($business_plan->entreprise->engagements)->count()>0)
                                                @foreach($business_plan->entreprise->engagements as $key => $business_plan_engagement)
                                                <tr>
                                                    <td><input type="text" class="form-control" name="nom_banque[]" placeholder="Nom de la banque" value="{{ $business_plan_engagement->nom_banque}}"></td>
                                                    <td><input type="number" min="0" class="form-control" name="montant_emp[]" placeholder="100000" value="{{ $business_plan_engagement->montant_emprunt}}"></td>
                                                    <td><input type="number" min="0" class="form-control" name="duree[]" placeholder="01" value="{{ $business_plan_engagement->duree}}"></td>
                                                     <td>
                                                        <select class="form-select" id="type_duree" name="type_duree[]">
                                                            <option value="">Selectionner...</option>
                                                            <option value="mois" @if($business_plan_engagement->type_duree == 'mois') selected @endif>Mois</option>
                                                            <option value="annee" @if($business_plan_engagement->type_duree == 'annee') selected @endif>Année</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="number" min="0" class="form-control" name="montant_restant[]" placeholder="100000" value="{{ $business_plan_engagement->montant_restant}}"></td>

                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td><input type="text" class="form-control" name="nom_banque[]" placeholder="Nom de la banque"></td>
                                                    <td><input type="number" min="0" class="form-control" name="montant_emp[]" placeholder="100000"></td>
                                                    <td><input type="number" min="0" class="form-control" name="duree[]" placeholder="01"></td>
                                                    <td>
                                                        <select class="form-select" id="type_duree" name="type_duree[]">
                                                            <option value="">Selectionner...</option>
                                                            <option value="mois">Mois</option>
                                                            <option value="annee">Année</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="number" min="0" class="form-control" name="montant_restant[]" placeholder="100000"></td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" id="addRow" onclick="addBanqueRow()">Ajouter une ligne</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="commercial" role="tabpanel" aria-labelledby="commercial-tab">
                <h5>Dossier commercial</h5>
                <!-- Produits/Services -->
                <div class="card my-4">
                    <div class="card-header bg-secondary text-white">
                        Produits/Services
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="produits_services" class="col-lg-3 col-form-label">Description détaillée</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="produits_services" name="produits_services" rows="3" placeholder="Qualité, poids, durabilité, etc.">{{ $business_plan->produit_service }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analyse du marché -->
                <div class="card my-4">
                    <div class="card-header bg-secondary text-white">
                        Analyse du marché
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="situation_secteur" class="col-lg-3 col-form-label">Situation du secteur d’activité</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="situation_secteur" name="situation_secteur" rows="2">{{ $business_plan->situation_secteur_activite }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="evaluation_marche" class="col-lg-3 col-form-label">Évaluation du marché potentiel</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="evaluation_marche" name="evaluation_marche" rows="2">{{ $business_plan->evaluation_marche_potentiel }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="profil_marche" class="col-lg-3 col-form-label">Profil du marché cible</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="profil_marche" name="profil_marche" rows="2">{{ $business_plan->profil_marche_cible }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="marche_vise" class="col-lg-3 col-form-label">Marché visé</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="marche_vise" name="marche_vise" rows="2">{{ $business_plan->marche_vise }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Situation concurrentielle -->
                <div class="card my-4">
                    <div class="card-header bg-secondary text-white">
                        Situation concurrentielle
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="situation_concurrentielle" class="col-lg-3 col-form-label">Concurrents directs et indirects</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="situation_concurrentielle" name="situation_concurrentielle" rows="2">{{ $business_plan->situation_concurrentielle }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analyse concurrentielle de l’entreprise -->
                <div class="card my-4">
                    <div class="card-header bg-secondary text-white">
                        Analyse concurrentielle de l’entreprise
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="analyse_concurrentielle" class="col-lg-3 col-form-label">Avantages concurrentiels</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="analyse_concurrentielle" name="analyse_concurrentielle" rows="2">{{ $business_plan->analyse_concurrentielle }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stratégie marketing -->
                <div class="card my-4">
                    <div class="card-header bg-secondary text-white">
                        Stratégie marketing
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="politique_produit" class="col-lg-3 col-form-label">Politique de produit</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="politique_produit" name="politique_produit" rows="2">{{ $business_plan->politique_produit }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="politique_prix" class="col-lg-3 col-form-label">Politique de prix</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="politique_prix" name="politique_prix" rows="2">{{ $business_plan->politique_prix }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="politique_promotion" class="col-lg-3 col-form-label">Politique de promotion</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="politique_promotion" name="politique_promotion" rows="2">{{ $business_plan->politique_promotion }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="politique_distribution" class="col-lg-3 col-form-label">Politique de distribution</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="politique_distribution" name="politique_distribution" rows="2">{{ $business_plan->politique_distribution }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="technique" role="tabpanel" aria-labelledby="technique-tab">
                <h5>Dossier technique</h5>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Informations sur l'activité</h5>
                    </div>
                    <div class="card-body">
                        <!-- Description des infrastructures et des aménagements existants et à réaliser -->
                        <div class="mb-3 d-flex">
                            <label for="infrastructures" class="form-label me-3" style="width: 350px;">Description des infrastructures et des aménagements existants et à réaliser</label>
                            <textarea id="infrastructures" name="infrastructures" class="form-control" rows="3" placeholder="Précisez les infrastructures ...">{{ $business_plan->description_infrastructure }}</textarea>
                        </div>

                        <!-- Description des équipements existants et à acquérir -->
                        <div class="mb-3 d-flex">
                            <label for="equipements" class="form-label me-3" style="width: 350px;">Description des équipements existants et à acquérir</label>
                            <textarea id="equipements" name="equipements" class="form-control" rows="3" placeholder="Précisez les équipements...">{{ $business_plan->description_equipement }}</textarea>
                        </div>

                        <!-- Description du processus d’approvisionnement -->
                        <div class="mb-3 d-flex">
                            <label for="approvisionnement" class="form-label me-3" style="width: 350px;">Description du processus d’approvisionnement</label>
                            <textarea id="approvisionnement" name="approvisionnement" class="form-control" rows="3" placeholder="Indiquez vos fournisseurs...">{{ $business_plan->description_process }}</textarea>
                        </div>

                        <!-- Présentation du processus de production ou de livraison de service -->
                        <div class="mb-3 d-flex">
                            <label for="production" class="form-label me-3" style="width: 350px;">Présentation du processus de production</label>
                            <textarea id="production" name="production" class="form-control" rows="3" placeholder="Décrivez les étapes de production...">{{ $business_plan->processus_production }}</textarea>
                        </div>

                        <!-- Réglementation -->
                        <div class="mb-3 d-flex">
                            <label for="reglementation" class="form-label me-3" style="width: 350px;">Réglementation</label>
                            <textarea id="reglementation" name="reglementation" class="form-control" rows="3" placeholder="Indiquez la réglementation...">{{ $business_plan->reglementation }}</textarea>
                        </div>
                    </div>
                </div>
                <!-- Personnel -->
                <div class="card mt-3">
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
                    <div class="card-header">
                        <h5 class="card-title">Personnel : Organisation, effectif, qualification et tâches prévues</h5>
                    </div>
                    <div class="card-body">
                        <strong>Personnel existant</strong>
                        <table class="table table-bordered" id="personnelTable">
                            <thead>
                                <tr>
                                    <th scope="col">Poste</th>
                                    <th scope="col">Qualification</th>
                                    <th scope="col">Effectif</th>
                                    <th scope="col">Salaires mensuels</th>
                                    <th scope="col">Tâches prévues</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($employee_exists && ($employee_exists)->count()>0)
                                    @foreach($employee_exists as $key => $business_plan_employe)
                                    <tr>
                                        <td><input type="text" class="form-control" name="poste[]" placeholder="Poste" value="{{ $business_plan_employe->poste}}"></td>
                                        <td><input type="text" class="form-control" name="qualification[]" placeholder="Qualification" value="{{ $business_plan_employe->qualification}}"></td>
                                        <td><input type="number" min="0" class="form-control" name="effectif[]" placeholder="Effectif" value="{{ $business_plan_employe->effectif}}"></td>
                                        <td><input type="number" min="0" class="form-control" name="salaire[]" placeholder="Salaires mensuels" value="{{ $business_plan_employe->salaire_mensuel}}"></td>
                                        <td><textarea class="form-control" name="taches[]" placeholder="Tâches prévues" value="{{ $business_plan_employe->tache_prevu}}"></textarea></td>
                                        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td><input type="text" class="form-control" name="poste[]" placeholder="Poste"></td>
                                        <td><input type="text" class="form-control" name="qualification[]" placeholder="Qualification"></td>
                                        <td><input type="number" min="0" class="form-control" name="effectif[]" placeholder="Effectif"></td>
                                        <td><input type="number" min="0" class="form-control" name="salaire[]" placeholder="Salaires mensuels"></td>
                                        <td><textarea class="form-control" name="taches[]" placeholder="Tâches prévues"></textarea></td>
                                        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                    @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" id="addRow" onclick="addEmployeRow()">Ajouter une ligne</button>
                        </div>
                        <strong>Personnel à recruter</strong>
                        <table class="table table-bordered" id="personnelRecruterTable">
                            <thead>
                                <tr>
                                    <th scope="col">Poste</th>
                                    <th scope="col">Qualification</th>
                                    <th scope="col">Effectif</th>
                                    <th scope="col">Salaires mensuels</th>
                                    <th scope="col">Tâches prévues</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($employee_recs && ($employee_recs)->count()>0)
                                    @foreach($employee_recs as $key => $employee_rec)
                                    <tr>
                                        <td><input type="text" class="form-control" name="poste_rec[]" placeholder="Poste" value="{{ $employee_rec->poste}}"></td>
                                        <td><input type="text" class="form-control" name="qualification_rec[]" placeholder="Qualification" value="{{ $employee_rec->qualification}}"></td>
                                        <td><input type="number" min="0" class="form-control" name="effectif_rec[]" placeholder="Effectif" value="{{ $employee_rec->effectif}}"></td>
                                        <td><input type="number" min="0" class="form-control" name="salaire_rec[]" placeholder="Salaires mensuels" value="{{ $employee_rec->salaire_mensuel}}"></td>
                                        <td><textarea class="form-control" name="taches_rec[]" placeholder="Tâches prévues" value="{{ $employee_rec->tache_prevu}}"></textarea></td>
                                        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td><input type="text" class="form-control" name="poste_rec[]" placeholder="Poste"></td>
                                        <td><input type="text" class="form-control" name="qualification_rec[]" placeholder="Qualification"></td>
                                        <td><input type="number" min="0" class="form-control" name="effectif_rec[]" placeholder="Effectif"></td>
                                        <td><input type="number" min="0" class="form-control" name="salaire_rec[]" placeholder="Salaires mensuels"></td>
                                        <td><textarea class="form-control" name="taches_rec[]" placeholder="Tâches prévues"></textarea></td>
                                        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                    @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" id="addRow" onclick="addEmployeRecruterRow()">Ajouter une ligne</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="finance" role="tabpanel" aria-labelledby="finance-tab">
                <h5>Dossier financier</h5>
                <!-- Estimation -->
                <div class="card my-4">
                    <div class="card-header bg-secondary text-white">
                        Estimation
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="montant_emprunt" class="col-lg-3 col-form-label">Quel est le montant de l’emprunt que vous envisagez ?</label>
                            <div class="col-lg-9">
                                <input type="number" min="0" class="form-control" id="montant_emprunt" name="montant_emprunt" value="{{ $business_plan->montant_emprunt }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nombre_year_remb" class="col-lg-3 col-form-label">En combien d’année souhaitez-vous rembourser votre emprunt ?</label>
                            <div class="col-lg-9">
                                <input type="number" min="0" class="form-control" id="nombre_year_remb" name="nombre_year_remb" value="{{ $business_plan->nombre_year_remb }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="estimation_chiffre_affaire" class="col-lg-3 col-form-label">Avantages concurrentiels</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="estimation_chiffre_affaire" name="estimation_chiffre_affaire" rows="2">{{ $business_plan->estimation_chiffre_affaire }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Avez-vous déjà ciblé un ou des partenaires (financiers, techniques, commerciaux) ? si oui, lesquels  -->
                <div class="card my-4">
                    <div class="card-header bg-secondary text-white">
                        Avez-vous déjà ciblé un ou des partenaires (financiers, techniques, commerciaux) ? si oui, lesquels
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="cible_partenaire" class="col-lg-3 col-form-label">Avez-vous déjà ciblé un ou des partenaires ?</label>
                            <div class="col-lg-9">
                                <select class="form-select" id="cible_partenaire" name="cible_partenaire" onchange="displayPartenaire()">
                                    <option value="">Selectionner...</option>
                                    <option value="oui" @if($business_plan->cible_partenaire == 'oui') selected @endif>Oui</option>
                                    <option value="non" @if($business_plan->cible_partenaire == 'non') selected @endif>Non</option>
                                </select>
                            </div>
                        </div>
                        <div id="display_partenaire" style="display: {{ $business_plan->cible_partenaire == 'oui'?'initial':'none' }}">
                            <div class="row mb-3" >
                                <label for="nombre_year_remb" class="col-lg-3 col-form-label">Financiers, techniques, commerciaux</label>
                                <div class="col-lg-9">
                                    <table class="table table-bordered" id="partenaireTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nom du partenaire</th>
                                                    <th scope="col">Montant emprunt</th>
                                                    <th scope="col">Nombre d'année remb.</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="partenaire_area">
                                                @if($business_plan->partenaire && ($business_plan->partenaire)->count()>0)
                                                    @foreach($business_plan->partenaire as $key => $business_plan_part)
                                                    <tr>
                                                        <td><input type="text" class="form-control" name="nom_partenaire[]" placeholder="Nom du partenaire" value="{{ $business_plan_part->nom_partenaire}}"></td>
                                                        <td><input type="number" min="0" class="form-control" name="montant_emprunte[]" placeholder="100000" value="{{ $business_plan_part->montant_emprunt}}"></td>
                                                        <td><input type="number" min="0" class="form-control" name="nombre_year_rem[]" placeholder="01" value="{{ $business_plan_part->nombre_year_remb}}"></td>
                                                        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td><input type="text" class="form-control" name="nom_partenaire[]" placeholder="Nom du partenaire"></td>
                                                        <td><input type="number" min="0" class="form-control" name="montant_emprunte[]" placeholder="100000"></td>
                                                        <td><input type="number" min="0" class="form-control" name="nombre_year_rem[]" placeholder="01"></td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" id="addRow" onclick="addPartenaireRow()">Ajouter une ligne</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chiffre d’affaires de la première année -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Chiffre d’affaires de la première année</h5>
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
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(($business_plan->chiffre_affaire_first_years)->count()>0)
                                    @foreach($business_plan->chiffre_affaire_first_years as $key => $business_plan_chiffre_affaire_first_year)
                                    <tr>
                                        <td><input type="text" class="form-control" name="produit[]" placeholder="Produit" value="{{ $business_plan_chiffre_affaire_first_year->produit }}"></td>
                                        <td><input type="text" class="form-control" name="unite_first[]" placeholder="Forfait" value="{{ $business_plan_chiffre_affaire_first_year->unite_first }}"></td>
                                        <td><input type="number" min="0" id="quantite_first_{{ $business_plan_chiffre_affaire_first_year->id }}" class="form-control" name="quantite_first[]" value="{{ $business_plan_chiffre_affaire_first_year->quantite }}" onkeyup="calculeChiffre('quantite_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'prix_unitaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'chiffre_affaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}');" onclick="calculeChiffre('quantite_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'prix_unitaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'chiffre_affaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}');"></td>
                                        <td><input type="number" min="0" id="prix_unitaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}" class="form-control" name="prix_unitaire_first[]" value="{{ $business_plan_chiffre_affaire_first_year->prix_unitaire }}" onkeyup="calculeChiffre('quantite_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'prix_unitaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'chiffre_affaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}');" onclick="calculeChiffre('quantite_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'prix_unitaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'chiffre_affaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}');"></td>
                                        <td><input type="number" min="0" id="chiffre_affaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}" class="form-control" name="chiffre_affaire_first[]" value="{{ $business_plan_chiffre_affaire_first_year->chiffre_affaire_first }}"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td><input type="text" class="form-control" name="produit[]" placeholder="Produit"></td>
                                        <td><input type="text" class="form-control" name="unite_first[]" placeholder="Forfait"></td>
                                        <td><input type="number" min="0" id="quantite_first" class="form-control" name="quantite_first[]" onkeyup="calculeChiffre('quantite_first', 'prix_unitaire_first', 'chiffre_affaire_first');" onclick="calculeChiffre('quantite_first', 'prix_unitaire_first', 'chiffre_affaire_first');"  value="0"></td>
                                        <td><input type="number" min="0" id="prix_unitaire_first" class="form-control" name="prix_unitaire_first[]" onkeyup="calculeChiffre('quantite_first', 'prix_unitaire_first', 'chiffre_affaire_first');" onclick="calculeChiffre('quantite_first', 'prix_unitaire_first', 'chiffre_affaire_first');"  value="0"></td>
                                        <td><input type="number" min="0" id="chiffre_affaire_first" class="form-control" name="chiffre_affaire_first[]"></td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <input type="hidden" id="chiffre_affaire_first_years" value="{{ $business_plan->chiffre_affaire_first_years->count() }}">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" onclick="addEstimationFirstRow()">Ajouter une ligne</button>
                        </div>
                    </div>
                </div>

                <!-- Estimation du chiffre d’affaires -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Estimation du chiffre d’affaires (<small class="fs-6">Sur les cinq premières années d’activités, les chiffres d’affaires sont progressives avec une évolution annuelle de 25%</small>)</h5>
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
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(($business_plan->chiffre_affaires)->count()>0)
                                    @foreach($business_plan->chiffre_affaires as $key => $business_plan_chiffre_affaire)
                                    <tr>
                                        <td><input type="text" class="form-control" name="produits[]" placeholder="Produit" value="{{ $business_plan_chiffre_affaire->produit}}"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_1[]" placeholder="Montant" value="{{ $business_plan_chiffre_affaire->an_1 }}"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_2[]" placeholder="Montant" value="{{ $business_plan_chiffre_affaire->an_2 }}"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_3[]" placeholder="Montant" value="{{ $business_plan_chiffre_affaire->an_3 }}"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_4[]" placeholder="Montant" value="{{ $business_plan_chiffre_affaire->an_4 }}"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_5[]" placeholder="Montant" value="{{ $business_plan_chiffre_affaire->an_5 }}"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                    @endforeach
                                @elseif(($business_plan->chiffre_affaire_first_years)->count()>0)
                                    @foreach($business_plan->chiffre_affaire_first_years as $key => $business_plan_chiffre_affaire_first_year)
                                    <tr>
                                        <td><input type="text" class="form-control" name="produits[]" placeholder="Produit" value="{{ $business_plan_chiffre_affaire_first_year->produit }}"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_1[]" placeholder="Montant" value="{{ $business_plan_chiffre_affaire_first_year->chiffre_affaire_first }}"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_2[]" placeholder="Montant"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_3[]" placeholder="Montant"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_4[]" placeholder="Montant"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_5[]" placeholder="Montant"></td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td><input type="text" class="form-control" name="produits[]" placeholder="Produit"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_1[]" placeholder="Montant"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_2[]" placeholder="Montant"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_3[]" placeholder="Montant"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_4[]" placeholder="Montant"></td>
                                        <td><input type="number" min="0" class="form-control" name="an_5[]" placeholder="Montant"></td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" onclick="addEstimationRow();">Ajouter une ligne</button>
                        </div>
                    </div>
                </div>


                <form id="personnelForm">
                <!-- Matières premières -->
                <!-- Equipement de production -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Equipements de production</h5>
                        <small>Ils représentent les machines, outils et systèmes utilisés pour transformer des matières premières en produits finis, ainsi que les équipements de soutien comme le stockage, la manutention et la signalisation</small>
                    </div>
                    <div class="card-body">
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
                        <div class="m-b-2">
                            <strong>Description de l’équipement de production existant</strong>
                        </div>
                        <table class="table table-bordered" id="equipementExistTable">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 30%;">Désignation</th>
                                    <th scope="col">Unité</th>
                                    <th scope="col">Quantité</th>
                                    <th scope="col">Etat de fonctionnement </th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($equipement_exists && $equipement_exists->count()>0)
                                @foreach ($equipement_exists as $equipement_exist)
                                <tr>
                                    <td><input type="text" class="form-control" name="designation_equipement_exist[]" placeholder="Désignation" value="{{ $equipement_exist->description }}"></td>
                                    <td><input type="text" class="form-control" name="unite_equipement_exist[]" placeholder="Forfait" value="{{ $equipement_exist->unite }}"></td>
                                    <td><input type="number" min="0" class="form-control" name="quantite_equipement_exist[]" placeholder="01" value="{{ $equipement_exist->quantite }}"></td>
                                    <td>
                                         <select class="form-select" id="etat_fonctionnement" name="etat_fonctionnement[]">
                                            <option value="">Selectionner l'état</option>
                                            <option value="neuf" @if($equipement_exist->etat_fonctionnement == 'neuf') selected @endif>Neuf</option>
                                            <option value="bon" @if($equipement_exist->etat_fonctionnement == 'bon') selected @endif>Bon</option>
                                            <option value="moyen" @if($equipement_exist->etat_fonctionnement == 'moyen') selected @endif>Moyen</option>
                                            <option value="mauvais" @if($equipement_exist->etat_fonctionnement == 'mauvais') selected @endif>Mauvais</option>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td><input type="text" class="form-control" name="designation_equipement_exist[]" placeholder="Désignation"></td>
                                    <td><input type="text" class="form-control" name="unite_equipement_exist[]" placeholder="Forfait"></td>
                                    <td><input type="number" min="0" class="form-control" name="quantite_equipement_exist[]" placeholder="01"></td>
                                    <td>
                                        <select class="form-select" id="etat_fonctionnement" name="etat_fonctionnement[]">
                                            <option value="">Selectionner l'état</option>
                                            <option value="neuf">Neuf</option>
                                            <option value="bon">Bon</option>
                                            <option value="moyen">Moyen</option>
                                            <option value="mauvais">Mauvais</option>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" onclick="addEquipementExistRow({{ $charges->first()->id_valeur }});">Ajouter une ligne</button>
                        </div>
                        <div class="m-b-2">
                            <strong>Description de l’équipement de production à acquérir</strong>
                        </div>
                        <table class="table table-bordered" id="equipementAqTable">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 30%;">Désignation</th>
                                    <th scope="col">Unité</th>
                                    <th scope="col">Quantité</th>
                                    <th scope="col">Sources d’approvisionnement </th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($equipement_aqs && $equipement_aqs->count()>0)
                                @foreach ($equipement_aqs as $equipement_aq)
                                <tr>
                                    <td><input type="text" class="form-control" name="designation_equipement_aq[]" placeholder="Désignation" value="{{ $equipement_aq->description }}"></td>
                                    <td><input type="text" class="form-control" name="unite_equipement_aq[]" placeholder="Forfait" value="{{ $equipement_aq->unite }}"></td>
                                    <td><input type="number" min="0" class="form-control" name="quantite_equipement_aq[]" placeholder="01" value="{{ $equipement_aq->quantite }}"></td>
                                    <td><input type="text" class="form-control" name="source_approvisionnement[]" placeholder="Source" value="{{ $equipement_aq->etat_fonctionnement }}"></td>
                                    <td></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td><input type="text" class="form-control" name="designation_equipement_aq[]" placeholder="Désignation"></td>
                                    <td><input type="text" class="form-control" name="unite_equipement_aq[]" placeholder="Forfait"></td>
                                    <td><input type="number" min="0" class="form-control" name="quantite_equipement_aq[]" placeholder="01"></td>
                                    <td><input type="text" class="form-control" name="source_approvisionnement[]" placeholder="Source"></td>
                                    <td></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" onclick="addEquipementAqRow({{ $charges->first()->id_valeur }});">Ajouter une ligne</button>
                        </div>
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
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($charges->first()->id)
                                @foreach ($charges as $charge_exploitation)
                                <tr>
                                    <td><input type="text" class="form-control" name="designation_charge_{{ $charges->first()->id_valeur }}[]" placeholder="Désignation" value="{{ $charge_exploitation->designation }}"></td>
                                    <td><input type="text" class="form-control" name="unite_charge_{{ $charges->first()->id_valeur }}[]" placeholder="Forfait" value="{{ $charge_exploitation->unite }}"></td>
                                    <td><input type="number" min="0" id="quantite_charge_{{ $charge_exploitation->id }}" class="form-control" name="quantite_charge_{{ $charges->first()->id_valeur }}[]" value="{{ $charge_exploitation->quantite }}" onkeyup="calculeChiffre('quantite_charge_{{ $charge_exploitation->id }}', 'cout_unitaire_charge_{{ $charge_exploitation->id }}', 'cout_total_charge_{{ $charge_exploitation->id }}');" onclick="calculeChiffre('quantite_charge_{{ $charge_exploitation->id }}', 'cout_unitaire_charge_{{ $charge_exploitation->id }}', 'cout_total_charge_{{ $charge_exploitation->id }}');"></td>
                                    <td><input type="number" min="0" id="cout_unitaire_charge_{{ $charge_exploitation->id }}" class="form-control" name="cout_unitaire_charge_{{ $charges->first()->id_valeur }}[]" value="{{ $charge_exploitation->cout_unitaire }}" onkeyup="calculeChiffre('quantite_charge_{{ $charge_exploitation->id }}', 'cout_unitaire_charge_{{ $charge_exploitation->id }}', 'cout_total_charge_{{ $charge_exploitation->id }}');" onclick="calculeChiffre('quantite_charge_{{ $charge_exploitation->id }}', 'cout_unitaire_charge_{{ $charge_exploitation->id }}', 'cout_total_charge_{{ $charge_exploitation->id }}');"></td>
                                    <td><input type="text" id="cout_total_charge_{{ $charge_exploitation->id }}" class="form-control" name="cout_total_charge_{{ $charges->first()->id_valeur }}[]" disabled value="{{ number_format(floatval($charge_exploitation->cout_total), 0, ',', ' ') }}"></td>
                                    <td></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td><input type="text" class="form-control" name="designation_charge_{{ $charges->first()->id_valeur }}[]" placeholder="Désignation"></td>
                                    <td><input type="text" class="form-control" name="unite_charge_{{ $charges->first()->id_valeur }}[]" placeholder="Forfait"></td>
                                    <td><input type="number" min="0" id="quantite_charge_{{ $charges->first()->id_valeur }}" class="form-control" name="quantite_charge_{{ $charges->first()->id_valeur }}[]" onkeyup="calculeChiffre('quantite_charge_{{ $charges->first()->id_valeur }}', 'cout_unitaire_charge_{{ $charges->first()->id_valeur }}', 'cout_total_charge_{{ $charges->first()->id_valeur }}');" onclick="calculeChiffre('quantite_charge_{{ $charges->first()->id_valeur }}', 'cout_unitaire_charge_{{ $charges->first()->id_valeur }}', 'cout_total_charge_{{ $charges->first()->id_valeur }}');" value="0"></td>
                                    <td><input type="number" min="0" id="cout_unitaire_charge_{{ $charges->first()->id_valeur }}" class="form-control" name="cout_unitaire_charge_{{ $charges->first()->id_valeur }}[]" onkeyup="calculeChiffre('quantite_charge_{{ $charges->first()->id_valeur }}', 'cout_unitaire_charge_{{ $charges->first()->id_valeur }}', 'cout_total_charge_{{ $charges->first()->id_valeur }}');" onclick="calculeChiffre('quantite_charge_{{ $charges->first()->id_valeur }}', 'cout_unitaire_charge_{{ $charges->first()->id_valeur }}', 'cout_total_charge_{{ $charges->first()->id_valeur }}');" value="0"></td>
                                    <td><input type="number" min="0" id="cout_total_charge_{{ $charges->first()->id_valeur }}" class="form-control" name="cout_total_charge_{{ $charges->first()->id_valeur }}[]" value="0" disabled></td>
                                    <td></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <input type="hidden" id="charge_{{ $charges->first()->id_valeur }}" value="{{ $charges->count() }}">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary" onclick="addChargeRow({{ $charges->first()->id_valeur }});">Ajouter une ligne</button>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <div class="tab-pane fade p-3" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                <h5>PAIEMENT DE LA FACTURE</h5>
                <!-- Estimation -->
                <div class="card my-4">
                    <div class="card-header bg-secondary text-white">
                        PAIEMENT DE FACTURE
                    </div>
                    <div class="card-body">
                        @if($business_plan->entreprise)
                            <table>
                                <tr><th style="width: 17rem;">Reçu N°:</th><td>2025-001</td></tr>
                                <tr><th>Date de comptabilisation:</th><td>{{ date('d/m/Y') }}</td></tr>
                                <tr><th>Référence client:</th><td>2025-{{ $business_plan->entreprise->id }}</td></tr>
                                <tr><th>Nom commerciale:</th><td>{{ $business_plan->entreprise->denomination }}</td></tr>
                                <tr><th>Nom et prénom déposant:</th><td>SOULE SANOU</td></tr>
                                <tr><th>Adresse:</th><td>{{ $business_plan->entreprise->commune?$business_plan->entreprise->commune->nom_structure:'' }}</td></tr>
                                <tr><th>Téléphone:</th><td>{{ $business_plan->entreprise->denomination }}</td></tr>
                            </table>
                            <div class="mt-2">
                                @if($business_plan->is_valide)<a class="btn btn-danger" href="{{ route('businessplans.payer', $business_plan->id) }}">Payer</a>@endif
                            </div>
                            @else
                            <div class="alert alert-danger">Vous n'aviez pas encore renseigner les informations sur l'entreprise</div>
                            <p>Vous deviez renseigner les informations sur l'entreprise avant de pouvoir payer</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-success mx-1">Enregistrer</button>

            </div>
        </form>
    </div>
  </section><!-- /Features Section -->
@endsection
