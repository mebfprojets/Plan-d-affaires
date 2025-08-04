<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ route('frontend.home') }}" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('/logo.png') }}" alt="">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('frontend.home') }}" class="@yield('accueil')">Accueil</a></li>
          <li><a href="{{ route('frontend.menu', 'a-propos') }}" class="@yield('a-propos')">A propos</a></li>
          <li><a href="{{ route('frontend.menu', 'nos-packs') }}" class="@yield('nos-packs')">Pas de paquet</a></li>
          <li><a href="{{ route('frontend.menu', 'elaborer-pa') }}" class="@yield('elaborer-pa')">Élaborer mon PA </a></li>
          <li><a href="{{ route('frontend.menu', 'nous-contacter') }}" class="@yield('nous-contacter')">Nous contacter</a></li>
          @if(Auth::check())
          <li><a href="{{ route('profile.edit') }}" class="@yield('projets')">Mes plans d'affaires </a></li>
          @endif
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
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mes plans d'affaires</a></li>
                <li><a class="dropdown-item" href="{{ route('password.changes') }}">Changement de mot de passe</a></li>
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
