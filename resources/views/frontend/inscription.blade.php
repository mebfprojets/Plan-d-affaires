@extends('frontend.layouts.layout')
@section('postuler', 'active')
@section('content')
<!-- Page Title -->
<div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Création de de plan d'affaire </h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Accueil</a></li>
          <li class="current">Les packs de plan d'affaire</li>
        </ol>
      </nav>
    </div>
</div><!-- End Page Title -->
  <!-- Features Section -->
  <section id="features" class="features section" style="padding: 30px 0 0 0;">

    <div class="container" data-aos="fade-up" data-aos-delay="100" style="padding-bottom: 30px;">

        <small>
        <div class="row">
            <div class="col-lg-3 h-100" style="background: linear-gradient(#bab6b6, #aad03d, #fdfdfd);">
                <h5 class="sidbar-title">Pack choisi</h5>
                <p><small><strong>{{ $pack->libelle }}</strong></small></p>
                <p><strong>{{ $pack->cout_pack }} FCFA</strong></p>
                <p><strong>Ce que vous bénéficiez!</strong></p>
                    <ul>
                        <li>Appui à l’élaboration de de demande de financement</li>
                        <li>Introduction de la fiche de pré-projet remplie auprès des banques partenaires</li>
                        <li>Suivi de l’obtention de l’avis des banques partenaires.</li>
                    </ul>
                    <hr>
                <h5 class="sidbar-title">Autres packs</h5>
                <div class="col-lg-12 content" data-aos="fade-up" data-aos-delay="100">
                <ul class="text-black">
                    @foreach($packs as $pack_other)
                    <li>
                        <i class="bi bi-check2-circle"></i> <a href="{{ route('packs.service', $pack_other->slug) }}"><span>{{ $pack_other->libelle }}</span></a>
                    </li>
                    @endforeach
                </ul>
                </div>
                <div class="text-center">
                    <img src="{{ asset('frontend/assets/img/service.png') }}" height="300" alt="">
                </div>


            </div>
            <div class="col-lg-9">
                <h5 class="text-black fw-bold fs-2 mb-3">Création de de plan d'affaire</h5>
                <p>Le plan d’affaires vous permet de mettre en forme l’ensemble des données commerciales, techniques et financières de votre projet. Il est un document de communication et de négociation avec vos partenaires techniques, financiers et commerciaux.</p>

                <p>Afin de nous permettre de monter soigneusement votre plan d’affaires, veuillez apporter les réponses aux questions suivantes :</p>

                <h5 class="my-3 fs-2">Présentation du projet</h5>
                <form action="{{ route('businessplans.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_pack" value="{{ $pack->id }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="business_idea" class="fw-bold">Idée de projet</label>
                                <p>Dire comment est venue l’idée de projet et en quoi consiste le projet ?</p>
                                <textarea name="business_idea" id="business_idea" rows="6" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mt-5">
                                <label for="business_object" class="fw-bold">Objectifs du projet  :</label>
                                <p>Formuler des objectifs mesurables et réalisables pour votre future entreprise, quelles sont les cibles à atteindre, les résultats à obtenir ?</p>
                                <textarea name="business_object" id="business_object" rows="6" class="form-control"></textarea>
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td><input type="text" name="etapes_activites[]" class="form-control" placeholder="Etape de l'activité"></td>
                                    <td><input type="date" name="dates_indicatives[]" class="form-control"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </form>
            </div>
        </div>
    </small>


    </div>
  </section><!-- /Features Section -->
@endsection
