@extends('frontend.layouts.layout')
@section('projets', 'active')
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
                    <p class="description">{{ $plan_affaires? $plan_affaires->count():0 }} Plan d'affaires</p>
                    <p class="description"><a href="{{ route('profile.update') }}" class="btn btn-success btn-sm">Modifier</a></p>
                </div>

            </div>
        </div><!-- End Service Item -->


        <div class="col-md-8" data-aos="fade-up" data-aos-delay="100">
            @if($plan_affaires->count()>0)
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Idée</th>
                        <th>Objectif</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plan_affaires as $key=>$plan_affaire)
                    @php
                        $label = '';
                        if($plan_affaire->statut == env('initie')){
                            $label = 'danger';
                        }else if($plan_affaire->statut == env('impute')){
                            $label = 'wargning';
                        }else if($plan_affaire->statut == env('valide')){
                            $label = 'primary';
                        }else if($plan_affaire->statut == env('paye')){
                            $label = 'info';
                        }else if($plan_affaire->statut == env('cloture')){
                            $label = 'success';
                        }

                    @endphp
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $plan_affaire->business_idea }}</td>
                        <td>{{ $plan_affaire->business_object }}</td>
                        <td>@if($plan_affaire->statut != '')<span class="label label-{{ $label }}">{{ $plan_affaire->statut }}</span>@endif
                        </td>
                        <td>
                            @if(!$plan_affaire->is_valide)
                            <a href="{{ route('businessplans.edit', $plan_affaire->id) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-square"></i></a>
                            @endif
                            @if($plan_affaire->is_valide && !$plan_affaire->is_paye)
                            <a href="{{ route('businessplans.payer', $plan_affaire->id) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-currency-dollar"></i>Payer</a>
                            @endif
                            @if(!$plan_affaire->date_valide)
                            <a href="#" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i></a>
                            @endif

                            <a href="#" download="{{ asset($plan_affaire->url_file) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-download"></i></a>

                            <a href="{{ route('businessplans.details', $plan_affaire->id) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="service-item d-flex position-relative h-100" style="box-shadow: none; border: 0; background: #F2F2F2">
                <i class="bi bi-person-circle icon flex-shrink-0"></i>
                <div>
                    <h4 class="title">Vous n'aviez pas encore créeé un plan d'affaire!</h4>

                    <p class="description"><a href="{{ route('frontend.home') }}#services" class="btn btn-success btn-sm">Créer un plan d'affaire</a></p>
                </div>

            </div>
            @endif
        </div>
      </div>
    </div>
  </section><!-- /Services Section -->
@endsection
