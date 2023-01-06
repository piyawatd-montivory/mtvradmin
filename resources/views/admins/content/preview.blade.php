<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Montivory : {{$data->title}}</title>

    <meta property="og:title" content="{{$data->ogtitle}}">
    <meta property="og:description" content="{{$data->ogdescription}}">
    <meta property="og:image" content="{{$data->ogimage}}">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="" />
    <meta property="fb:pages" content="">
    <meta property="fb:app_id" content="">
    <meta property="twitter:image" content="{{$data->ogimage}}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('/images/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{ asset('/images/favicon/safari-pinned-tab.svg')}}" color="#182b45">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}" type="text/css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('/css/blog.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('/css/blogpost.css')}}" type="text/css">
</head>
<body>
    <!-- Header -->
    @include('layouts.header-blog')
    <main>
    <!-- Content -->
    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-12">
                    <h3 class="content-detail-title mt-3">{{$data->title}}</h3>
                    <div class="row pt-3">
                        <div class="col-12 col-md-6">
                            <p>Published:01 Dec 2022</p>
                        </div>
                        <div class="col-12 col-md-6 text-md-end">
                            <p>Share
                                <a href="#" class="social-link px-2"><img src="{{ asset('images/icon/facebook-b.png')}}"/></a>
                                <a href="#" class="social-link px-2"><img src="{{ asset('images/icon/twitter-b.png')}}"/></a>
                                <a href="#" class="social-link px-2"><img src="{{ asset('images/icon/instagram-b.png')}}"/></a>
                                <a href="#" class="social-link ps-2"><img src="{{ asset('images/icon/linkedin-b.png')}}"/></a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 pb-5">
                            <img src="{{$data->heroimage}}" class="img-fluid w-100">
                        </div>
                        <div class="col-12 content-detail-block">
                            {{ renderContent($components) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
    <!-- Plugin Script -->
    <script src="{{asset('js/jquery-3.6.0.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
    <script>

    </script>
</body>
</html>
