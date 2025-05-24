@extends('frontend.layouts.layout')

@section('content')
<!-- Services Section -->
  <section id="services" class="services section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>PROFIL PROMOTEUR</h2>
        <p>MES PLAN D'AFFAIRES<br></p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="row gy-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item d-flex position-relative h-100" style="box-shadow: none; border: 0; background: linear-gradient(aliceblue, antiquewhite); border-radius: 50px 0 0 50px;">
                <i class="bi bi-person-circle icon flex-shrink-0"></i>
                <div>
                    <h4 class="title"><a href="#" class="stretched-link">{{ Auth::user()->name }} <span class="text-uppercase"></span></a></h4>
                    <p class="description">{{ Auth::user()->email }}</p>
                    <p class="description">{{ Auth::user()->contact?Auth::user()->contact:'Pas de contact' }}</p>
                    <p class="description">{{ Auth::user()->nombrePA? Auth::user()->nombrePA:0 }} Plan d'affaires</p>
                    <p class="description"><a href="{{ route('profile.update') }}" class="btn btn-success btn-sm">Modifier</a></p>
                </div>

            </div>
        </div><!-- End Service Item -->

        <div class="col-md-8" data-aos="fade-up" data-aos-delay="100">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Idée</th>
                        <th>Objectif</th>
                        <th>Statut</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plan_affaires as $plan_affaire)
                    <tr>
                        <td>{{ $plan_affaire->business_idea }}</td>
                        <td>{{ $plan_affaire->business_object }}</td>
                        <td>Statut</td>
                        <td>
                            <a href="{{ route('businessplans.edit', $plan_affaire->id) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </section><!-- /Services Section -->
@endsection
