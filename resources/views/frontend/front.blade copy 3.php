@extends('frontend.layouts.layout')
@section('content')
@section('accueil', 'active')

<!-- Hero Section -->
<section id="hero" class="hero section dark-background">

    <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

      <div class="carousel-item active">
        <img src="{{ asset('/frontend/assets/img/bp/1.png') }}" alt="">
        <div class="carousel-container">
          <h2>La Maison de l'Entreprise du Burkina-Faso (MEBF)<br></h2>
          <a href="#services" class="btn-get-started">Initier un plan d'affaire</a>
        </div>
      </div><!-- End Carousel Item -->

      <div class="carousel-item">
        <img src="{{ asset('/frontend/assets/img/bp/3.png') }}" alt="">
        <div class="carousel-container">
          <h2>La Maison de l'Entreprise du Burkina-Faso (MEBF)<br></h2>
          <a href="#services" class="btn-get-started">Initier un plan d'affaire</a>
        </div>
      </div><!-- End Carousel Item -->

      <div class="carousel-item">
        <img src="{{ asset('/frontend/assets/img/bp/5.png') }}" alt="">
        <div class="carousel-container">
          <h2>La Maison de l'Entreprise du Burkina-Faso (MEBF)<br></h2>
          <a href="#services" class="btn-get-started">Initier un plan d'affaire</a>
        </div>
      </div><!-- End Carousel Item -->

      <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

      <ol class="carousel-indicators"></ol>

    </div>

  </section><!-- /Hero Section -->

  <!-- Services Section -->
  <section id="services" class="services section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>SERVICES OFFERTS</h2>
        <p>NOS PACKS DE PLAN D'AFFAIRES<br></p>
        <p style="font-size: 1rem; text-transform: initial;">Vous aviez besoin de monter un plan d'affaire? Nos packs sont là pour vous accompagner!</p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="row gy-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item d-flex position-relative h-100" style="box-shadow: none; border: 0; background: linear-gradient(aliceblue, antiquewhite); border-radius: 50px 0 0 50px;">
                <i class="bi bi-briefcase icon flex-shrink-0"></i>
                <div>
                    <h4 class="title"><a href="#" class="stretched-link">LE <span class="text-uppercase">{{ $pack_first->libelle }}</span></a></h4>
                    <p class="description">{{ Str::limit($pack_first->description, 100) }}</p>
                </div>
            </div>
        </div><!-- End Service Item -->

        <div class="col-md-8" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
                @foreach($packs as $pack)
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item d-flex position-relative mb-3">
                        <i class="bi bi-card-checklist icon flex-shrink-0"></i>
                        <div class="item">
                          <h4 class="title"><a href="{{ route('packs.service', $pack->slug) }}" class="stretched-link">LE <span class="text-uppercase">{{ $pack->libelle }}</span></a></h4>
                          <div class="description">{{ Str::limit($pack->description, 100) }}</div>
                        </div>
                      </div>
                </div>
                @endforeach
            </div>
        </div>
      </div>
    </div>
  </section><!-- /Services Section -->

  <!-- About 2 Section -->
  <section id="about-2" class="about-2 section">

    <div class="container" data-aos="fade-up">

      <div class="row g-4 g-lg-5" data-aos="fade-up" data-aos-delay="200">

        <div class="col-lg-5">
          <div class="about-img">
            <img src="{{ asset('/frontend/assets/img/pa.png') }}" class="img-fluid" alt="">
          </div>
        </div>

        <div class="col-lg-7">
          <h3 class="pt-0 pt-lg-5">En savoir plus sur nos packs et leurs tarifications selon vos objectifs.</h3>

          <!-- Tabs -->
          <ul class="nav nav-pills mb-3">
            <li><a class="nav-link active" data-bs-toggle="pill" href="#pack-tab"><span class="text-uppercase">{{ $pack_first->libelle  }}</span></a></li>
            @foreach($packs as $key=>$pack)
            <li><a class="nav-link" data-bs-toggle="pill" href="#pack-tab{{ $key }}"><span class="text-uppercase">{{ $pack->libelle  }}</span></a></li>
            @endforeach
          </ul><!-- End Tabs -->

          <!-- Tab Content -->
          <div class="tab-content">

            <div class="tab-pane fade show active" id="pack-tab">

                <p class="fst-italic">{{ $pack_first->description }}</p>
                <span class="price">{{ $pack_first->cout_pack }} <sup>F CFA</sup></span>
                @foreach($pack_first->objectifs as $pack_first_obj)
                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>{{ $pack_first_obj->libelle }}</h4>
                </div>
                @endforeach


            </div><!-- End Tab 1 Content -->
            @foreach($packs as $key=>$pack)
            <div class="tab-pane fade" id="pack-tab{{ $key }}">

                <p class="fst-italic">{{ $pack->description }}</p>
                <span class="price">{{ $pack->cout_pack }}<sup>F CFA</sup></span>
                @foreach($pack->objectifs as $pack_obj)
                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>{{ $pack_obj->libelle }}</h4>
                </div>
                @endforeach
            </div><!-- End Tab 2 Content -->
            @endforeach
          </div>

        </div>

      </div>

    </div>

  </section><!-- /About 2 Section -->

  <!-- About Section -->
  <section id="about" class="about section pt-3">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up" style="padding-bottom: 10px;">
      <p class="text-black">Les objectifs visés<br></p>
    </div><!-- End Section Title -->

    <div class="container">

      <div class="row gy-4">

        <div class="col-lg-12 content" data-aos="fade-up" data-aos-delay="100">
          <p class="text-black" style="line-height: 2rem;">
            Face à la problématique de l’accès au financement
            des PME, la Maison de l’Entreprise du
            Burkina Faso (MEBF) a mis en place le Service de
            Facilitation du Financement des entreprises
            Le SEFAFI est un modèle d’accompagnement
            (SEFAFI).<br/>
            adapté, prenant en compte les contraintes et
            spécificités des PME et les exigences des institutions
            de financement en matière de formulation
            de projets bancables et d’accompagnement à la
            mise en oeuvre.
          </p>
          <ul class="text-black">
            <li><i class="bi bi-check2-circle"></i> <span>Augmenter le taux d’acceptation du financement
                des PME auprès des institutions de
                financement ;</span></li>
            <li><i class="bi bi-check2-circle"></i> <span>Promouvoir la bancarisation des entreprises,
                notamment des PME ;</span></li>
            <li><i class="bi bi-check2-circle"></i> <span>Permettre aux entreprises d’avoir des
                relations d’affaires durables avec les structures
                de financement ;</span></li>
            <li><i class="bi bi-check2-circle"></i> <span>Assurer le suivi post financement des projets
                d’entreprise ;</span></li>
            <li><i class="bi bi-check2-circle"></i> <span>Renforcer les relations de partenariats entre
                les institutions de financement et la MEBF.</span></li>
          </ul>
        </div>

      </div>

    </div>

  </section><!-- /About Section -->
  <!-- About Section -->
  <section id="look" class="about section">
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <p style="color: #fff;">Qui est notre cible?<br></p>
  </div><!-- End Section Title -->

  <div class="container" style="background-color: white;">

    <div class="row gy-4">

      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
        <ul>
            <li><i class="bi bi-check2-circle"></i> <span>Créateurs d’entreprises ;</span></li>
            <li><i class="bi bi-check2-circle"></i> <span>Petites et moyennes entreprises en développement;</span></li>
            <li><i class="bi bi-check2-circle"></i> <span>Bénéficiaires des projets gérés par la MEBF;</span></li>
            <li><i class="bi bi-check2-circle"></i> <span>Associations et groupements professionnels.</span></li>
        </ul>
      </div>
      <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
        <img src="{{ asset('/frontend/assets/img/pa1.png') }}" alt="">
      </div>

    </div>

  </div>

</section><!-- /About Section -->

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

<!-- Clients Section -->
<section id="clients" class="clients section light-background">

    <div class="container" data-aos="fade-up">

      <div class="row gy-4">

        <div class="col-xl-3 col-md-3 col-6 client-logo">
          <img src="{{ asset('/frontend/assets/img/ba.png') }}" class="img-fluid" alt="">
        </div><!-- End Client Item -->

        <div class="col-xl-3 col-md-3 col-6 client-logo">
          <img src="{{ asset('/frontend/assets/img/orabank.png') }}" class="img-fluid" alt="">
        </div><!-- End Client Item -->

        <div class="col-xl-3 col-md-3 col-6 client-logo">
          <img src="{{ asset('/frontend/assets/img/boa.png') }}" class="img-fluid" alt="">
        </div><!-- End Client Item -->

        <div class="col-xl-3 col-md-3 col-6 client-logo">
          <img src="{{ asset('/frontend/assets/img/rcpb.png') }}" class="img-fluid" alt="">
        </div><!-- End Client Item -->

      </div>

    </div>

</section><!-- /Clients Section -->

@endsection
