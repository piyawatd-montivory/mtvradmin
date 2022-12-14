<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img alt="Header Logo" class="logo" src="{{ asset('/images/frontend/montivory-logo.svg')}}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-nav ms-auto">
                <a class="nav-link" aria-current="page" href="{{ route('career') }}">CAREER</a>
                <a class="nav-link active" aria-current="blog" href="{{ route('blog') }}">READ.MONTIVORY.COM</a>
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid px-0 navbar-second">
    <div class="row">
        <div class="col-md-12 d-none d-md-block navbar-second-item px-0 justify-content-center">
            <ul class="px-0 mx-auto my-0">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="#">BINARY.CRAFT</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">BUSINESS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">CREATIVE</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link">DATA AND TECH</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">PRIVACY</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">RESEARCH</a>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn mt-2">
                        <img src="{{asset('images/icon/Search-icon-w.png')}}" class="w-75"/>
                    </button>
                </li>
            </ul>
        </div>
        <div class="col-10 d-md-none navbar-second-item">
            <ul class="my-0">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="#">BINARY.CRAFT</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">BUSINESS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">CREATIVE</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link">DATA AND TECH</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">PRIVACY</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">RESEARCH</a>
                </li>
            </ul>
        </div>
        <div class="col-2 d-md-none px-0 mobile-search-block py-2 text-center">
            <button type="button" class="btn btn-search px-0">
                <img src="{{asset('images/icon/Search-icon-w.png')}}" class="w-75 px-1"/>
            </button>
        </div>
    </div>
</div>
