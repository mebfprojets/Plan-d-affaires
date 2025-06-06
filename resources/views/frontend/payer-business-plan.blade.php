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
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('businessplans.payer', $business_plan->id) }}" method="POST">
                    {{ csrf_field() }}

                <!-- Contenu des onglets -->
                <h5>Paiement de plan d'affaire</h5>
                <div class="container mt-4">
                    <!-- Première carte : Informations personnelles -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary">
                            <h5 class="text-white">Informations sur le paiement</h5>
                        </div>
                        <div class="card-body">

                                <div class="row mb-3">
                                    <label for="numero_paye" class="col-lg-3 col-form-label">Numéro payement</label>
                                    <div class="col-lg-9">
                                        <input type="number" class="form-control" id="numero_paye" name="numero_paye" placeholder="56 00 00 00" value="{{ old('numero_paye') }}">
                                        @error('numero_paye')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="montant_paye" class="col-lg-3 col-form-label">Montant pack</label>
                                    <div class="col-lg-9">
                                        <input type="number" class="form-control" id="montant_paye" disabled placeholder="{{ $business_plan->pack?$business_plan->pack->cout_pack:0 }}" value="{{ $business_plan->pack?$business_plan->pack->cout_pack:0 }}">
                                        <input type="hidden" name="montant_paye" value="{{ $business_plan->pack?$business_plan->pack->cout_pack:0 }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="code_opt_paye" class="col-lg-3 col-form-label">Code OTP</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="code_opt_paye" name="code_opt_paye" placeholder="223 556" value="{{ old('code_opt_paye') }}">
                                        @error('code_opt_paye')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="submit" class="btn btn-success mx-1">Payer</button>
                                </div>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
  </section><!-- /Features Section -->
@endsection
