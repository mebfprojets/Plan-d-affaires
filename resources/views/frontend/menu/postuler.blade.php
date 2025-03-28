@extends('frontend.layouts.layout')
@section('postuler', 'active')
@section('content')

  <!-- Features Section -->
  <section id="features" class="features section" style="background-color: #F2F2F2;">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Comment postuler à un plan d'affaire</h2>
      <p>INFORMATIONS A APPORTER POUR LE MONTAGE DE VOTRE PLAN D’AFFAIRES<br></p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <p>Le plan d’affaires vous permet de mettre en forme l’ensemble des données commerciales, techniques et financières de votre projet. Il est un document de communication et de négociation avec vos partenaires techniques, financiers et commerciaux.</p>
        <h3>I.	Présentation du projet</h3>
        <ul>
            <li class="mb-2">Idée de projet : Dire comment est venue l’idée de projet et en quoi consiste le projet ?</li>
            <li class="mb-2">Objectifs du projet : Formuler des objectifs mesurables et réalisables pour votre future entreprise, quelles sont les cibles à atteindre, les résultats à obtenir ?</li>
            <li>Calendrier des réalisations : Décrivez ce qui a déjà été réalisé, ce qui est en cours et ce qui est à venir (Exemple : élaboration du plan d’affaires, mobilisation du financement, construction et aménagement, achat des équipements, négociation avec les fournisseurs, élaboration du plan de communication, recrutement du personnel, démarrage de la production, ouverture officielle).</li>
        </ul>
        <table class="table table-bordered table-responsive">
            <tr>
                <td>N°</td>
                <td>Étapes des activités</td>
                <td>Dates indicatives</td>
            </tr>
            @for($i=1;$i<=6;$i++)
            <tr>
                <td>{{ $i }}.</td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </table>
        <h3>II.	Présentation du promoteur et de l’entreprise</h3>
        <ul>
            <li class="mb-2">Le (s) promoteur(s) : Nom et prénoms, Age, Sexe, Situation de famille, Domicile, Adresse, Niveau de formation, Expérience dans le secteur d’activités, Activité actuelle, Motivations pour la création, Garantie, aval ou caution à présenter
                <b>Nom et prénoms : </b><br/>
                <b>Âge : </b><br/>
                <b>Sexe : </b><br/>
                <b>Situation de famille : </b><br/>
                <b>Domicile : </b><br/>
                <b>Adresse : </b><br/>
                <b>Niveau de formation : </b><br/>
                <b>Expérience dans le secteur d’activités : </b><br/>
                <b>Activité actuelle : </b><br/>
                <b>Motivation pour la création : </b><br/>
                <b>Garantie, aval ou caution à présenter : </b><br/>
                </li>
            <li class="mb-2">Objectifs du projet : Formuler des objectifs mesurables et réalisables pour votre future entreprise, quelles sont les cibles à atteindre, les résultats à obtenir ?</li>
            <li>Calendrier des réalisations : Décrivez ce qui a déjà été réalisé, ce qui est en cours et ce qui est à venir (Exemple : élaboration du plan d’affaires, mobilisation du financement, construction et aménagement, achat des équipements, négociation avec les fournisseurs, élaboration du plan de communication, recrutement du personnel, démarrage de la production, ouverture officielle).</li>
        </ul>
    </div>

  </section><!-- /Features Section -->
@endsection
