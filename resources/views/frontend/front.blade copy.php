@extends('frontend.layouts.layout')
@section('content')
<!-- Hero Section -->
<section id="hero" class="hero section dark-background">

    <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

      <div class="carousel-item active">
        <div class="carousel-container">
          <h2>La maison de l'entreprise du Burkina-Faso<br></h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
      </div><!-- End Carousel Item -->

      <div class="carousel-item">
        <img src="{{ asset('/frontend/assets/img/hero-carousel/hero-carousel-2.jpg') }}" alt="">
        <div class="carousel-container">
          <h2>At vero eos et accusamus</h2>
          <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut.</p>
          <a href="#featured-services" class="btn-get-started">Get Started</a>
        </div>
      </div><!-- End Carousel Item -->

      <div class="carousel-item">
        <img src="{{ asset('/frontend/assets/img/hero-carousel/hero-carousel-3.jpg') }}" alt="">
        <div class="carousel-container">
          <h2>Temporibus autem quibusdam</h2>
          <p>Beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt omnis iste natus error sit voluptatem accusantium.</p>
          <a href="#featured-services" class="btn-get-started">Get Started</a>
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
                    <h4 class="title"><a href="{{ route('packs.service', {{ $pack_first->slug }}) }}" class="stretched-link">LE <span class="text-uppercase">{{ $pack_first->libelle }}</span></a></h4>
                    <p class="description">Ce pack concerne les promoteurs disposant
                        déjà d’un plan d’affaires bien structuré et
                        actualisé et à la recherche...</p>
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
                          <h4 class="title"><a href="{{ route('packs.service', 'pack_diamant') }}" class="stretched-link">LE PACK DIAMANT</a></h4>
                          <div class="description">Ce pack concerne les promoteurs disposant
                            déjà d’un plan d’affaires bien structuré et
                            actualisé et à la recherche...</div>
                        </div>
                      </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="service-item d-flex position-relative mb-3">
            <i class="bi bi-card-checklist icon flex-shrink-0"></i>
            <div class="item">
              <h4 class="title"><a href="{{ route('packs.service', 'pack_diamant') }}" class="stretched-link">LE PACK DIAMANT</a></h4>
              <div class="description">Ce pack concerne les promoteurs disposant
                déjà d’un plan d’affaires bien structuré et
                actualisé et à la recherche...</div>
            </div>
          </div>
          <div class="service-item d-flex position-relative">
            <i class="bi bi-card-checklist icon flex-shrink-0"></i>
            <div class="item">
              <h4 class="title"><a href="{{ route('packs.service', 'pack_or') }}" class="stretched-link">LE PACK OR</a></h4>
              <p class="description">Ce pack concerne les promoteurs disposant
                déjà d’un plan d’affaires bien structuré et
                actualisé et à la recherche...</p>
            </div>
          </div>
        </div><!-- End Service Item -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item d-flex position-relative mb-3">
              <i class="bi bi-bar-chart icon flex-shrink-0"></i>
              <div class="item">
                <h4 class="title"><a href="{{ route('packs.service', 'pack_argent') }}" class="stretched-link">LE PACK ARGENT</a></h4>
                <p class="description">Ce pack concerne les promoteurs disposant
                    d’un financement et souhaitant un appui
                    pour le suivi et le renforcement...</p>
              </div>
            </div>
            <div class="service-item d-flex position-relative">
              <i class="bi bi-binoculars icon flex-shrink-0"></i>
              <div class="item">
                <h4 class="title"><a href="{{ route('packs.service', 'pack_bronze') }}" class="stretched-link">LE PACK BRONZE</a></h4>
                <p class="description">Ce pack concerne les promoteurs disposant
                    déjà d’un financement et souhaitant disposer
                    d’un plan d’affaires...</p>
              </div>
            </div>
          </div><!-- End Service Item -->


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
            <li><a class="nav-link active" data-bs-toggle="pill" href="#about-2-tab1">Start</a></li>
            <li><a class="nav-link" data-bs-toggle="pill" href="#about-2-tab2">Diamant</a></li>
            <li><a class="nav-link" data-bs-toggle="pill" href="#about-2-tab3">Or</a></li>
            <li><a class="nav-link" data-bs-toggle="pill" href="#about-2-tab4">Argent</a></li>
            <li><a class="nav-link" data-bs-toggle="pill" href="#about-2-tab5">Bronze</a></li>
          </ul><!-- End Tabs -->

          <!-- Tab Content -->
          <div class="tab-content">

            <div class="tab-pane fade show active" id="about-2-tab1">

                <p class="fst-italic">Ce pack concerne les promoteurs disposant déjà d’un plan d’affaires bien structuré et actualisé et à la recherche d’un financement.</p>
                <span class="price">550 000 <sup>F CFA</sup></span>
                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Appui à l’élaboration de de demande de financement</h4>
                </div>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Introduction de la fiche de pré-projet remplie auprès des banques partenaires</h4>
                </div>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Suivi de l’obtention de l’avis des banques partenaires.</h4>
                </div>


            </div><!-- End Tab 1 Content -->

            <div class="tab-pane fade" id="about-2-tab2">

                <p class="fst-italic">Ce pack concerne les promoteurs disposant déjà d’un plan d’affaires bien structuré et actualisé et à la recherche d’un financement.</p>
                <span class="price">450 000<sup>F CFA</sup></span>
                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Appui au montage du plan d’affaires ;</h4>
                </div>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Appui à l’élaboration de la demande de
                    crédit ;</h4>
                </div>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Coaching bancaire (formation sur la défense de projets et appui à la recherche de financement) ;</h4>
                </div>
                <div class="d-flex align-items-center mt-4">
                    <i class="bi bi-check2"></i>
                    <h4>Appui à la gestion des procédures administratives pour le déblocage du financement ;</h4>
                  </div>
                  <div class="d-flex align-items-center mt-4">
                    <i class="bi bi-check2"></i>
                    <h4>Formation en gestion ;</h4>
                  </div>
                  <div class="d-flex align-items-center mt-4">
                    <i class="bi bi-check2"></i>
                    <h4>Suivi post financement sur 12 mois.</h4>
                  </div>

            </div><!-- End Tab 2 Content -->

            <div class="tab-pane fade" id="about-2-tab3">

                <p class="fst-italic">Ce pack concerne les promoteurs disposant déjà d’un plan d’affaires bien structuré et actualisé et à la recherche d’un financement.</p>
                <span class="price">300 000<sup>F CFA</sup></span>
                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Appui à l’élaboration de la demande de crédit ;</h4>
                </div>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Coaching bancaire;</h4>
                </div>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Appui à la gestion des procédures administratives pour le déblocage du financement ;</h4>
                </div>
                <div class="d-flex align-items-center mt-4">
                    <i class="bi bi-check2"></i>
                    <h4>Formation en gestion ;</h4>
                </div>
                <div class="d-flex align-items-center mt-4">
                <i class="bi bi-check2"></i>
                <h4>Suivi post financement sur 12 mois.</h4>
                </div>

            </div><!-- End Tab 3 Content -->

            <div class="tab-pane fade" id="about-2-tab4">
                <p class="fst-italic">Ce pack concerne les promoteurs disposant d’un financement et souhaitant un appui pour le suivi et le renforcement de capacités de gestion.</p>
                <span class="price">150 000<sup>F CFA</sup></span>
                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Formation en gestion ;</h4>
                </div>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Suivi post financement sur 12 mois.</h4>
                </div>

              </div><!-- End Tab 4 Content -->


              <div class="tab-pane fade" id="about-2-tab5">
                <p class="fst-italic">déjà d’un financement et souhaitant disposer d’un plan d’affaires pour la mise en oeuvre de leur projet et d’un suivi.</p>
                <span class="price">GRATUIT<sup>F CFA</sup></span>
                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Appui au montage de plan d’affaires (autre motif que la recherche de financement);</h4>
                </div>

                <div class="d-flex align-items-center mt-4">
                  <i class="bi bi-check2"></i>
                  <h4>Suivi post financement sur 6 mois.</h4>
                </div>

              </div><!-- End Tab 5 Content -->

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
          <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">

              <div class="col-md-6">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
              </div>

              <div class="col-md-6 ">
                <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
              </div>

              <div class="col-md-12">
                <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
              </div>

              <div class="col-md-12">
                <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
              </div>

              <div class="col-md-12">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>

                <button type="submit" class="btn btn-success rounded submit px-3">Envoyer</button>
              </div>

            </div>
          </form>
        </div><!-- End Contact Form -->

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
