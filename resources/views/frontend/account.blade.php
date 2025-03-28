@extends('frontend.layouts.layout')
@section('content')
  <!-- Contact Section -->
  <section id="contact" class="contact section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row gy-4">

        <div class="col-lg-4 offset-2">
            <img class="h-100" src="{{ asset('frontend/assets/img/pa1.png') }}" alt="">
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-lg-4">
          <form action="{{ route('register') }}" method="post" data-aos="fade-up" data-aos-delay="200">
            {{ csrf_field() }}

            <div class="row gy-4">

              <div class="col-lg-6">
                <label class="label" for="first_name">Nom</label>
                <input type="text" name="first_name" class="form-control" placeholder="Nom de famille" required="" value="{{ old('first_name') }}">
              </div>

              <div class="col-lg-6 ">
                <label class="label" for="last_name">Prénom</label>
                <input type="text" class="form-control" name="last_name" placeholder="Prénom" required="" value="{{ old('last_name') }}">
              </div>

              <div class="col-lg-12">
                <label class="label" for="password">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required="" value="{{ old('email') }}">
              </div>
              <div class="col-lg-12">
                <label class="label" for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" placeholder="********" required="">
              </div>
              <div class="col-lg-12">
                <label class="label" for="password">Confirmation</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="********" required="">
              </div>

              <div class="col-lg-12">
                <button class="btn btn-success" type="submit">Créer un compte</button>
              </div>

            </div>
          </form>
        </div><!-- End Contact Form -->

      </div>

    </div>

  </section><!-- /Contact Section -->
@endsection
