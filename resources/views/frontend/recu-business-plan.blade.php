@extends('frontend.layouts.layout')
@section('content')
<!-- Page Title -->
<div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">REÇU DE PAIMENT DE PLAN D'AFFAIRE </h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('frontend.home') }}">Accueil</a></li>
          <li class="current">Reçu de paiement de plan d'affaire</li>
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
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="text-center py-5">
                                <img src="{{ asset('logo.png') }}" alt="IMAGE ILLUSTRATIVE" height="150">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="model-title text-center" style="border-bottom: 3px solid #060607FF; width: 50%; margin: 20px auto; font-size: 0.8rem !important;">
                                <p><strong>CENTRE DE FORMALITES DES ENTREPRISES DU BURKINA FASO (CEFORE)</strong></p>
                                <p>132 Avenue du Lyon</p>
                                <p>Tel: (00226) 25 39 80 60/61 Fax: (0026) 25 39 80 62</p>
                                <p>E-mail: info@mebf.bf Site web: www.mebf.bf</p>
                            </div>
                            <div class="flot-right" style="width: 5rem; border-bottom: 1px dotted #ccc;">
                                Reçu
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            @if($business_plan->entreprise)
                            <table class="table">
                                <tr><th>Reçu N°:</th><td>{{ date('Y') }}-{{ $business_plan->entreprise->id>=100?$business_plan->entreprise->id:'0'.$business_plan->entreprise->id }}</td></tr>
                                <tr><th>Date de comptabilisation:</th><td>{{ date('d/m/Y') }}</td></tr>
                                <tr><th>Référence client:</th><td>{{ date('Y') }}-{{ $business_plan->entreprise->id }}</td></tr>
                                <tr><th>Nom commerciale:</th><td>{{ $business_plan->entreprise->denomination }}</td></tr>
                                <tr><th>Adresse:</th><td>{{ $business_plan->entreprise->adresse_entreprise }}</td></tr>
                                <tr><th>Téléphone:</th><td>{{ $business_plan->entreprise->tel_entreprise }}</td></tr>
                            </table>
                            @else
                            <div class="alert alert-danger">Vous n'aviez pas encore renseigner les informations sur l'entreprise</div>
                            @endif
                            <div style="background: #d5d4d4; padding: 0.5rem 1rem; margin-top: 2rem; width: 50%;">Montant total : {{ $business_plan->pack->cout_pack }}</div>
                        </div>
                    </div>

                    <div class="p-3 mt-5" style="border: 1px solid #ddd;">
                        <h5 class="fw-bold" style="text-transform: uppercase; font-size: 0.8rem;">Pour les formalités suivantes</h5>
                        <p><small><i>Elaboration de plan d'affaire pour le promoteur <strong>{{ $promoteur->nom_promoteur.' '.$promoteur->prenom_promoteur }}</strong></i></small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section><!-- /Features Section -->
@endsection
