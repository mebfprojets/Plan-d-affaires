@extends('backend.layouts.layout')
@section('contacts', 'active')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Messages des internautes</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('contacts.index') }}">Messages</a></li>
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
                    <div class="d-flex m-b-40">
                        <div>
                            <a href="javascript:void(0)"><img src="{{ asset('/backend/assets/images/users/1.jpg')  }}" alt="user" width="40" class="img-circle" /></a>
                        </div>
                        <div class="p-l-10">
                            <h4 class="m-b-0">{{ $contact->name }}</h4>
                            <small class="text-muted">De: {{ $contact->email }}</small>
                            <small class="text-muted">Date: {{ $contact->created_at }}</small>
                        </div>
                    </div>
                    <p><div style="font-weight: bold;">{{ $contact->subject }}</div></p>
                    <hr>
                    <p>{{ $contact->message }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
@endsection
