@extends('frontend.layouts.layout')
@section('content')
  <!-- Contact Section -->
  <section id="contact" class="contact section" style="background: #F2F2F2;">

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="form py-5" style="background: #FFF; box-shadow: 4px 4px 12px 2px rgba(205, 205, 205, 0.75);">
            <div class="row gy-4">

        <div class="col-lg-4 offset-2 text-right">
            <img class="h-100" src="{{ asset('frontend/assets/img/pa1.png') }}" alt="">
        </div>

        <div class="col-lg-4">
            <div>Connectez-vous pour créer un plan d'affaire</div>
            <hr>
          <form action="{{ route('login') }}" method="post" data-aos="fade-up" data-aos-delay="200">
            {{ csrf_field() }}
            @if ($errors->any())
            <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group mb-3">
                <label class="label" for="first_name">Votre email(<span class="text-danger">*</span>)</label>
                <input type="text" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group mb-3">
                <label class="label" for="first_name">Mot de passe(<span class="text-danger">*</span>)</label>
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
            </div>
            <div class="form-group">
                <button type="submit" class="form-control btn btn-success rounded submit px-3">Se connecter</button>
            </div>
            <div class="form-group d-md-flex mt-3">
                <div class="w-50 text-left">
                    <p><small>Êtes vous nouveau? <a href="{{ route('frontend.account') }}">Inscription</a></small></p>
                </div>
                <div class="w-50 text-md-right">
                    <a href="{{ route('password.forget') }}"><small>Mot de passe oublié?</small></a>
                </div>
            </div>
          </form>
        </div><!-- End Contact Form -->

      </div>
        </div>
    </div>

  </section><!-- /Contact Section -->
@endsection
