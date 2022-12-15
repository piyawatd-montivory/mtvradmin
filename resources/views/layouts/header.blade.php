<header id="header" class="header-fixed">

    <div class="header-bar">
        <div class="container">
            <a href="{{ route('home') }}"><img alt="Header Logo" class="logo" src="{{ asset('/images/frontend/montivory-logo.svg')}}"></a>
            <nav>
                <ul class="menu">
                    <li><a href="{{ route('career') }}">CAREER</a></li>
                    <li><a href="{{ route('blog') }}">READ.MONTIVORY.COM</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="hamburger">
        <div class="menu-icon" onclick="jQuery('#header').toggleClass('open');jQuery('html, body').toggleClass('menu-active')"><span class="navicon"></span></div>
    </div>

</header>
