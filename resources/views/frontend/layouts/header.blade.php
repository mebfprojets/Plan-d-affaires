<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ route('frontend.home') }}" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('/logo.png') }}" alt="">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero">Qui sommes nous?</a></li>
          <li><a href="{{ route('frontend.menu', 'comment-postuler') }}" class="@yield('postuler')">Comment postuler?</a></li>
          <li><a href="about.html">Besoin de conseils?</a></li>
          <li><a href="services.html">Nos Formations</a></li>
          <li><a href="{{ route('frontend.menu', 'nos-packs') }}" class="@yield('packs')">Nos packs</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <form action="" style="margin-left: 2rem;">
        <div class="input-group" style="width: 8rem;">
            <input type="text" class="form-control" placeholder="Rechercher..." style="border-right: 0; border-color: #0b0b0b;font-size: 0.8rem;border-radius: 4px 0 0 4px;">
            <span class="input-group-text bg-white border-start-0" style="border: 1px solid #0b0b0b; border-radius: 0 4px 4px 0;">
                <i class="bi bi-search"></i>
            </span>
        </div>
      </form>
      @if(!Auth::check())
        <a class="btn-getstarted" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right mr-1"></i> Se connecter</a>
        <a class="btn-getstarted" href="{{ route('frontend.account') }}"><i class="bi bi-person-fill"></i> Créer un compte</a>
      @else
        <div class="dropdown mx-2">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i>
            </a>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li class="dropdown-header">
                    <p class="mb-0">{{ Auth::user()->name }}</p>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Profil</a></li>
                <li><a class="dropdown-item" href="#">Paramètres</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Déconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
      @endif

    </div>
  </header>
