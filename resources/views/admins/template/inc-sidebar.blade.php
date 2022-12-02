<nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        @if(authuser())
        <div class="nav">
            <a class="nav-link @if (Route::currentRouteName() === 'dashboard') active @endif" href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'categoryindex') active @endif" href="{{ route('categoryindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-newspaper"></i></div>
                Category
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'contentindex') active @endif" href="{{ route('contentindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-newspaper"></i></div>
                Content
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'partnerindex') active @endif" href="{{ route('partnerindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-handshake"></i></div>
                Partner
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'skillindex') active @endif" href="{{ route('skillindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                Skill Interest
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'positionindex') active @endif" href="{{ route('positionindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-check-to-slot"></i></div>
                Position
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'contactindex') active @endif" href="{{ route('contactindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-address-book"></i></div>
                Contact
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'userindex') active @endif" href="{{ route('userindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                User
            </a>
        </div>
        @endif
    </div>
</nav>
