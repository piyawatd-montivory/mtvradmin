<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admins - @yield('title')</title>
        @include('admins.template.inc-stylesheet')
        <link rel="icon" href="{{ asset('images/logo.png')}}" type="image/icon type">
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        @yield('stylesheet')
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="#">Montivory</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    {{-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button> --}}
                </div>
            </form>
            <!-- Navbar-->
            @if(Auth::check())
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->email }}<i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{route('profile')}}">Profile</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            {{-- <a class="dropdown-item" href="#!">Logout</a> --}}
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{route('logout')}}"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    Logout</a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @endif
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                @include('admins.template.inc-sidebar')
            </div>
            <div id="layoutSidenav_content">
                <main>
                    @if ($message = Session::get('success'))
                        <div class="container-fluid mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-success" role="alert">
                                        {{ $message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @yield('content')
                </main>
                @include('admins.template.inc-footer')
            </div>
        </div>
        @include('admins.template.inc-javascript')
        @yield('script')
    </body>
</html>
