@extends('frontend.layouts.layout')
@section('content')
<!-- Page Title -->
<div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">DÉTAILS DU PLAN D'AFFAIRE </h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('frontend.home') }}">Accueil</a></li>
          <li class="current">Détails de plan d'affaire</li>
        </ol>
      </nav>
    </div>
</div><!-- End Page Title -->
  <!-- Features Section -->
  <section id="features" class="section" style="padding: 30px 0 0 0;">
    <div class="container" data-aos="fade-up" data-aos-delay="100" style="padding-bottom: 30px; color: #000;">
        <div class="row">
            <div class="col-lg-10 offset-1">
                <div class="model px-5" style="box-shadow: 2px 2px 5px 1px #999; padding: 1rem; height: 70rem;">
                    <div class="model-title text-center" style="border-bottom: 3px solid #060607FF; width: 50%; margin: 20px auto;">
                        <p>Entreprise <strong>{{ $business_plan->entreprise->denomination }}</strong></p>
                            <p>11 BP:…………..</p>
                            <p>Tel: ………….</p>
                            <p>E-mail:</p>
                    </div>
                    <div class="text-center py-5">
                        <img src="{{ asset('logo.png') }}" alt="IMAGE ILLUSTRATIVE" height="200">
                    </div>

                    <div class="model-title text-center py-3 fs-2 mx-3" style="border: 5px solid #060607FF;">
                        <p>{{ $business_plan->business_idea }}</p>
                        <p>Localité: {{ $business_plan->entreprise->localisation }}</p>
                    </div>
                    <div class="text-center" style="width: 50%; margin: 20px auto;">
                        <p class="fw-bold text-danger my-5">Plan d’affaires</p>
                        <p><i>Elaboré dans le cadre du Programme d’appui à la Compétitivité de l’Afrique de l’Ouest - volet Burkina Faso (PACAO-BF), financé par l’Union européenne et la Chambre de Commerce et d’Industrie du Burkina Faso (CCI-BF)</i></p>
                    </div>
                </div>
                <!-- PRESENTATION -->
                <div class="model px-5 my-3" style="box-shadow: 2px 2px 5px 1px #999; padding: 1rem; height: 70rem;">
                    <div><strong>PRESENTATION DU PROJET</strong></div>
                    <div class="my-3">
                        <strong>Idée du projet</strong>
                        <p class="my-3">{{ $business_plan->business_idea }}</p>
                    </div>
                    <div class="my-5">
                        <strong>Objectifs du projet</strong>
                        <p class="my-3">{{ $business_plan->business_object }}</p>
                    </div>
                    <div class="my-5">
                        <strong>Calendrier des réalisations</strong>
                        <table class="table table-responsive table-bordered my-3">
                            <tr>
                                <th>N°</th>
                                <th>Étapes des activités</th>
                                <th>Dates indicatives</th>
                            </tr>
                            @foreach ($business_plan->activities as $key=>$business_plan_planning)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $business_plan_planning->step_activity }}</td>
                                    <td>{{ $business_plan_planning->date_indicative }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section><!-- /Features Section -->
@endsection
