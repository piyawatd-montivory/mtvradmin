@extends('layouts.blog')
@section('title')
Montivory Category
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
<link rel="stylesheet" href="{{asset('/css/blog-category.css')}}" type="text/css">
<style>

</style>
@endsection
@section('content')
<!-- Content -->
<section class="hero-section">
    <img src="{{ asset('images/default/cover-image.jpg') }}" class="img-fluid hero-content-banner mx-auto d-block"/>
    <div class="container-fluid hero-content">
        <h3 class="hero-title">Binary Craft</h3>
        <h6>Description</h6>
    </div>
</section>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 content-block">
                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                    <h6 class="content-title content-title-three-row mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                </a>
                <p class="mt-3 display-time">01 Dec 2022</p>
            </div>
            <div class="col-12 col-md-4 content-block">
                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                    <h6 class="content-title content-title-three-row mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                </a>
                <p class="mt-3 display-time">01 Dec 2022</p>
            </div>
            <div class="col-12 col-md-4 content-block">
                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                    <h6 class="content-title content-title-three-row mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                </a>
                <p class="mt-3 display-time">01 Dec 2022</p>
            </div>
            <div class="col-12 col-md-4 content-block">
                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                    <h6 class="content-title content-title-three-row mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                </a>
                <p class="mt-3 display-time">01 Dec 2022</p>
            </div>
            <div class="col-12 col-md-4 content-block">
                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                    <h6 class="content-title content-title-three-row mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                </a>
                <p class="mt-3 display-time">01 Dec 2022</p>
            </div>
            <div class="col-12 col-md-4 content-block">
                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                    <h6 class="content-title content-title-three-row mt-3">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                </a>
                <p class="mt-3 display-time">01 Dec 2022</p>
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
