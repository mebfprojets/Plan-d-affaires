<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="index.html">
                <!-- Logo icon --><b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="{{ asset('/logo.png') }}" alt="homepage" class="dark-logo" style="height: 2.5rem;" />
                    <!-- Light Logo icon -->
                    <span>MEBF - PLANS AFF</span>
                </b>
                <!--End Logo icon -->
                </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto mt-md-0">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <!-- ============================================================== -->
                <!-- Messages -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                        @if(get_contacts()->count()>0)
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        @endif
                    </a>
                    <div class="dropdown-menu mailbox animated slideInUp" aria-labelledby="2">
                        <ul>
                            <li>
                                <div class="drop-title">Vous aviez des messages</div>
                            </li>
                            @if(get_contacts()->count()>0)
                            <li>
                                <div class="message-center">
                                    @foreach (get_contacts() as $contact)
                                    <!-- Message -->
                                    <a href="{{ route('contacts.show', $contact->id) }}">
                                        <div class="user-img"> <img src="{{ asset('/backend/assets/images/users/1.jpg') }}" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>{{ $contact->name }}</h5> <span class="mail-desc">{{ $contact->subject }}</span> <span class="time">{{ $contact->created_at }}</span> </div>
                                    </a>
                                    @endforeach
                                    <!-- Message -->
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center" href="javascript:void(0);"> <strong>Tous les messages</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                            @else
                            <li>
                                <div class="drop-title"><small>Vous n'aviez pas de messages</small></div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Messages -->
                <!-- ============================================================== -->
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('//backend/assets/images/users/1.jpg') }}" alt="user" class="profile-pic" /></a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="{{ asset('/backend/assets/images/users/1.jpg') }}" alt="user"></div>
                                    <div class="u-text">
                                        @if(Auth::user())
                                            <h4>{{ Auth::user()->name }}</h4>
                                            <p class="text-muted">{{ Auth::user()->email }}</p><a href="pages-profile.html" class="btn btn-rounded btn-danger btn-sm">Voir Profile</a></div>
                                        @endif
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="ti-user"></i> Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('password.change') }}"><i class="ti-settings"></i> Changer mot de passe</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Se déconnecter</a>
                                <form id="logout-form" method="post" action="{{ route('admin.logout') }}" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>

                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
