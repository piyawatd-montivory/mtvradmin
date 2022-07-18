<nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link @if (Route::currentRouteName() === 'dashboard') active @endif" href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
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
            <a class="nav-link @if (Route::currentRouteName() === 'montivoryindex') active @endif" href="{{ route('montivoryindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-people-group"></i></div>
                Team Montivory
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'contactindex') active @endif" href="{{ route('contactindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-address-book"></i></div>
                Contact
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'userindex') active @endif" href="{{ route('userindex')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                User
            </a>
            <div class="sb-sidenav-menu-heading">File Manager</div>
            <a class="nav-link @if (Route::currentRouteName() === 'manageimages') active @endif" href="{{ route('manageimages')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-image"></i></div>
                Images
            </a>
            <a class="nav-link @if (Route::currentRouteName() === 'managefiles') active @endif" href="{{ route('managefiles')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-file"></i></div>
                Files
            </a>
            {{-- <a class="nav-link @if (Route::currentRouteName() === 'productindex') active @endif" href="{{ route('productindex') }}">
                <div class="sb-nav-link-icon"><i class="fa-brands fa-product-hunt"></i></div>
                Product
            </a> --}}
            {{-- <div class="sb-sidenav-menu-heading">Interface</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Layouts
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Pages
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                        Authentication
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="login.html">Login</a>
                            <a class="nav-link" href="register.html">Register</a>
                            <a class="nav-link" href="password.html">Forgot Password</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                        Error
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="401.html">401 Page</a>
                            <a class="nav-link" href="404.html">404 Page</a>
                            <a class="nav-link" href="500.html">500 Page</a>
                        </nav>
                    </div>
                </nav>
            </div>
            <div class="sb-sidenav-menu-heading">Addons</div>
            <a class="nav-link" href="charts.html">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Charts
            </a>
            <a class="nav-link" href="tables.html">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Tables
            </a> --}}
        </div>
    </div>
    {{-- <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        Start Bootstrap
    </div> --}}
</nav>
