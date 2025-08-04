@extends('frontend.layouts.layout')
@section('nos-packs', 'active')
@section('content')

<!-- Pricing Section -->
<section id="pricing" class="pricing section">
    <!-- Section Title -->
    <div class="container section-title pb-2" data-aos="fade-up">
        <h2>SERVICES OFFERTS ET TARIFICATION</h2>
        <p>LES PLANS D'AFFAIRES<br></p>
      </div><!-- End Section Title -->
    <div class="container">
        <p>Le plan d’affaires vous permet de mettre en forme l’ensemble des données commerciales, techniques et financières de votre projet. Il est un document de communication et de négociation avec vos partenaires techniques, financiers et commerciaux.
            Vous avons donc organisé nos plans d'affaires par packs en fonction de vos besoins.
        </p>
      <div class="row gy-3">
        @foreach ($packs as $pack)


        <div class="col-xl-3 col-lg-6" data-aos="fade-up" data-aos-delay="100">
          <div class="pricing-item featured">



            <h3>{{ $pack->libelle }}</h3>
            <h4>{{ $pack->cout_pack }}<sup>F CFA</sup></h4>
            <ul>
                @foreach($pack->objectifs as $pack_first_obj)
                    <li>{{ $pack_first_obj->libelle }}</li>
                @endforeach
            </ul>
            <div class="btn-wrap">
              <a href="{{ $pack->slug == 'pack_start'? '#': route('packs.service', $pack->slug) }}" class="btn-buy">Démarrer</a>
            </div>
          </div>
        </div><!-- End Pricing Item -->
        @endforeach
      </div>

    </div>
  </section><!-- /Pricing Section -->
@endsection
