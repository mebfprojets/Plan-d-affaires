@extends('frontend.layouts.layout')
@section('content')
<!-- h2-slider-area-start -->
<!-- slider-area-start -->
    <div class="h3-slider-area owl-carousel">
       <div class="h3-single-slider ">
            <div class="img">
                <img src="{{ asset('/frontend/assets/img/s1.jpg') }}" alt="">
            </div>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-12 text-left">

                            <p class="text animated d-none d-md-block">Photo de famille.</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="h3-single-slider ">
            <div class="img">
                <img src="{{ asset('/frontend/assets/img/s2.jpg') }}" alt="">
            </div>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-12 text-left">

                            <p class="text animated d-none d-md-block">seance de travail.</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="h3-single-slider ">
            <div class="img">
                <img src="{{ asset('/frontend/assets/img/s3.jpg') }}" alt="">
            </div>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-12 text-left">

                            <p class="text animated d-none d-md-block">Photo de famille</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
 <div class="h2-service-area" style="padding: 0; margin-top: 100px;">
        <div class="container">
            <div class="h2-section-title">
                <h2 class="title"> Les offres de formation du centre</h2>
            </div>
            <div class="justify-content-center">
                <div class="h2-single-service wow fadeInUp" data-wow-delay="100ms" data-wow-duration="1500ms">
                    <div class="content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>CODE</th>
                                    <th>FORMATION</th>
                                    <th>PERIODE</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($formations as $formation)
                                <tr>
                                    <td>{{ $formation->id }}</td>
                                    <td>{{ $formation->shortname }}</td>
                                    <td>{{ $formation->displayname }}</td>
                                    <td></td>
                                    <td>
                                        <a href="{{ route('frontend.formation.inscription', $formation->slug) }}" class="btn-front">S'inscrire</a>
                                        <a href="#" class="btn-front">Voir plus</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- h2-why-area-start -->
    <div class="h2-why-area ">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <img src="{{ asset('frontend/assets/img/formation.png')}}" alt="FORMATION">
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-6 mt-5">
                            <div class="icon-left">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="itm-right">
                                <h4>FORMATION INITIALE</h4>
                                <p class="text">Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre. </p>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-5">
                            <div class="icon-left">
                                <i class="fa fa-suitcase"></i>
                            </div>
                            <div class="itm-right">
                                <h4>FORMATION CONTINUE</h4>
                                <p class="text">Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre. </p>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-5">
                            <div class="icon-left">
                                <i class="fa fa-signal"></i>
                            </div>
                            <div class="itm-right">
                                <h4>FORMATION MODULAIRE QUALIFIANTE</h4>
                                <p class="text">Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre. </p>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-5">
                            <div class="icon-left">
                                <i class="fa fa-graduation-cap"></i>
                            </div>
                            <div class="itm-right">
                                <h4>AUTRES FORMATIONS</h4>
                                <p class="text">Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- h2-why-area-end -->



<!-- h2-portfolio-area-start -->
<div class="h2-portfolio-area">

    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-10 col-12">
                    <div class="h2-section-title" style="margin: 0">
                        <h2 class="title">Documents de référence</h2>
                   </div>


                     <div class="h2-brand-area brand-area">
        <div class="container">
            <div class="brand-carousel owl-carousel" id ="docm">
                <div class="single-brand">
                <a   href="https://volontariat.croix-rouge.bf/storage/users/document/XPKyPnQl7OMo7lotrKHSvzTgiLzsoIOVxK3iQ0In.pdf"  target="_blank">
                    <span> <img src="{{ asset('/frontend/assets/img/charte.PNG') }}" width="120" alt="" /></span>La charte du volontariat
               </a>
                </div>
                <div class="single-brand">
                <a  href="https://volontariat.croix-rouge.bf/storage/users/document/Ms5lZhHQdiERpdWG3S5DeWakQ1ZDpOV0OYhCDUME.pdf"  target="_blank">
                    <span> <img src="{{ asset('/frontend/assets/img/manuev.JPG') }}" width="120" alt="" /></span> Manuel de gestion volontaires
                    </a>
                </div>
                <div  class="single-brand">
                <a href="https://volontariat.croix-rouge.bf/storage/users/document/kpJHdoKEHFWoBnJ8J9goB8HwZfdTOa1TY10NY6vd.pdf"  target="_blank">
                    <span> <img src="{{ asset('/frontend/assets/img/code.PNG') }}" width="120" alt="" /></span>code de conduite du volontaire
                    </a>
                </div>


            </div>
        </div>
    </div>

         </div>


         <div class="col-lg-4  col-12 mliens" >
                    <div class="h2-section-title">
                        <h2 class="title">les liens utiles</h2>
                    </div>
                    <!-- h2-we-area-start -->



                    <div class="h2-we-area">
                        <div class="content">
                             <ul class="list liens">
                                <li><span><i class="fas fa-check-circle"></i></span> <a href="https://www.ifrc.org/">Fédaration internationale de la Croix-rouge</a></li>
                                <li><span><i class="fas fa-check-circle"></i></span><a href="https://www.icrc.org/fr">Comité International Croix-rouge</a></li>
                               <li><span><i class="fas fa-check-circle"></i></span><a href="https://www.croix-rouge.be/"> Croix-rouge de Belgique</a></li>
                                <li><span><i class="fas fa-check-circle"></i></span><a href=https://www.croix-rouge.lu/">Croix-rouge luxembourgeoise</a></li>
                                <li><span><i class="fas fa-check-circle"></i></span> <a href="https://www.croix-rouge.mc/">Croix-rouge monégasque</a></li>
                                <li><span><i class="fas fa-check-circle"></i></span><a href="http://www.cruzroja.es/">Croix-rouge espagnole</a></li>
                            </ul>

                        </div>
                    </div>
                    <!-- h2-we-area-end -->
                </div>

                <div class="col-lg-3 col-md-8 col-sm-10 col-12">
                    <div class="h2-section-title">
                        <h2 class="title">Contact</h2>
                    </div>
                    <!-- h2-we-area-start -->
                    <div class="h2-we-area">
                        <div class="content">
                            <h5 class="intro">Adresse
Ouagadougou - Burkina Faso </h5>
                            <p class="text"><h5 class="intro"><br/><br/>Contacts
</h5>


<br/>

croixrouge.bf@fasonet.bf<br/>
Tél: 00226 25 36 13 40<br/>
Fax: 00226 25 36 31 21 </p>

                        </div>
                    </div>
                    <!-- h2-we-area-end -->
                </div>


        </div>

    </div>
</div>
<!-- h2-portfolio-area-end -->

    <!-- counter-area-start -->
    <div class="counter-area bg-with-black">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
                    <div class="h2-section-title color-white">
                        <h2 class="title">Quelques statistiques</h2>

                    </div>
                </div>
            </div>
            <div class="row justify-content-center">

			<div class="col-lg-3 col-md-3 col-sm-4 col-12">
                    <div class="single-counter wow fadeIn" data-wow-delay="100ms" data-wow-duration="1500ms">
                        <div class="icon">
                            <span class="flaticon-coach"></span>
                        </div>
                        <div class="content">
                            <h2 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30">{{ $stats->nbvolontaire }}</h2>
                            <p class="name">Nombre de volontaires</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-12">
                    <div class="single-counter wow fadeIn" data-wow-delay="100ms" data-wow-duration="1500ms">
                        <div class="icon">
                            <span class="flaticon-chat-1"></span>
                        </div>
                        <div class="content">
                            <h2 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30">{{ $stats->diffuseur }}</h2>
                            <p class="name">nombre de diffuseurs</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-12">
                    <div class="single-counter wow fadeIn" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <div class="icon">
                            <span class="flaticon-newspaper-2"></span>
                        </div>
                        <div class="content">
                            <h2 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30">{{ $stats->secouriste }}</h2>
                            <p class="name">Secouriste</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-12">
                    <div class="single-counter wow fadeIn" data-wow-delay="300ms" data-wow-duration="1500ms">
                        <div class="icon">
                            <span class="flaticon-award"></span>
                        </div>
                        <div class="content">
                            <h2 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30">{{$stats->formasecouriste}}</h2>
                            <p class="name">Formateurs en secouriste</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-12">
                    <div class="single-counter wow fadeIn" data-wow-delay="400ms" data-wow-duration="1500ms">
                        <div class="icon">
                            <span class="flaticon-like-1"></span>
                        </div>
                        <div class="content">
                            <h2 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30">{{$stats->province}}</h2>
                            <p class="name">Comités provinciaux</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
