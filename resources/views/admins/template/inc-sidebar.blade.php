<nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        @if(authuser())
        <div class="nav">
            <a class="nav-link @if (Route::currentRouteName() === 'dashboard') active @endif" href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'contentindex') active @endif" href="{{ route('contentindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-newspaper"></i></div>
                Content
            </a>
            @if(authuser()->role == 'editor')
                <a class="nav-link @if (Route::currentRouteName() === 'categoryindex') active @endif" href="{{ route('categoryindex')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-newspaper"></i></div>
                    Category
                </a>
                <a class="nav-link @if (Route::currentRouteName() === 'pagecontentindex') active @endif" href="{{ route('pagecontentindex')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-newspaper"></i></div>
                    Page Content
                </a>
                <a class="nav-link @if (Route::currentRouteName() === 'imagesindex') active @endif" href="{{ route('imagesindex')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-image"></i></div>
                    Images
                </a>
                <a class="nav-link @if (Route::currentRouteName() === 'tagsindex') active @endif" href="{{ route('tagsindex')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-tags"></i></div>
                    Tags
                </a>
            @endif
            @if(authuser()->role == 'admin')
                <a class="nav-link @if (Route::currentRouteName() === 'categoryindex') active @endif" href="{{ route('categoryindex')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-newspaper"></i></div>
                    Category
                </a>
                <a class="nav-link @if (Route::currentRouteName() === 'pagecontentindex') active @endif" href="{{ route('pagecontentindex')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-newspaper"></i></div>
                    Page Content
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
                {{-- <a class="nav-link @if (Route::currentRouteName() !== 'contactindex') collapsed @endif" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Contact
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse @if (Route::currentRouteName() === 'contactindex') show @endif" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-static.html">Sales</a>
                        <a class="nav-link" href="layout-sidenav-light.html">Partner</a>
                        <a class="nav-link" href="layout-sidenav-light.html">Job</a>
                    </nav>
                </div> --}}
                <a class="nav-link @if (Route::currentRouteName() === 'userindex') active @endif" href="{{ route('userindex')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                    User
                </a>
                <hr class="sidebar-divider"/>
                <a class="nav-link" href="{{ route('cachedata') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-gears"></i></div>
                    Cache Data
                </a>
            @endif
        </div>
        @endif
    </div>
</nav>
