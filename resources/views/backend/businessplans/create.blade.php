@extends('backend.layouts.layout')
@section('plans', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Plans d'affaire</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('businessplans.index') }}">Plans d'affaire</a></li>
            <li class="breadcrumb-item active">Créer</li>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title float-left">Plans d'affaire</h4>
                    <form action="{{ route('businessplans.store') }}" method="POST">
                        @csrf
                        <label for="project_name">Nom du Projet</label>
                        <input type="text" name="project_name" required>

                        <label for="executive_summary">Résumé Exécutif</label>
                        <textarea name="executive_summary" required></textarea>

                        <label for="market_analysis">Analyse du Marché</label>
                        <textarea name="market_analysis" required></textarea>

                        <label for="marketing_strategy">Stratégie Marketing</label>
                        <textarea name="marketing_strategy" required></textarea>

                        <label for="operations_plan">Plan Opérationnel</label>
                        <textarea name="operations_plan" required></textarea>

                        <label for="financial_plan">Plan Financier</label>
                        <textarea name="financial_plan" required></textarea>

                        <button type="submit">Générer le Plan</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
@endsection
