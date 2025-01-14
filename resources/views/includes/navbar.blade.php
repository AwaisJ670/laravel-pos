
 <nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <div class="nav-link" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" style="cursor: pointer">
                <div class="user-panel d-flex align-items-center">
                    <div class="text-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                    <div class="image">
                        <img src="{{ asset('images/user-placeholder.png') }}" class="img-circle" alt="User Image">
                    </div>
                </div>
            </div>
            <div class="dropdown-menu user-panel-dropdown">
                <a href="{{ route('user-profile') }}" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
                @if( Auth::user()->role_id == 1 )
                <a href="{{ route('change-password') }}" class="dropdown-item">
                    <i class="fas fa-key mr-2"></i> Change Password
                </a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <div class="dropdown-divider"></div>
            </div>
        </li>
    </ul>
</nav>

