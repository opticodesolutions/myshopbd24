<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <form class="d-none d-sm-inline-block">
        <div class="input-group input-group-navbar">
            <input type="text" class="form-control" placeholder="Search…" aria-label="Search">
            <button class="btn" type="button">
                <i class="align-middle" data-feather="search"></i>
            </button>
        </div>
    </form>



    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
           
            <li class="nav-item">
                <a class="nav-icon js-fullscreen d-none d-lg-block" href="#">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="maximize"></i>
                    </div>
                </a>
            </li>
            <li class="nav-item dropdown">
                    @php
                        $user = Auth::user();
                    @endphp
                     @if($user->profile_picture)
                        <a class="nav-icon pe-md-0 dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <img src="{{ Storage::url($user->profile_picture) }}" class="avatar img-fluid rounded" alt="Charles Hall" />
                        </a>
                    @else
                        <a class="nav-icon pe-md-0 dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <img src="{{ asset('backend/img/avatars/avatar.jpg') }}" class="avatar img-fluid rounded" alt="Charles Hall" />
                        </a>
                    @endif
                <div class="dropdown-menu dropdown-menu-end">
                    <a class='dropdown-item' href='{{ route('user/profile') }}'><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}">Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
