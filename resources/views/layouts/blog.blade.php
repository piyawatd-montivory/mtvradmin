<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>@yield('title')</title>

    @yield('meta')

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('/images/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{ asset('/images/favicon/safari-pinned-tab.svg')}}" color="#182b45">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    @include('layouts.stylesheet-blog')
    @yield('stylesheet')
</head>
<body>
    <!-- Header -->
    @include('layouts.header-blog')
    <main>
    <!-- Content -->
    @yield('content')
    </main>
    <!-- Modal Search -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true" data-bs-backdrop="false">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body px-0 py-0">
                    <div class="container-fluid navbar-second">
                        <div class="row justify-content-center">
                            <div class="col-md-7 col-12">
                                <form id="searchform">
                                    <div class="input-group mt-3 bg-white custom-search">
                                        <span class="input-group-text" id="icon-search">
                                            <img src="{{asset('images/icon/search.png')}}" class="icon-search"/>
                                        </span>
                                        <input type="text" class="form-control form-control-search" id="search" name="search" aria-label="Search" placeholder="ค้นหา...">
                                        <button class="btn btn-close btn-close-icon" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer-blog')
    <!-- Plugin Script -->
    @include('layouts.javascript-blog')
    @yield('script')
    <script>
        // var myModal = new bootstrap.Modal(document.getElementById('searchModal'), {})
        // myModal.show()
        $(function(){
            $('#searchform').submit(function(){
                window.location.href = "/search/"+$('#search').val().trim();
                return false;
            })
        })
    </script>
</body>
</html>
