<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider" style="margin-top: 0;"></li>
                <li class="nav-small-cap">APPLICATION</li>
                <li> <a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-gauge"></i>Dashboard </a></li>
                @can('packs.index')
                <li class="@yield('plans')"><a class="@yield('packs')" href="{{ route('packs.index') }}"><i class="mdi mdi-bullseye"></i>Packs</a></li>
                @endcan
                @can('businessplans.index')
                <li class="@yield('plans')"> <a class="@yield('plans')" href="{{ route('businessplans.index') }}"><i class="mdi mdi-book-open"></i>Plans d'affaire</a></li>
                @endcan
                @can('messages.send')
                <li> <a href="{{ route('chat.index') }}"><i class="mdi mdi-email"></i>Messages</a></li>
                @endcan
                @can('promoteurs.view')
                <li> <a href="{{ route('entreprises.index') }}"><i class="mdi mdi-account"></i>Entrepreneurs </a></li>
                @endcan
                @can('entreprises.view')
                <li> <a href="{{ route('promoteurs.index') }}"><i class="mdi mdi-group"></i>Promoteurs </a></li>
                @endcan
                @can('statistique.view')
                <li> <a href="#"><i class="mdi mdi-database"></i>Visualisation </a></li>
                @endcan
                <li class="nav-devider"></li>
                <li class="nav-small-cap">ADMINISTRATION</li>
                @can('roles.index')
                <li class="@yield('roles')"> <a class="@yield('roles')" href="{{ route('roles.index') }}"><i class="mdi mdi-marker-check"></i>Rôles</a></li>
                @endcan
                @can('admins.index')
                <li class="@yield('admins')"> <a class="@yield('admins')" href="{{ route('admins.index') }}"><i class="mdi mdi-account-multiple"></i>Utilisateurs</a></li>
                @endcan
                @can('permissions.index')
                <li> <a href="{{ route('permissions.index') }}"><i class="mdi mdi-tune-vertical"></i>Permissions</a></li>
                @endcan
                @can('parametres.index')
                <li> <a href="{{ route('parametres.index') }}"><i class="mdi mdi-wrench"></i>Paramètres</a></li>
                @endcan
                @can('valeurs.index')
                <li> <a href="{{ route('valeurs.index') }}"><i class="mdi mdi-settings"></i>Valeurs</a></li>
                @endcan
                @can('monitoring.pulse')
                <li> <a href="/pulse" target="_blank"><i class="mdi mdi-laptop-mac"></i>Monitoring</a></li>
                @endcan
                @can('monitoring.logs')
                <li> <a href="/logs" target="_blank"><i class="mdi mdi-server"></i>Logs</a></li>
                @endcan
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
