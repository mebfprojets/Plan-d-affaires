@extends('frontend.layouts.layout')
@section('nous-contacter', 'active')
@section('content')

  <!-- Features Section -->
  <section id="features" class="features section" style="background-color: #F2F2F2;">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up" style="padding-bottom: 0;">
      <h2>Vous pouvez nous écrire pour demander des informations et faire des suggestions afin qu'on puisse nous améliorer.</h2>
      <p>NOUS CONTACTER<br></p>
    </div><!-- End Section Title -->

  </section><!-- /Features Section -->

  <!-- Contact Section -->
<section id="contact" class="contact section">
    <div class="container section-title" data-aos="fade-up">
        <p class="text-black">Besoin de contact?<br></p>
      </div><!-- End Section Title -->
      <hr>
    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row gy-4">

        <div class="col-lg-4">
          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-geo-alt flex-shrink-0"></i>
            <div>
              <h3>Adresse</h3>
              <p>132, Avenue de Lyon ,11 BP
                379 OUAGADOUGOU 11, BURKINA FASO</p>
            </div>
          </div><!-- End Info Item -->

          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
            <i class="bi bi-telephone flex-shrink-0"></i>
            <div>
              <h3>Tél.</h3>
              <p>(+226) 25 39 58 12</p>
            </div>
          </div><!-- End Info Item -->

          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
            <i class="bi bi-envelope flex-shrink-0"></i>
            <div>
              <h3>Email</h3>
              <p>info@me.bf</p>
            </div>
          </div><!-- End Info Item -->

        </div>

        <div class="col-lg-8">
          <form action="{{ route('contacts.store') }}" method="post">
            {{ csrf_field() }}
            <div class="row gy-4">

              <div class="col-md-6">
                <input type="text" name="name" class="form-control" placeholder="Nom & Prénom" required="">
              </div>

              <div class="col-md-6 ">
                <input type="email" class="form-control" name="email" placeholder="Votre Email" required="">
              </div>

              <div class="col-md-12">
                <input type="text" class="form-control" name="subject" placeholder="Objet" required="">
              </div>

              <div class="col-md-12">
                <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
              </div>

              <div class="col-md-12">
                <button type="submit" class="btn btn-success rounded submit px-3">Envoyer</button>
              </div>

            </div>
          </form>
        </div><!-- End Contact Form -->
      </div>
    </div>
</section>
@endsection
