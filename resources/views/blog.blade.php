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
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>
<style>

</style>
@endsection
@section('content')
<!-- Content -->
<section class="hero-section">
    <img src="{{ asset('images/default/Heor Banner.jpg') }}" class="img-fluid hero-content-banner mx-auto d-block"/>
    <div class="container-fluid hero-content text-white">
        <span>Category</span>
        <h3 class="hero-title">Google’s Helpful Content สิ่งที่คนทำ SEO Marketing ต้องรู้และพลาดไม่ได้</h3>
        <div class="d-grid gap-2 mt-5 d-md-block">
            <a class="btn btn-readnow" type="button" href="{{route('blogpost',['slug'=>'sample'])}}">READ NOW</a>
        </div>
    </div>
</section>
<section class="binary-craft">
    <h4 class="text-center">Binary Craft</h4>
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
                <h4 class="content-main-title">Business<span class="icon-chevron"></span></h4>
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
                <h4 class="content-main-title">Data And Tech<span class="icon-chevron"></span></h4>
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
                <h4 class="content-main-title">Creative<span class="icon-chevron"></span></h4>
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
                <h4 class="content-main-title">Privacy<span class="icon-chevron"></span></h4>
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
                <h4 class="content-main-title">Research<span class="icon-chevron"></span></h4>
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
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script type="text/javascript">


</script>
@endsection
