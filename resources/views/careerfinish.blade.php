@extends('layouts.template')
@section('title')
Montivory
@endsection
@section('meta')
    <meta property="og:title" content="Montivory">
    <meta property="og:description" content="">
    <meta property="og:image" content="{{ asset('/images/frontend/og.jpg')}}">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="" />
    <meta property="fb:pages" content="">
    <meta property="fb:app_id" content="">
    <meta property="twitter:image" content="{{ asset('/images/frontend/og.jpg')}}">
@endsection
@section('content')
<!-- Content -->
<!-- Content -->
<main id="content">

    <section class="sc-contacting">
        <div class="container">
            <div class="sc-inner">
                <div class="sc-heading animate fadeInUp">
                    <h2 class="sc-headline">Thank you for contacting</h2>
                    <p class="sc-subhead">We'll reach you back. While you wait,
                        You can read what our people got from working with Montivory </p>
                </div>
                <div class="sc-grid-three cardgroup contacting-cardgroup">
                    <div class="contacting-card card animate fadeInUp">
                        <div class="image object-fit">
                            <img alt="" src="{{ asset('/images/frontend/preview.png')}}">
                        </div>
                        <div class="card-meta">
                            <h4 class="card-category">Binary Craft</h4>
                            <h3 class="card-name">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                        </div>
                    </div>
                    <div class="contacting-card card animate fadeInUp">
                        <div class="image object-fit">
                            <img alt="" src="{{ asset('/images/frontend/preview.png')}}">
                        </div>
                        <div class="card-meta">
                            <h4 class="card-category">Binary Craft</h4>
                            <h3 class="card-name">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                        </div>
                    </div>
                    <div class="contacting-card card animate fadeInUp">
                        <div class="image object-fit">
                            <img alt="" src="{{ asset('/images/frontend/preview.png')}}">
                        </div>
                        <div class="card-meta">
                            <h4 class="card-category">Binary Craft</h4>
                            <h3 class="card-name">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
                        </div>
                    </div>
                </div>
                <div class="contacting-nav animate fadeInUp">
                    <a href="http://read.montivory.com" class="btn">GO TO READ.MONTIVORY</a>
                    <a href="{{ route('home')}}" class="und">NO THANKS</a>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
@section('script')
<script src="{{asset('/plugin/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugin/swiper/swiper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/plugin/wow/wow.min.js')}}" type="text/javascript"></script>

<!-- Custom Script -->
<script src="{{asset('/js/theme.js')}}" type="text/javascript"></script>
@endsection
