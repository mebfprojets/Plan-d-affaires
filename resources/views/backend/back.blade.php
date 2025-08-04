@extends('backend.layouts.layout')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="container-fluid">

    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <!-- Row -->
                    <div class="row">
                        <div class="col-8"><h2><span id="total_prom">...</span> <i class="ti-user font-14 text-danger"></i></h2>
                            <h6>Promoteurs</h6></div>
                        <div class="col-4 align-self-center text-right  p-l-0">
                            <div id="sparklinedash3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <!-- Row -->
                    <div class="row">
                        <div class="col-8"><h2 class=""><span id="total_en">...</span> <i class="ti-home font-14 text-success"></i></h2>
                            <h6>Entreprises</h6></div>
                        <div class="col-4 align-self-center text-right p-l-0">
                            <div id="sparklinedash"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <!-- Row -->
                    <div class="row">
                        <div class="col-8"><h2><span id="total_pa">...</span> <i class="ti-book font-14 text-success"></i></h2>
                            <h6>Plan d'affaires</h6></div>
                        <div class="col-4 align-self-center text-right p-l-0">
                            <div id="sparklinedash2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <!-- Row -->
                    <div class="row">
                        <div class="col-8"><h2><span id="total_pay">...</span> <i class="ti-money font-14 text-danger"></i></h2>
                            <h6>Total payé (FCFA)</h6></div>
                        <div class="col-4 align-self-center text-right p-l-0">
                            <div id="sparklinedash4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row -->
    <div class="row">
        <div class="col-lg-8 col-md-7">
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-actions">
                        <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                        <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                        <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                    </div>
                    <h4 class="card-title m-b-0">Les cinq derniers PA</h4>
                </div>
                <div class="card-body collapse show">
                    <div class="table-responsive">
                        <table class="table product-overview">
                            <thead>
                                <tr>
                                    <th>Pack</th>
                                    <th>Entreprise</th>
                                    <th>Idée du projet</th>
                                    <th>Date soumission</th>
                                    <th>Région</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plan_affaires as $plan_affaire)
                                <tr>
                                    <td>{{ $plan_affaire->pack->libelle }}</td>
                                    <td>{{ $plan_affaire->entreprise?$plan_affaire->entreprise->denomination:'' }}</td>
                                    <td style="white-space: pre-line;">{!! nl2br(e(Str::limit($plan_affaire->business_idea, 50))) !!}</td>
                                    <td>{{ $plan_affaire->created_at }}</td>
                                    <td>{{ $plan_affaire->entreprise?($plan_affaire->entreprise->region?$plan_affaire->entreprise->region->libelle:''):'' }}</td>
                                    <td>
                                        @can('businessplans.editer')
                                        <a href="{{ route('business_plans.edit', $plan_affaire->id) }}" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Modifier"><i class="ti-marker-alt"></i></a>
                                        <a href="{{ route('businessplans.show', $plan_affaire->id) }}" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Voir détails"><i class="ti-eye"></i></a>
                                    </td>
                                        @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-5">
            <!-- Column -->
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-actions">
                        <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                        <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                        <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                    </div>
                    <h4 class="card-title m-b-0">Status PA</h4>
                </div>
                <div class="card-body collapse show">
                    <ul class="list-inline m-t-20 text-center">
                    <li >
                        <h6 class="text-muted"><i class="fa fa-circle text-info"></i> Inscrits</h65>
                        <h4 class="m-b-0" id="total_ins">...</h4>
                    </li>
                    <li>
                        <h6 class="text-muted"><i class="fa fa-circle text-danger"></i> Non payé</h6>
                        <h4 class="m-b-0" id="nombre_np">...</h4>
                    </li>
                    <li>
                        <h6 class="text-muted"> <i class="fa fa-circle text-success"></i> Terminé</h6>
                        <h4 class="m-b-0" id="nombre_val">...</h4>
                    </li>
                </ul>

                </div>
            </div>
            <!-- Column -->
            <div class="card card-default">
                <div class="card-header">
                    <div class="card-actions">
                        <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                        <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                        <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
                    </div>
                    <h4 class="card-title m-b-0">Offer for you</h4>
                </div>
                <div class="card-body collapse show bg-info">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Carousel items -->
                        <div class="carousel-inner">
                            <div class="carousel-item flex-column">
                                <i class="fa fa-shopping-cart fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white font-light">Now Get <span class="font-bold">50% Off</span><br>
                          on buy</h3>
                                <div class="text-white m-t-20">
                                    <i>- Ecommerce site</i>
                                </div>
                            </div>
                            <div class="carousel-item flex-column">
                                <i class="fa fa-shopping-cart fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white font-light">Now Get <span class="font-bold">50% Off</span><br>
                          on buy</h3>
                                <div class="text-white m-t-20">
                                    <i>- Ecommerce site</i>
                                </div>
                            </div>
                            <div class="carousel-item flex-column active">
                                <i class="fa fa-shopping-cart fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white font-light">Now Get <span class="font-bold">50% Off</span><br>
                          on buy</h3>
                                <div class="text-white m-t-20">
                                    <i>- Ecommerce site</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
@endsection
