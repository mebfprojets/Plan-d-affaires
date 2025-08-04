@extends('frontend.layouts.layout')
@section('content')
  <!-- Contact Section -->
  <section id="contact" class="contact section" style="background: #F2F2F2;">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="form py-5" style="background: #FFF; box-shadow: 4px 4px 12px 2px rgba(205, 205, 205, 0.75);">
        <div class="row gy-4">
            <div class="col-lg-4 offset-1">
                <h2>Créer mon compte</h2>
                <p><small>Les champs avec (<span class="text-danger">*</span>) sont obligatoires</small></p>
            </div>
        </div>

        <div class="row gy-4">

        <div class="col-lg-4 offset-1">
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
        <div class="col-lg-6">
          <form action="{{ route('register') }}" method="post" data-aos="fade-up" data-aos-delay="200">
            {{ csrf_field() }}

            <div class="row gy-4">

              <div class="col-lg-6">
                <label class="label" for="first_name">Nom(<span class="text-danger">*</span>)</label>
                <input type="text" name="first_name" class="form-control" placeholder="Nom de famille" required="" value="{{ old('first_name') }}" required>
              </div>

              <div class="col-lg-6 ">
                <label class="label" for="last_name">Prénom</label>
                <input type="text" class="form-control" name="last_name" placeholder="Prénom" required="" value="{{ old('last_name') }}">
              </div>

              <div class="col-lg-12">
                <label class="label" for="password">Email(<span class="text-danger">*</span>)</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required="" value="{{ old('email') }}" required>
              </div>
              <div class="col-lg-12">
                <label class="label" for="password">Mot de passe(<span class="text-danger">*</span>)</label>
                <input type="password" class="form-control" name="password" placeholder="********" required="">
              </div>
              <div class="col-lg-12">
                <label class="label" for="password">Confirmation(<span class="text-danger">*</span>)</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="********" required="">
              </div>

              <div class="col-lg-12">
                <button class="btn btn-success" type="submit">Créer mon compte</button>
              </div>

            </div>
          </form>
        </div><!-- End Contact Form -->

      </div>
      </div>

    </div>

  </section><!-- /Contact Section -->
@endsection
