@extends('frontend.layouts.layout')
@section('content')
  <!-- Contact Section -->
  <section id="contact" class="contact section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row gy-4">

        <div class="col-lg-4 offset-2 text-right">
            <img class="h-100" src="{{ asset('frontend/assets/img/pa1.png') }}" alt="">
        </div>

        <div class="col-lg-4">
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
                <input type="text" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
            </div>
            <div class="form-group">
                <button type="submit" class="form-control btn btn-success rounded submit px-3">Se connecter</button>
            </div>
            <div class="form-group d-md-flex mt-3">
                <div class="w-50 text-left">
                    <p><small>Êtes vous nouveau? <a data-toggle="tab" href="#signup">Inscription</a></small></p>
                </div>
                <div class="w-50 text-md-right">
                    <a href="#"><small>Mot de passe oublié?</small></a>
                </div>
            </div>
          </form>
        </div><!-- End Contact Form -->

      </div>

    </div>

  </section><!-- /Contact Section -->
@endsection
