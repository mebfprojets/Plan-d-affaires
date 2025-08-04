@extends('frontend.layouts.layout')
@section('a-propos', 'active')
@section('content')
    <style>
        .main{
            background: #e8e8e8;
        }
    </style>
    <div class="container" style="background: #e8e8e8;">
      <div class="row">

        <div class="col-lg-8">

          <!-- Blog Details Section -->
          <section id="blog-details" class="blog-details section" style="background: #e8e8e8;">
            <div class="container">

              <article class="article">

                <div class="post-img">
                  <img src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">
                </div>

                <h2 class="title">Comment créer un plan d'affaire?</h2>
                <p>La mise en place d'un d'affaires par un promoteur suit plusieurs étapes de traitements</p>

                <div class="meta-top">
                  <ul class="arrow-list">
                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-details.html">Initiation</a></li>
                    <li class="d-flex align-items-center"><i class="bi bi-person-plus-fill"></i> <a href="blog-details.html"><time datetime="2020-01-01">Imputation</time></a></li>
                    <li class="d-flex align-items-center"><i class="bi bi-check-circle-fill"></i> <a href="blog-details.html">Validation</a></li>
                    <li class="d-flex align-items-center"><i class="bi bi-currency-dollar"></i> <a href="blog-details.html">Paiement</a></li>
                    <li class="d-flex align-items-center"><i class="bi bi-file-word"></i> <a href="blog-details.html">Génération</a></li>
                    <li class="d-flex align-items-center"><i class="bi bi-download"></i> <a href="blog-details.html">Importation</a></li>
                  </ul>
                </div><!-- End meta top -->

                <div class="content">
                    <h3><span>1.</span> L'étape d'initiation</h3>
                    <p>
                        C'est toute premiere étape entierement destinée aux promoteurs qui désirent mettre en place un plan d'affaires grace à l'appui de
                        la Maison de l'Entreprise du Burkina-Faso (MEBF). Elle consiste à donner l'idée du projet, les objectifs ainsi que les étapes claires de mise en oeuvre.
                        Une fois ces informations fournies, le promoteur est invité à remplir toutes les informations du formulaire qui lui sera présenté.
                        <p><strong class="text-black">PRE REQUIS</strong></p>
                        <ul>
                            <li>Création de compte ou connexion à son espace</li>
                        </ul>
                    </p>

                  <h3><span>2.</span> L'étape d'impution</h3>
                  <p>
                    L'impution consiste à l'attribution du projet de création de plan d'affaire à un conseiller dédié chargé du montage du projet.
                    Le conseiller a pour rôle de s'assurer que les informations saisies par le promoteur sont correctes. Il est le guide du promoteur pour
                    la saisie des informations dans le formulaire en procedant à la correction des données saisies et au calcul des differents montants.
                  </p>

                  <h3><span>3.</span> L'étape de validation</h3>
                  <p>
                    La validation est une tâche reservée au conseiller chargé du montage du projet. C'est une étape importante car une fois que le formulaire est validé
                    aucune modification ne sera possible encore. Le conseiller validera d'un commun accord les informations du formulaire avec le promoteur avant la validation finale dans l'application.
                  </p>

                  <h3><span>4.</span> L'étape de paiement</h3>
                  <p>
                   Cette étape est dediée au promoteur. Il consiste à effectuer le paiment du montant du montage selon le pack qui a été choisi. Le paiement se fait en mobile
                   a travers l'espace de paiement qui sera visible uniquement par les promoteurs.
                   <p><strong class="text-black">Les moyens de paiement</strong></p>
                    <ul>
                        <li>Ligdicash</li>
                        <li>Orange Money</li>
                        <li>Moov Money</li>
                    </ul>
                  </p>

                  <h3><span>5.</span> L'étape de génération</h3>
                  <p>
                   C'est l'avant dernière étape qui consiste à la génération du plan d'affaires par le conseiller. C'est un fichier qui contient une ébauche de
                   plan d'affaires. Il sera complété avec les inputs du promoteur. C'est le document final qui servira du plan d'affaires monté pour le promoteur.
                  </p>

                  <h3><span>6.</span> L'étape d'importation</h3>
                  <p>
                   L'importation consiste à scanner la version finale du document généré et signé et le chargé dans l'application. Une fois chargé ce document sera visible et téléchargeable
                   par le promoteur.
                  </p>
                  <blockquote>
                    <p>
                      NB: Le promoteur pourra suivre l'évolution du traitement de son dossier à travers le changement du statut dans la rubrique <b>Mes plans d'affaires</b>.
                    </p>
                  </blockquote>

                </div><!-- End post content -->

                <div class="meta-bottom">
                  <i class="bi bi-envelope"></i>
                  <ul class="cats">
                    <li><a href="#">infos@me.bf</a></li>
                  </ul>

                  <i class="bi bi-phone"></i>
                  <ul class="cats">
                    <li><a href="#">(+226) 25 39 58 12</a></li>
                  </ul>
                  <i class="bi bi-whatsapp"></i>
                  <ul class="cats">
                    <li><a href="#">(+226) 25 39 80 62</a></li>
                  </ul>
                </div><!-- End meta bottom -->

              </article>

            </div>
          </section><!-- /Blog Details Section -->



        </div>

        <div class="col-lg-4 sidebar">

          <div class="widgets-container">

            <!-- Search Widget -->
            <div class="search-widget widget-item">

              <h3 class="widget-title">A propos</h3>
              <p>Cette plateforme a mise en place pour permettre aux promoteurs désirant mettre place en place un plan d'affaires avec l'accompagment de la
                Maison de l'Entreprise du Burkina-Faso. Elle est d'une initiation des autorisées avec l'application de la politique nationale sur le numérique comme levier du devloppement.
              </p>

            </div><!--/Search Widget -->
            <hr>
            <!-- Categories Widget -->
            <div class="categories-widget widget-item">

              <h3 class="widget-title">Cibles</h3>
              <ul>
                <li><i class="bi bi-check2-circle"></i> <span>Créateurs d’entreprises ;</span></li>
                <li><i class="bi bi-check2-circle"></i> <span>Petites et moyennes entreprises en développement;</span></li>
                <li><i class="bi bi-check2-circle"></i> <span>Bénéficiaires des projets gérés par la MEBF;</span></li>
                <li><i class="bi bi-check2-circle"></i> <span>Associations et groupements professionnels.</span></li>
              </ul>

            </div><!--/Categories Widget -->
            <hr>
            <!-- Recent Posts Widget -->
            <div class="recent-posts-widget widget-item">

              <h3 class="widget-title">Les packs disponibles</h3>

              <div class="post-item">
                <div>
                  <h4><a href="blog-details.html">{{ $pack_first->libelle }}</a>(<span>{{ $pack_first->cout_pack }} F CFA</span>)</h4>
                  <span style="color: color-mix(in srgb, var(--default-color), transparent 50%); font-size: 13px;">{{ Str::limit($pack_first->description, 50) }}</span>
                </div>
              </div><!-- End recent post item-->
              @foreach ($packs as $pack)
                  <div class="post-item">

                    <div>
                        <h4><a href="blog-details.html">{{ $pack->libelle }}</a>(<span>{{ $pack->cout_pack }} F CFA</span>)</h4>
                        <span style="color: color-mix(in srgb, var(--default-color), transparent 50%); font-size: 13px;">{{ Str::limit($pack->description, 50) }}</span>
                    </div>
                </div><!-- End recent post item-->
              @endforeach
            </div><!--/Recent Posts Widget -->

          </div>

        </div>

      </div>
    </div>
@endsection
