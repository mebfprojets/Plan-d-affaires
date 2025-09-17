@extends('backend.layouts.layout')
@section('plans', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Plan d'affaires</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('businessplans.index') }}">Plan d'affaires</a></li>
            <li class="breadcrumb-item active">Éditer</li>
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
                    <h4 class="card-title">Éditer un plan d'affaires</h4>
                    <form action="{{ route('business_plans.update', $business_plan->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" id="trash_icon" value="{{ $trash_icon }}">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#presentation" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Présentation du projet</span></a> </li>
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#promoteur" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Présentation du promoteur et de l’entreprise</span></a> </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#commercial" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Dossier commercial</span></a> </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#technique" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Dossier technique</span></a> </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#finance" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Dossier financier</span></a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane p-20" id="presentation" role="tabpanel">
                            <h5>Présentation du projet</h5>
                            <input type="hidden" name="id_pack" value="{{ $business_plan->id }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="business_idea" class="fw-bold">Idée de projet <span class="text-danger">*</span></label>
                                        <p>Dire comment est venue l’idée de projet et en quoi consiste le projet ?</p>
                                        <textarea name="business_idea" id="business_idea" rows="3" class="form-control">{{ $business_plan->business_idea }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="business_object" class="fw-bold">Objectifs du projet </label>
                                        <p>Formuler des objectifs mesurables et réalisables pour votre future entreprise, quelles sont les cibles à atteindre, les résultats à obtenir ?</p>
                                        <textarea name="business_object" id="business_object" rows="2" class="form-control">{{ $business_plan->business_object }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="business_titre" class="fw-bold">Titre du projet</label>
                                        <p>Dire le titre que porte le projet</p>
                                        <textarea name="business_titre" id="business_titre" rows="3" class="form-control">{{ $business_plan->business_titre }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="caractere_innovant_projet" class="fw-bold">Caractère innovant du projet </label>
                                        <p>Quel est le caractère innovant du projet?</p>
                                        <textarea name="caractere_innovant_projet" id="caractere_innovant_projet" rows="3" class="form-control">{{ $business_plan->caractere_innovant_projet }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="business_activity" class="fw-bold">Activités du projet</label>
                                        <p>Quelles sont les activités du projet?</p>
                                        <textarea name="business_activity" id="business_activity" rows="3" class="form-control">{{ $business_plan->business_activity }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <label for="jobTitle2" class="fw-bold">Calendrier des réalisations</label>
                            <p><i>Décrivez ce qui a déjà été réalisé, ce qui est en cours et ce qui est à venir (Exemple : élaboration du plan d’affaires, mobilisation du financement, construction et aménagement, achat des équipements, négociation avec les fournisseurs, élaboration du plan de communication, recrutement du personnel, démarrage de la production, ouverture officielle).</i></p>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="activityTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Étapes des activités</th>
                                            <th scope="col">Dates indicatives</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($business_plan->activities && $business_plan->activities->count()>0)
                                        @foreach($business_plan->activities as $key=>$act)
                                        <tr>
                                            <td><input type="text" name="etapes_activites[]" class="form-control" placeholder="Etape de l'activité" value="{{ $act->step_activity }}"></td>
                                            <td><input type="date" name="dates_indicatives[]" class="form-control" placeholder="jj/mm/aaaa" value="{{ $act->date_indicative }}"></td>
                                            <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td><input type="text" name="etapes_activites[]" class="form-control" placeholder="Etape de l'activité"></td>
                                            <td><input type="date" name="dates_indicatives[]" class="form-control" placeholder="jj/mm/aaaa"></td>
                                            <td></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary" id="addRow" onclick="addActivityRow()">Ajouter une ligne</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane active p-20" id="promoteur" role="tabpanel">
                            <h5>Présentation du promoteur et de l’entreprise</h5>
                            <!-- Première carte : Informations personnelles -->
                            <div class="card mb-4">
                                <div class="card-header bg-secondary">
                                    <h5 class="text-white">Informations Promoteurs</h5>
                                </div>
                                <div class="card-body">
                                    <div class="btn-actions text-right mb-2" style="border: 0;">
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="addPromoteurRow()">
                                            <i class="fa fa-plus"></i> Ajouter un promoteur
                                        </button>
                                    </div>
                                    @if($business_plan->promoteurs && $business_plan->promoteurs->count()>0)
                                    @php $nombre_promoteur = $business_plan->promoteurs->count(); @endphp
                                    @foreach($business_plan->promoteurs as $index=>$business_plan_promoteur)


                                    <div class="promo mt-3">
                                        <div class="row mb-3">
                                            <div class="col-lg-8 offset-3">
                                                <input name="porteur" type="radio" id="porteur_{{ $business_plan_promoteur->id }}" class="" value="{{ $index }}" @if($business_plan_promoteur->is_porteur) checked @endif />
                                                <label for="porteur_{{ $business_plan_promoteur->id }}">Promoteur porteur ou responsable?</label>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="nom_promoteur" class="col-lg-3 col-form-label">Nom promoteur</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="nom_promoteur" name="nom_promoteur[]" placeholder="Nom du promoteur" value="{{ $business_plan_promoteur->nom_promoteur }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="prenom_promoteur" class="col-lg-3 col-form-label">Prénom du promoteur</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="prenom_promoteur" name="prenom_promoteur[]" placeholder="Prénom du promoteur" value="{{ $business_plan_promoteur->prenom_promoteur }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="tel_promoteur" class="col-lg-3 col-form-label">Téléphon du promoteur</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="tel_promoteur" name="tel_promoteur[]" placeholder="Téléphone du promoteur" value="{{ $business_plan_promoteur->tel_promoteur }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="email_promoteur" class="col-lg-3 col-form-label">Email promoteur</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="email_promoteur" name="email_promoteur[]" placeholder="Email du promoteur" value="{{ $business_plan_promoteur->email_promoteur }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="age" class="col-lg-3 col-form-label">Âge</label>
                                            <div class="col-lg-8">
                                                <input type="number" min="0" class="form-control" id="age" name="age[]" placeholder="Entrez votre âge" value="{{ $business_plan_promoteur->age }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="sexe" class="col-lg-3 col-form-label">Sexe</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" id="sexe" name="sexe[]">
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
                                                <select class="form-control" id="situation_famille" name="situation_famille[]">
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
                                    <hr>
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
                                                <select class="form-control" id="sexe" name="sexe[]">
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
                                                <select class="form-control" id="situation_famille" name="situation_famille[]">
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
                                        <label for="adresse_entreprise" class="col-lg-3 col-form-label">Adresse</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="adresse_entreprise" name="adresse_entreprise" placeholder="Adresse de l'entreprise" value="{{ $business_plan->entreprise?$business_plan->entreprise->adresse_entreprise:'' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email_entreprise" class="col-lg-3 col-form-label">Email</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="email_entreprise" name="email_entreprise" placeholder="Email de l'entreprise" value="{{ $business_plan->entreprise?$business_plan->entreprise->email_entreprise:'' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="tel_entreprise" class="col-lg-3 col-form-label">Téléphone</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="tel_entreprise" name="tel_entreprise" placeholder="Téléphone de l'entreprise" value="{{ $business_plan->entreprise?$business_plan->entreprise->tel_entreprise:'' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="forme_juridique" class="col-lg-3 col-form-label">Forme juridique</label>
                                        <div class="col-lg-9">
                                            <select class="select2 form-control custom-select" id="forme_juridique" name="forme_juridique" style="width: 100%; height:36px;">
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
                                            <input type="date" class="form-control" id="date_creation" name="date_creation" value="{{ $business_plan->entreprise?$business_plan->entreprise->date_creation_prevue:'' }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="atout_promoteur" class="col-lg-3 col-form-label">Atouts du promoteur</label>
                                        <div class="col-lg-9">
                                            <textarea class="form-control" id="atout_promoteur" name="atout_promoteur">{{ $business_plan->entreprise?$business_plan->entreprise->atout_promoteur:'' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="presentation_entreprise" class="col-lg-3 col-form-label">Présentation de l’entreprise</label>
                                        <div class="col-lg-9">
                                            <textarea class="form-control" id="presentation_entreprise" name="presentation_entreprise">{{ $business_plan->entreprise?$business_plan->entreprise->presentation_entreprise:'' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="statut_juridique_gerance" class="col-lg-3 col-form-label">Statut juridique et gérence</label>
                                        <div class="col-lg-9">
                                            <textarea class="form-control" id="statut_juridique_gerance" name="statut_juridique_gerance">{{ $business_plan->entreprise?$business_plan->entreprise->statut_juridique_gerance:'' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="localisation" class="col-lg-3 col-form-label">Localisation</label>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <!-- REGION -->
                                                <div class="col-lg-3">
                                                    <select class="select2 form-control custom-select" id="id_region" name="id_region" onchange="changeValue('id_region', 'id_province', 'province');" style="width: 100%; height:36px;">
                                                        <option value="">Selectionner la région ...</option>
                                                        @foreach($regions as $region)
                                                        <option value="{{ $region->id }}" @if($business_plan->entreprise && $region->id == $business_plan->entreprise->id_region) selected @endif>{{ $region->nom_structure }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!-- PROVINCE -->
                                                <div class="col-lg-3">
                                                    <select class="select2 form-control custom-select" id="id_province" name="id_province" onchange="changeValue('id_province', 'id_commune', 'commune');" style="width: 100%; height:36px;">
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
                                                    <select class="select2 form-control custom-select" id="id_commune" name="id_commune" onchange="changeValue('id_commune', 'id_arrondissement', 'arrondissement');" style="width: 100%; height:36px;">
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
                                                    <select class="select2 form-control custom-select" id="id_arrondissement" name="id_arrondissement" style="width: 100%; height:36px;">
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
                                        <div class="my-3"></div>
                                        <hr>
                                        <label for="engagement" class="col-lg-3 col-form-label">Engagement en cours</label>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered" id="banqueTable">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nature des crédits en cours </th>
                                                        <th scope="col">Structure de financement</th>
                                                        <th scope="col">Date de début</th>
                                                        <th scope="col">Capital et intérêts</th>
                                                        <th scope="col">Mensualités</th>
                                                        <th scope="col">Reste à payer</th>
                                                        <th scope="col">Date d’échéance </th>
                                                        <th scope="col">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="banque_area">
                                                    @if($business_plan->entreprise && ($business_plan->entreprise->engagements)->count()>0)
                                                        @foreach($business_plan->entreprise->engagements as $key => $business_plan_engagement)
                                                        <tr>
                                                            <td><input type="text" class="form-control" name="nature_credit[]" placeholder="Nature du crédit" value="{{ $business_plan_engagement->nature_credit}}"></td>
                                                            <td><input type="text" class="form-control" name="nom_banque[]" placeholder="Nom de la banque" value="{{ $business_plan_engagement->nom_banque}}"></td>
                                                            <td><input type="date" class="form-control" name="date_debut[]" value="{{ $business_plan_engagement->date_debut}}"></td>
                                                            <td><input type="text" min="0" class="form-control" name="montant_emp[]" placeholder="100000" value="{{ number_format($business_plan_engagement->montant_emprunt, 0, ',', ' ') }}"></td>
                                                            <td><input type="text" min="0" class="form-control" name="mensualite[]" placeholder="100000" value="{{ number_format($business_plan_engagement->mensualite, 0, ',', ' ') }}"></td>
                                                            <td><input type="text" min="0" class="form-control" name="montant_restant[]" placeholder="100000" value="{{  number_format($business_plan_engagement->montant_restant, 0, ',', ' ') }}"></td>
                                                            <td><input type="date" class="form-control" name="date_echeance[]" value="{{ $business_plan_engagement->date_echeance}}"></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" class="form-control" name="nature_credit[]" placeholder="Nature du crédit"></td>
                                                            <td><input type="text" class="form-control" name="nom_banque[]" placeholder="Nom de la banque"></td>
                                                            <td><input type="date" class="form-control" name="date_debut[]"></td>
                                                            <td><input type="text" min="0" class="form-control" name="montant_emp[]" placeholder="100000"></td>
                                                            <td><input type="text" min="0" class="form-control" name="mensualite[]" placeholder="100000"></td>
                                                            <td><input type="text" min="0" class="form-control" name="montant_restant[]" placeholder="100000"></td>
                                                            <td><input type="date" class="form-control" name="date_echeance[]"></td>
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

                            <!-- Compte d'exploitation -->
                            <input type="hidden" name="first_year" value="{{ $year }}">
                            <label for="compte_exploitation" class="col-lg-3 col-form-label" style="font-weight: bold; text-transform: uppercase;">Compte d’exploitation</label>
                            <div class="table-responsive">

                                <table class="table table-bordered" id="banqueTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Désignation</th>
                                        <th scope="col">{{ $year-2 }}</th>
                                        <th scope="col">{{ $year-1 }}</th>
                                        <th scope="col">{{ $year }}</th>
                                    </tr>
                                </thead>
                                <tbody id="banque_area">
                                    @foreach($compteExploitations as $key => $compte_exploitation)
                                    <tr>
                                        <td><span> {{ $compte_exploitation->libelle}} </span><input type="hidden" name="valeur[]" value="{{ $compte_exploitation->id }}"></td>
                                        <td><input type="text" class="form-control" name="montant_first[]" placeholder="100000" value="{{ number_format($compte_exploitation->first_year, 0, ',', ' ') }}"></td>
                                        <td><input type="text" class="form-control" name="montant_second[]" value="{{ number_format($compte_exploitation->second_year, 0, ',', ' ') }}"></td>
                                        <td><input type="text" min="0" class="form-control" name="montant_third[]" placeholder="100000" value="{{ number_format($compte_exploitation->third_year, 0, ',', ' ') }}"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            <label for="compte_exploitation" class="col-lg-3 col-form-label" style="font-weight: bold; text-transform: uppercase;">Bilan en grande masses</label>
                            <div class="table-responsive">

                                <table class="table table-bordered" id="banqueTable">

                                <tbody id="banque_area">
                                    <tr>
                                        <th scope="col">ACTIF </th>
                                        <th scope="col">{{ $year-2 }}</th>
                                        <th scope="col">{{ $year-1 }}</th>
                                        <th scope="col">{{ $year }}</th>
                                    </tr>
                                    @foreach($bilanMasseActifs as $key => $bilanMasseActif)
                                    <tr>
                                        <td><span> {{ $bilanMasseActif->libelle}} </span><input type="hidden" name="valeur_actif[]" value="{{ $bilanMasseActif->id }}"></td>
                                        <td><input type="text" class="form-control" name="montant_first_actif[]" placeholder="100000" value="{{ number_format($bilanMasseActif->first_year, 0, ',', ' ') }}"></td>
                                        <td><input type="text" class="form-control" name="montant_second_actif[]" value="{{ number_format($bilanMasseActif->second_year, 0, ',', ' ') }}"></td>
                                        <td><input type="text" min="0" class="form-control" name="montant_third_actif[]" placeholder="100000" value="{{ number_format($bilanMasseActif->third_year, 0, ',', ' ') }}"></td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th scope="col">TOTAL GÉNÉRAL </th>
                                        <th scope="col">{{ number_format($bilanMasseActifs->sum('first_year'), 0, ',', ' ') }}</th>
                                        <th scope="col">{{ number_format($bilanMasseActifs->sum('second_year'), 0, ',', ' ') }}</th>
                                        <th scope="col">{{ number_format($bilanMasseActifs->sum('third_year'), 0, ',', ' ') }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">PASSIF </th>
                                        <th scope="col">{{ $year-2 }}</th>
                                        <th scope="col">{{ $year-1 }}</th>
                                        <th scope="col">{{ $year }}</th>
                                    </tr>
                                    @foreach($bilanMassePacifs as $key => $bilanMassePacif)
                                    <tr>
                                        <td><span> {{ $bilanMassePacif->libelle}} </span><input type="hidden" name="valeur_pacif[]" value="{{ $bilanMassePacif->id }}"></td>
                                        <td><input type="text" class="form-control" name="montant_first_pacif[]" placeholder="100000" value="{{ number_format($bilanMassePacif->first_year, 0, ',', ' ') }}"></td>
                                        <td><input type="text" class="form-control" name="montant_second_pacif[]" value="{{ number_format($bilanMassePacif->second_year, 0, ',', ' ') }}"></td>
                                        <td><input type="text" min="0" class="form-control" name="montant_third_pacif[]" placeholder="100000" value="{{ number_format($bilanMassePacif->third_year, 0, ',', ' ') }}"></td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th scope="col">TOTAL GÉNÉRAL </th>
                                        <th scope="col">{{ number_format($bilanMassePacifs->sum('first_year'), 0, ',', ' ') }}</th>
                                        <th scope="col">{{ number_format($bilanMassePacifs->sum('second_year'), 0, ',', ' ') }}</th>
                                        <th scope="col">{{ number_format($bilanMassePacifs->sum('third_year'), 0, ',', ' ') }}</th>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="tab-pane p-20" id="commercial" role="tabpanel">
                            <h5>Dossier commercial</h5>
                            <!-- Produits/Services -->
                            <div class="card my-4">
                                <div class="card-header bg-secondary text-white">
                                    Produits/Services
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        @if(($business_plan->chiffre_affaire_first_years)->count()>0)
                                        <table class="table table-bordered">
                                        @foreach($business_plan->chiffre_affaire_first_years as $key => $business_plan_produit)

                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="2">{{ $business_plan_produit->produit }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td style="width: 27%">Critères</td><td>Description</td></tr>
                                            @foreach ($criteres as $key=>$critere)
                                                <?php
                                                    $id_produit = $business_plan_produit->id;
                                                    $id_valeur = $critere->id;
                                                    $criterep = $business_plan->critere_produits->filter(function ($critere_p) use($id_produit, $id_valeur) {
                                                        return (($critere_p->id_produit == $id_produit) !== false && ($critere_p->id_valeur == $id_valeur) !== false);
                                                    })->first();

                                                ?>
                                                <tr>
                                                    <td>{{ $key+1 }}-  {{ $critere->libelle }}<input type="hidden" name="critere_valeur[]" value="{{ $critere->id }}"><input type="hidden" name="critere_produit[]" value="{{ $business_plan_produit->id }}"></td>
                                                    <td><input type="text" min="0" class="form-control" name="critere_description[]" placeholder="Description" value="{{ $criterep?$criterep->description:'' }}"></td>
                                                </tr>
                                            @endforeach

                                            <!--<tr><td>2- Inconvénients </td><td><input type="text" min="0" class="form-control" name="montant_third[]" placeholder="Description" value=""></td></tr>
                                            <tr><td>3- Les facteurs déterminants de la vente </td><td><input type="text" min="0" class="form-control" name="montant_third[]" placeholder="Description" value=""></td></tr>
                                            <tr><td>4- La valeur ajoutée </td><td><input type="text" min="0" class="form-control" name="montant_third[]" placeholder="Description" value=""></td></tr>
                                            <tr><td>5- Les garanties clientèles </td><td><input type="text" min="0" class="form-control" name="montant_third[]" placeholder="Description" value=""></td></tr>
                                        </tbody>-->
                                        @endforeach
                                    </table>
                                    @else
                                    <span class="alert alert-warning">Aucun produit du chiffre d'affaire de la première année n'est encore!</span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Analyse du marché -->
                            <div class="card my-4">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="text-white">Analyse du marché</h5>
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
                                    <h5 class="text-white">Situation concurrentielle</h5>
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
                                <div class="card-header bg-secondary">
                                    <h5 class="text-white">Analyse concurrentielle de l’entreprise</h5>
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
                                    <div class="table-responsive">
                                        @if(($groupedStrategieMarketings)->count()>0)
                                        <table class="table table-bordered">
                                        @foreach ($groupedStrategieMarketings as $parametre_id => $valeurs)

                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="2">{{ $valeurs->first()->libelle_parametre }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($valeurs as $key=>$valeur)
                                                <?php
                                                    $id_valeur = $valeur->id_valeur;
                                                    $sm = $business_plan->strategie_marketings->filter(function ($sm) use($id_produit, $id_valeur) {
                                                        return ($sm->id_valeur == $id_valeur) !== false ;
                                                    })->first();

                                                    // dd($criterep->id);
                                                ?>
                                                <tr>
                                                    <td style="width: 27%">{{ $key+1 }}-  {{ $valeur->libelle_valeur }}<input type="hidden" name="valeur_sm[]" value="{{ $valeur->id_valeur }}"></td>
                                                    <td><input type="text" min="0" class="form-control" name="libelle_sm[]" placeholder="Description" value="{{ $sm?$sm->libelle_sm:'' }}"></td>
                                                </tr>
                                            @endforeach

                                            <!--<tr><td>2- Inconvénients </td><td><input type="text" min="0" class="form-control" name="montant_third[]" placeholder="Description" value=""></td></tr>
                                            <tr><td>3- Les facteurs déterminants de la vente </td><td><input type="text" min="0" class="form-control" name="montant_third[]" placeholder="Description" value=""></td></tr>
                                            <tr><td>4- La valeur ajoutée </td><td><input type="text" min="0" class="form-control" name="montant_third[]" placeholder="Description" value=""></td></tr>
                                            <tr><td>5- Les garanties clientèles </td><td><input type="text" min="0" class="form-control" name="montant_third[]" placeholder="Description" value=""></td></tr>
                                        </tbody>-->
                                        @endforeach
                                    </table>
                                    @endif
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <label for="politique_produit" class="col-lg-3 col-form-label">Politique de produit</label>
                                        <div class="col-lg-9">
                                            <textarea class="form-control" id="politique_produit" name="politique_produit" rows="2">{{ $business_plan->politique_produit }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Etude du marché -->
                            <div class="card my-4">
                                <div class="card-header bg-secondary text-white">
                                    Etude du marché
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <label for="etude_marche" class="col-lg-3 col-form-label">Etude l’offre</label>
                                        <div class="col-lg-9">
                                            <textarea class="form-control" id="etude_marche" name="etude_marche" rows="2">{{ $business_plan->etude_marche }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="etude_demande" class="col-lg-3 col-form-label">Etude de la demande</label>
                                        <div class="col-lg-9">
                                            <textarea class="form-control" id="etude_demande" name="etude_demande" rows="2">{{ $business_plan->etude_demande }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-20" id="technique" role="tabpanel">
                            <h5>Dossier technique</h5>
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="text-white">Informations sur l'activité</h5>
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
                            <div class="card-header bg-secondary">
                                <h5 class="text-white">Personnel : Organisation, effectif, qualification et tâches prévues</h5>
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
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td><input type="text" class="form-control" name="poste[]" placeholder="Poste"></td>
                                                <td><input type="text" class="form-control" name="qualification[]" placeholder="Qualification"></td>
                                                <td><input type="number" min="0" class="form-control" name="effectif[]" placeholder="Effectif"></td>
                                                <td><input type="number" min="0" class="form-control" name="salaire[]" placeholder="Salaires mensuels"></td>
                                                <td><textarea class="form-control" name="taches[]" placeholder="Tâches prévues"></textarea></td>
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                            @endif
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary btn-sm" id="addRow" onclick="addEmployeRow()">Ajouter une ligne</button>
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
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td><input type="text" class="form-control" name="poste_rec[]" placeholder="Poste"></td>
                                                <td><input type="text" class="form-control" name="qualification_rec[]" placeholder="Qualification"></td>
                                                <td><input type="number" min="0" class="form-control" name="effectif_rec[]" placeholder="Effectif"></td>
                                                <td><input type="number" min="0" class="form-control" name="salaire_rec[]" placeholder="Salaires mensuels"></td>
                                                <td><textarea class="form-control" name="taches_rec[]" placeholder="Tâches prévues"></textarea></td>
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                            @endif
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary btn-sm" id="addRow" onclick="addEmployeRecruterRow()">Ajouter une ligne</button>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="tab-pane p-20" id="finance" role="tabpanel">
                            <h5>Dossier financier</h5>
                            <!-- Recaptitulatif -->
                            <div class="card my-4">
                                <div class="card-header bg-secondary text-white">
                                    Structure financière du projet
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered" id="structureFinanciereTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Désignation </th>
                                                <th scope="col">Montant</th>
                                                <th scope="col">Apport personnel</th>
                                                <th scope="col">Subvention </th>
                                                <th scope="col">Emprunt</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="banque_area">
                                            @if($business_plan->structureFinanciere && ($business_plan->structureFinanciere)->count()>0)
                                                @foreach($business_plan->structureFinanciere as $key => $structure_financiere)
                                                <tr>
                                                    <td><input type="text" class="form-control" name="designation_sf[]" placeholder="Désignation" value="{{ $structure_financiere->designation}}"></td>
                                                    <td><input type="text" class="form-control" name="montant_sf[]" placeholder="100000" value="{{ number_format($structure_financiere->montant, 0, ',', ' ') }}"></td>
                                                    <td><input type="text" class="form-control" name="apport_personnel[]" placeholder="100000" value="{{ number_format($structure_financiere->apport_personnel, 0, ',', ' ') }}"></td>
                                                    <td><input type="text" min="0" class="form-control" name="subvention_sf[]" placeholder="100000" value="{{ number_format($structure_financiere->subvention, 0, ',', ' ') }}"></td>
                                                    <td><input type="text" min="0" class="form-control" name="emprunt_sf[]" placeholder="100000" value="{{ number_format($structure_financiere->emprunt, 0, ',', ' ') }}"></td>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td><input type="text" class="form-control" name="designation_sf[]" placeholder="Désignation"></td>
                                                    <td><input type="text" class="form-control" name="montant_sf[]" placeholder="100000"></td>
                                                    <td><input type="text" class="form-control" name="apport_personnel[]" placeholder="100000"></td>
                                                    <td><input type="text" min="0" class="form-control" name="subvention_sf[]" placeholder="100000"></td>
                                                    <td><input type="text" min="0" class="form-control" name="emprunt_sf[]" placeholder="100000"></td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" id="addRow" onclick="addStructureFinanciereRow()">Ajouter une ligne</button>
                                    </div>
                                </div>
                            </div>
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
                                            <select class="form-control" id="cible_partenaire" name="cible_partenaire" onchange="displayPartenaire()">
                                                <option value="">Selectionner...</option>
                                                <option value="oui" @if($business_plan->cible_partenaire == 'oui') selected @endif>Oui</option>
                                                <option value="non" @if($business_plan->cible_partenaire == 'non') selected @endif>Non</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="display_partenaire" style="display: {{ $business_plan->cible_partenaire == 'oui'?'initial':'none' }}">
                                        <div class="row mb-3">
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
                                                                <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
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
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="card-title left">Chiffre d’affaires de la première année</h5>
                                        </div>
                                        <div class="col-lg-6 px-0 text-right">
                                            <label>(%)C'est le pourcentage d'évolution du chiffre d'affaire des cinq ans à venir.</label>
                                        </div>
                                    </div>
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
                                                <th scope="col" style="width: 10%">%</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(($business_plan->chiffre_affaire_first_years)->count()>0)
                                                @foreach($business_plan->chiffre_affaire_first_years as $key => $business_plan_chiffre_affaire_first_year)
                                                <tr>
                                                    <td><input type="hidden" name="produit_first[]" value="{{ $business_plan_chiffre_affaire_first_year->id }}"><input type="text" class="form-control" name="produit[]" placeholder="Produit" value="{{ $business_plan_chiffre_affaire_first_year->produit }}"></td>
                                                    <td><input type="text" class="form-control" name="unite_first[]" placeholder="Forfait" value="{{ $business_plan_chiffre_affaire_first_year->unite_first }}"></td>
                                                    <td><input type="text" min="0" id="quantite_first_{{ $business_plan_chiffre_affaire_first_year->id }}" class="form-control" name="quantite_first[]" value="{{ number_format($business_plan_chiffre_affaire_first_year->quantite, 0, ',', ' ') }}" onkeyup="calculeChiffre('quantite_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'prix_unitaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'chiffre_affaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}');" onclick="calculeChiffre('quantite_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'prix_unitaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'chiffre_affaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}');"></td>
                                                    <td><input type="text" min="0" id="prix_unitaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}" class="form-control" name="prix_unitaire_first[]" value="{{ number_format($business_plan_chiffre_affaire_first_year->prix_unitaire, 0, ',', ' ') }}" onkeyup="calculeChiffre('quantite_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'prix_unitaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'chiffre_affaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}');" onclick="calculeChiffre('quantite_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'prix_unitaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}', 'chiffre_affaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}');"></td>
                                                    <td><input type="text" min="0" id="chiffre_affaire_first_{{ $business_plan_chiffre_affaire_first_year->id }}" class="form-control" name="chiffre_affaire_first[]" value="{{ number_format($business_plan_chiffre_affaire_first_year->chiffre_affaire_first, 0, ',', ' ') }}"></td>
                                                    <td><input type="number" min="0" id="pourcentage_first_{{ $business_plan_chiffre_affaire_first_year->id }}" class="form-control" name="pourcentage_first[]" placeholder="00" value="{{ number_format($business_plan_chiffre_affaire_first_year->pourcentage_first, 0, ',', ' ') }}"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td><input type="hidden" name="produit_first[]"><input type="text" class="form-control" name="produit[]" placeholder="Produit"></td>
                                                    <td><input type="text" class="form-control" name="unite_first[]" placeholder="Forfait"></td>
                                                    <td><input type="text" min="0" id="quantite_first" class="form-control" name="quantite_first[]" onkeyup="calculeChiffre('quantite_first', 'prix_unitaire_first', 'chiffre_affaire_first');" onclick="calculeChiffre('quantite_first', 'prix_unitaire_first', 'chiffre_affaire_first');"  value="0"></td>
                                                    <td><input type="text" min="0" id="prix_unitaire_first" class="form-control" name="prix_unitaire_first[]" onkeyup="calculeChiffre('quantite_first', 'prix_unitaire_first', 'chiffre_affaire_first');" onclick="calculeChiffre('quantite_first', 'prix_unitaire_first', 'chiffre_affaire_first');"  value="0"></td>
                                                    <td><input type="text" min="0" id="chiffre_affaire_first" class="form-control" name="chiffre_affaire_first[]"></td>
                                                    <td><input type="number" min="0" id="pourcentage_first" class="form-control" name="pourcentage_first[]" placeholder="00"></td>
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
                                    <?php
                                        $ch_firsts = null;
                                        $ch_fives = null;
                                        if($business_plan->chiffre_affaires && $business_plan->chiffre_affaires->count()>0){
                                            // EXIST
                                            $ch_firsts = $business_plan->chiffre_affaires->filter(function ($chiffre_affaires_ex) {
                                                return ($chiffre_affaires_ex->is_ch_first == true) !== false;
                                            });

                                            // AQ
                                            $ch_fives = $business_plan->chiffre_affaires->filter(function ($chiffre_affaires_a) {
                                                return ($chiffre_affaires_a->is_ch_first == false) !== false;
                                            });
                                        }

                                    ?>
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
                                            @if($ch_firsts && $ch_firsts->count()>0)
                                                @foreach($ch_firsts as $key => $ch_first)
                                                <tr>
                                                    <td><input type="text" class="form-control" placeholder="Produit" value="{{ $ch_first->produit}}"></td>
                                                    <td><input type="text" min="0" class="form-control" placeholder="Montant" value="{{ number_format($ch_first->an_1, 0, ',', ' ') }}" disabled=""></td>
                                                    <td><input type="text" min="0" class="form-control" placeholder="Montant" value="{{ number_format($ch_first->an_2, 0, ',', ' ') }}" disabled=""></td>
                                                    <td><input type="text" min="0" class="form-control" placeholder="Montant" value="{{ number_format($ch_first->an_3, 0, ',', ' ') }}" disabled=""></td>
                                                    <td><input type="text" min="0" class="form-control" placeholder="Montant" value="{{ number_format($ch_first->an_4, 0, ',', ' ') }}" disabled=""></td>
                                                    <td><input type="text" min="0" class="form-control" placeholder="Montant" value="{{ number_format($ch_first->an_5, 0, ',', ' ') }}" disabled=""></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            @if($ch_fives && $ch_fives->count()>0)
                                                @foreach($ch_fives as $key => $ch_five)
                                                <tr>
                                                    <td><input type="text" class="form-control" name="produits[]" placeholder="Produit" value="{{ $ch_five->produit}}"></td>
                                                    <td><input type="text" min="0" class="form-control" name="an_1[]" placeholder="Montant" value="{{ number_format($ch_five->an_1, 0, ',', ' ') }}"></td>
                                                    <td><input type="text" min="0" class="form-control" name="an_2[]" placeholder="Montant" value="{{ number_format($ch_five->an_2, 0, ',', ' ') }}"></td>
                                                    <td><input type="text" min="0" class="form-control" name="an_3[]" placeholder="Montant" value="{{ number_format($ch_five->an_3, 0, ',', ' ') }}"></td>
                                                    <td><input type="text" min="0" class="form-control" name="an_4[]" placeholder="Montant" value="{{ number_format($ch_five->an_4, 0, ',', ' ') }}"></td>
                                                    <td><input type="text" min="0" class="form-control" name="an_5[]" placeholder="Montant" value="{{ number_format($ch_five->an_5, 0, ',', ' ') }}"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td><input type="text" class="form-control" name="produits[]" placeholder="Produit"></td>
                                                    <td><input type="text" min="0" class="form-control" name="an_1[]" placeholder="Montant"></td>
                                                    <td><input type="text" min="0" class="form-control" name="an_2[]" placeholder="Montant"></td>
                                                    <td><input type="text" min="0" class="form-control" name="an_3[]" placeholder="Montant"></td>
                                                    <td><input type="text" min="0" class="form-control" name="an_4[]" placeholder="Montant"></td>
                                                    <td><input type="text" min="0" class="form-control" name="an_5[]" placeholder="Montant"></td>
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
                                                <td><input type="number" min="0" class="form-control" name="quantite_equipement_exist[]" placeholder="01" value="{{ number_format($equipement_exist->quantite, 0, ',', ' ') }}"></td>
                                                <td>
                                                    <select class="form-select" id="etat_fonctionnement" name="etat_fonctionnement[]">
                                                        <option value="">Selectionner l'état</option>
                                                        <option value="neuf" @if($equipement_exist->etat_fonctionnement == 'neuf') selected @endif>Neuf</option>
                                                        <option value="bon" @if($equipement_exist->etat_fonctionnement == 'bon') selected @endif>Bon</option>
                                                        <option value="moyen" @if($equipement_exist->etat_fonctionnement == 'moyen') selected @endif>Moyen</option>
                                                        <option value="mauvais" @if($equipement_exist->etat_fonctionnement == 'mauvais') selected @endif>Mauvais</option>
                                                    </select>
                                                </td>
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
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
                                                <td><input type="number" min="0" class="form-control" name="quantite_equipement_aq[]" placeholder="01" value="{{ number_format($equipement_aq->quantite, 0, ',', ' ') }}"></td>
                                                <td><input type="text" class="form-control" name="source_approvisionnement[]" placeholder="Source" value="{{ $equipement_aq->etat_fonctionnement }}"></td>
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
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

                            <!-- Service exterieur -->
                            <div class="card mt-3">
                                <div class="card-header bg-ex">
                                    <h5 class="card-title">Services extérieurs et autres charges</h5>
                                    <small>Ils représentent le montant des factures, paiements et rémunérations versés aux prestataires extérieurs à l'entité.</small>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered" id="serviceExterieurTable">
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
                                            @if($business_plan->serviceExterieur && $business_plan->serviceExterieur->count()>0)
                                            @foreach ($business_plan->serviceExterieur as $service_exterieur)
                                            <tr>
                                                <td><input type="text" class="form-control" name="designation_service_exterieur[]" placeholder="Désignation" value="{{ $service_exterieur->designation }}"></td>
                                                <td><input type="text" class="form-control" name="unite_service_exterieur[]" placeholder="Forfait" value="{{ $service_exterieur->unite }}"></td>
                                                <td><input type="number" min="0" id="quantite_service_exterieur{{ $service_exterieur->id }}" class="form-control" name="quantite_service_exterieur[]" value="{{ number_format($service_exterieur->quantite, 0, ',', ' ') }}" onkeyup="calculeChiffre('quantite_service_exterieur{{ $service_exterieur->id }}', 'cout_unitaire_service_exterieur{{ $service_exterieur->id }}', 'cout_total_charge_');" onclick="calculeChiffre('quantite_service_exterieur{{ $service_exterieur->id }}', 'cout_unitaire_service_exterieur{{ $service_exterieur->id }}', 'cout_total_service_exterieur{{ $service_exterieur->id }}');"></td>
                                                <td><input type="text" min="0" id="cout_unitaire_service_exterieur{{ $service_exterieur->id }}" class="form-control" name="cout_unitaire_service_exterieur[]" value="{{ number_format($service_exterieur->cout_unitaire, 0, ',', ' ') }}" onkeyup="calculeChiffre('quantite_service_exterieur{{ $service_exterieur->id }}', 'cout_unitaire_service_exterieur{{ $service_exterieur->id }}', 'cout_total_service_exterieur');" onclick="calculeChiffre('quantite_service_exterieur{{ $service_exterieur->id }}', 'cout_unitaire_service_exterieur{{ $service_exterieur->id }}', 'cout_total_service_exterieur{{ $service_exterieur->id }}');"></td>
                                                <td><input type="text" id="cout_total_service_exterieur{{ $service_exterieur->id }}" class="form-control" name="cout_total_service_exterieur[]" disabled value="{{ number_format(floatval($service_exterieur->cout_total), 0, ',', ' ') }}"></td>
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td><input type="text" class="form-control" name="designation_service_exterieur[]" placeholder="Désignation"></td>
                                                <td><input type="text" class="form-control" name="unite_service_exterieur[]" placeholder="Forfait"></td>
                                                <td><input type="number" min="0" name="quantite_service_exterieur[]" id="quantite_service_exterieur" class="form-control" onkeyup="calculeChiffre('quantite_service_exterieur', 'cout_unitaire_service_exterieur', 'cout_total_service_exterieur');" onclick="calculeChiffre('quantite_service_exterieur', 'cout_unitaire_service_exterieur', 'cout_total_service_exterieur');" value="0"></td>
                                                <td><input type="text" min="0" name="cout_unitaire_service_exterieur[]"  id="cout_unitaire_service_exterieur" class="form-control" onkeyup="calculeChiffre('quantite_service_exterieur', 'cout_unitaire_service_exterieur', 'cout_total_service_exterieur');" onclick="calculeChiffre('quantite_service_exterieur', 'cout_unitaire_service_exterieur', 'cout_total_service_exterieur');" value="0"></td>
                                                <td><input type="text" min="0" name="cout_total_service_exterieur[]" id="cout_total_service_exterieur" class="form-control" value="0" disabled></td>
                                                <td></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="service_exterieur" value="{{ $business_plan->serviceExterieur?$business_plan->serviceExterieur->count():0 }}">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" onclick="addServiceExterieurRow();">Ajouter une ligne</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Matières premières -->
                            <div class="my-5"><div class="alert alert-success w-100">MATIÈRES PREMIÈRES EXISTENTES</div></div>
                            @foreach ($groupedCharge_exs as $id_valeur => $charge_exs)
                            <div class="card mt-3">
                                <div class="card-header bg-ex">
                                    <h5 class="card-title">{{ $charge_exs->first()->valeur_libelle }}</h5>
                                    <small>{{ $charge_exs->first()->description }}</small>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="charge_existe[]" value="{{ $charge_exs->first()->id_valeur }}">
                                    <table class="table table-bordered" id="chargeExisteTable{{ $charge_exs->first()->id_valeur }}">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 30%;">Désignation</th>
                                                <th scope="col">Quantité</th>
                                                <th scope="col">État</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($charge_exs->first()->id)
                                            @foreach ($charge_exs as $charge_exploitation)
                                            <tr>
                                                <td><input type="text" class="form-control" name="designation_charge_existe{{ $charge_exs->first()->id_valeur }}[]" placeholder="Désignation" value="{{ $charge_exploitation->designation }}"></td>
                                                <td><input type="number" min="0" id="quantite_charge_existe{{ $charge_exploitation->id }}" class="form-control" name="quantite_charge_existe{{ $charge_exs->first()->id_valeur }}[]" value="{{ number_format($charge_exploitation->quantite, 0, ',', ' ') }}"></td>
                                                <td><select class="form-select" id="etat_fonctionnement" name="etat_charge_existe{{ $charge_exs->first()->id_valeur }}[]">
                                                        <option value="">Selectionner l'état</option>
                                                        <option value="neuf" @if($charge_exploitation->etat_fonctionnement == 'neuf') selected @endif>Neuf</option>
                                                        <option value="bon" @if($charge_exploitation->etat_fonctionnement == 'bon') selected @endif>Bon</option>
                                                        <option value="moyen" @if($charge_exploitation->etat_fonctionnement == 'moyen') selected @endif>Moyen</option>
                                                        <option value="mauvais" @if($charge_exploitation->etat_fonctionnement == 'mauvais') selected @endif>Mauvais</option>
                                                    </select></td>
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td><input type="text" class="form-control" name="designation_charge_existe{{ $charge_exs->first()->id_valeur }}[]" placeholder="Désignation"></td>
                                                <td><input type="number" min="0" id="quantite_charge_existe{{ $charge_exs->first()->id_valeur }}" class="form-control" name="quantite_charge_existe{{ $charge_exs->first()->id_valeur }}[]" value="0"></td>
                                                <td><select class="form-select" id="etat_fonctionnement" name="etat_charge_existe{{ $charge_exs->first()->id_valeur }}[]">
                                                        <option value="">Selectionner l'état</option>
                                                        <option value="neuf">Neuf</option>
                                                        <option value="bon">Bon</option>
                                                        <option value="moyen">Moyen</option>
                                                        <option value="mauvais">Mauvais</option>
                                                    </select></td>
                                                <td></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="charge_existe{{ $charge_exs->first()->id_valeur }}" value="{{ $charge_exs->count() }}">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" onclick="addChargeExisteRow({{ $charge_exs->first()->id_valeur }});">Ajouter une ligne</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="my-5"><div class="alert alert-warning w-100">MATIÈRES PREMIÈRES À ACQUÉRIR</div></div>
                            @foreach ($groupedCharge_aqs as $id_valeur => $charge_aqs)
                            <div class="card mt-3">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title">{{ $charge_aqs->first()->valeur_libelle }}</h5>
                                    <small>{{ $charge_aqs->first()->description }}</small>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="charge_acquerir[]" value="{{ $charge_aqs->first()->id_valeur }}">
                                    <table class="table table-bordered" id="chargeAcquerirTable{{ $charge_aqs->first()->id_valeur }}">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 30%;">Désignation</th>
                                                <th scope="col">Unité</th>
                                                <th scope="col">Quantité</th>
                                                <th scope="col">Source d'approvisionnement</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($charge_aqs->first()->id)
                                            @foreach ($charge_aqs as $charge_exploitation)
                                            <tr>
                                                <td><input type="text" class="form-control" name="designation_charge_acquerir{{ $charge_aqs->first()->id_valeur }}[]" placeholder="Désignation" value="{{ $charge_exploitation->designation }}"></td>
                                                <td><input type="text" class="form-control" name="unite_charge_acquerir{{ $charge_aqs->first()->id_valeur }}[]" placeholder="Forfait" value="{{ $charge_exploitation->unite }}"></td>
                                                <td><input type="number" min="0" id="quantite_charge_acquerir{{ $charge_exploitation->id }}" class="form-control" name="quantite_charge_acquerir{{ $charge_aqs->first()->id_valeur }}[]" value="{{ number_format($charge_exploitation->quantite, 0, ',', ' ') }}"></td>
                                                <td><input type="text" id="source_charge_acquerir{{ $charge_exploitation->id }}" class="form-control" name="source_charge_acquerir{{ $charge_aqs->first()->id_valeur }}[]" value="{{ $charge_exploitation->etat_fonctionnement }}" placeholder="Source d'approvisionnement"></td>
                                                <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td><input type="text" class="form-control" name="designation_charge_acquerir{{ $charge_aqs->first()->id_valeur }}[]" placeholder="Désignation"></td>
                                                <td><input type="text" class="form-control" name="unite_charge_acquerir{{ $charge_aqs->first()->id_valeur }}[]" placeholder="Forfait"></td>
                                                <td><input type="number" min="0" id="quantite_charge_acquerir{{ $charge_aqs->first()->id_valeur }}" class="form-control" name="quantite_charge_acquerir{{ $charge_aqs->first()->id_valeur }}[]" value="0"></td>
                                                <td><input type="text" min="0" id="source_charge_acquerir{{ $charge_aqs->first()->id_valeur }}" class="form-control" name="source_charge_acquerir{{ $charge_aqs->first()->id_valeur }}[]" placeholder="Source d'approvisionnement"></td>
                                                <td></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <input type="hidden" id="charge_acquerir{{ $charge_aqs->first()->id_valeur }}" value="{{ $charge_aqs->count() }}">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" onclick="addChargeAcquerirRow({{ $charge_aqs->first()->id_valeur }});">Ajouter une ligne</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="submit" class="btn btn-success mx-1">Enregistrer</button>
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
