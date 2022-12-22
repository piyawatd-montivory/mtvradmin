@extends('layouts.blog')
@section('title')
Montivory Blog
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
@section('stylesheet')
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="{{asset('slick/slick.css')}}"/>
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="{{asset('slick/slick-theme.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('css/slick-custom.css')}}"/>
<style>
.hero-section {
    background-image: url('{{ asset('images/default/Hero-Banner.jpg') }}');
    background-size: cover;
    background-position:center;
    background-repeat:no-repeat;
}

@media only screen and (max-width: 576px) {
    .hero-section {
        background:url('{{ asset('images/default/binary-craft-bg.jpg') }}');
        background-size: cover;
        background-position:center;
        background-repeat:no-repeat;
    }
}
</style>
@endsection
@section('content')
<!-- Content -->
<a href="{{route('blogpost',['slug'=>'sample'])}}">
    <section class="hero-section">
        <div class="container-fluid hero-content text-white">
            <span>Category</span>
            <h3 class="hero-title">Google’s Helpful Content สิ่งที่คนทำ SEO Marketing ต้องรู้และพลาดไม่ได้</h3>
            <div class="d-grid gap-2 mt-5 d-md-block">
                <button class="btn btn-readnow" type="button">READ NOW</button>
            </div>
        </div>
    </section>
</a>
<section class="binary-craft">
    <h4 class="text-center"><a href="{{route('category',['slug'=>'binary-craft'])}}" class="text-decoration-none text-white">Binary Craft</a></h4>
    <p class="text-center">Montivory’s exclusive contents</p>
    <div class="container mt-3 pb-5">
        <div class="row">
            <div class="col-12 col-md-6">
                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid"/>
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="binary-craft-link">
                    <h5 class="binary-craft-title mt-3">
                    Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article
                    </h5>
                </a>
                <p class="mt-3 display-time-w">01 Dec 2022</p>
            </div>
            <div class="col-12 col-md-6">
                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid"/>
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="binary-craft-link">
                    <h5 class="binary-craft-title mt-3">
                        Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article
                    </h5>
                </a>
                <p class="mt-3 display-time-w">01 Dec 2022</p>
            </div>
        </div>
        <div class="d-grid gap-2 mt-3 d-md-block text-center">
            <a class="btn btn-readnow px-5" type="button" href="{{route('category',['slug'=>'binary-craft'])}}">VIEW ALL</a>
        </div>
    </div>
</section>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 content-block">
                <h4 class="content-main-title">
                    <a href="{{route('category',['slug'=>'business'])}}">Business<span class="icon-chevron"></span></a>
                </h4>
                <hr class="business-line">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                                <h6 class="content-title mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12 col-md-8">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-three-row mt-3 mt-md-0">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12 col-md-8">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-three-row mt-3 mt-md-0">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 content-block">
                <h4 class="content-main-title">
                    <a href="{{route('category',['slug'=>'data-and-tech'])}}">
                    Data And Tech<span class="icon-chevron"></span>
                    </a>
                </h4>
                <hr class="data-and-tech-line">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12 col-md-8">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-three-row mt-3 mt-md-0">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-4">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12 col-md-8">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-three-row mt-3 mt-md-0">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4 content-block">
                <h4 class="content-main-title">
                    <a href="{{route('category',['slug'=>'creative'])}}">Creative<span class="icon-chevron"></span></a>
                </h4>
                <hr class="creative-line">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-three-row mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-four-row mt-3 mt-md-0">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-four-row mt-3 mt-md-0">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 content-block">
                <h4 class="content-main-title">
                    <a href="{{route('category',['slug'=>'privacy'])}}">Privacy<span class="icon-chevron"></span></a>
                </h4>
                <hr class="privacy-line">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-three-row mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-four-row mt-3 mt-md-0">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-four-row mt-3 mt-md-0">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 content-block">
                <h4 class="content-main-title">
                    <a href="{{route('category',['slug'=>'research'])}}">Research<span class="icon-chevron"></span></a>
                </h4>
                <hr class="research-line">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-three-row mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-four-row mt-3 mt-md-0">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-four-row mt-3 mt-md-0">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container pb-4">
    <h4 class="content-main-title text-center mt-3"><a href="{{route('category',['slug'=>'trending'])}}">Trending</a></h4>
    <p class="text-center">Keep up with the latest trending articles</p>
    <section class="trending-slide mt-3 pb-2">
        <div>
            <div class="text-white pb-2 trending-card">
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                    <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid" alt="...">
                    <div class="slide-img-overlay">
                        <h6 class="content-title slide-content-title content-title-three-row mt-3 mt-md-0 text-white">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                        <p class="mt-3 display-time-w">01 Dec 2022</p>
                    </div>
                </a>
            </div>
        </div>
        <div>
            <div class="text-white pb-2 trending-card">
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                    <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid" alt="...">
                    <div class="slide-img-overlay">
                        <h6 class="content-title slide-content-title content-title-three-row mt-3 mt-md-0 text-white">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                        <p class="mt-3 display-time-w">01 Dec 2022</p>
                    </div>
                </a>
            </div>
        </div>
        <div>
            <div class="text-white pb-2 trending-card">
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                    <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid" alt="...">
                    <div class="slide-img-overlay">
                        <h6 class="content-title slide-content-title content-title-three-row mt-3 mt-md-0 text-white">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                        <p class="mt-3 display-time-w">01 Dec 2022</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script type="text/javascript" src="{{asset('slick/slick.js')}}"></script>
<script type="text/javascript">
    $(function() {
        $(".trending-slide").slick({
            dots: true,
            infinite: true,
            centerMode: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false
                    }
                }
            ]
        });
    });

</script>
@endsection
