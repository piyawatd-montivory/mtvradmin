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
<link rel="stylesheet" href="{{asset('/css/blogpost.css')}}" type="text/css">
<style>

</style>
@endsection
@section('content')
<!-- Content -->
<section class="breadcrumb-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-12 mt-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{$categoryname}}</a></li>
                    <li class="breadcrumb-item">Library</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-12">
                <h3 class="content-detail-title mt-3">Article Title Article Title Article Title Article Title Article Title Article Title</h3>
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
                        <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid w-100">
                    </div>
                    <div class="col-12 content-detail-block">
                        <h3>H3</h3>
                        <h4>H4</h4>
                        <h5>H5</h5>
                        <h6>H6</h6>
                        <p>
                            This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component.
                        </p>
                        <blockquote class="blockquote">
                            <p>
                                Quote text components
                                Quote text components
                                Quote text components
                            </p>
                        </blockquote>
                        <ul>
                            <li>Bullet</li>
                            <li>Bullet</li>
                            <li>Bullet</li>
                            <li>Bullet</li>
                            <li>Bullet</li>
                            <li>Bullet</li>
                        </ul>
                        <ol>
                            <li>Number</li>
                            <li>Number</li>
                            <li>Number</li>
                            <li>Number</li>
                            <li>Number</li>
                            <li>Number</li>
                        </ol>
                        <div class="row image-block">
                            <h6>Single Image</h6>
                            <div class="col-12">
                                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid w-100">
                                <span class="caption-image">Caption Image</span>
                            </div>
                        </div>
                        <div class="row image-block">
                            <h6>2 Columns</h6>
                            <div class="col-12 col-md-6">
                                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid">
                                <span class="caption-image">Caption Image</span>
                            </div>
                            <div class="col-12 col-md-6">
                                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid">
                                <span class="caption-image">Caption Image</span>
                            </div>
                        </div>
                        <div class="row image-block">
                            <h6>Image Left & Conent</h6>
                            <div class="col-12 col-md-6">
                                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid">
                                <span class="caption-image">Caption Image</span>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>
                                    This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component.
                                </p>
                            </div>
                        </div>
                        <div class="row image-block">
                            <h6>Image Right & Conent</h6>
                            <div class="col-12 col-md-6">
                                <p>
                                    This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component. This is bodytext component.
                                </p>
                            </div>
                            <div class="col-12 col-md-6">
                                <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="img-fluid">
                                <span class="caption-image">Caption Image</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-12">
                <div class="row mb-3 mt-5">
                    <div class="col-12">
                        <strong class="info-title">Source:</strong> <a href="#" class="hyper-link">HYPERLINK</a> <a href="#" class="hyper-link">HYPERLINK</a> <a href="#" class="hyper-link">HYPERLINK</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <strong class="info-title">Tags:</strong> <a href="#" class="btn tag-link">TAG1</a> <a href="#" class="btn tag-link">TAG2</a> <a href="#" class="btn tag-link">TAG3</a>
                    </div>
                </div>
                <div class="row">
                    <strong class="pb-2">Writer</strong>
                    <div class="col-12">
                        <img src="{{ asset('/images/default/Writer-default-image.png')}}" class="profile-img"/>
                        <div class="profile-detail">
                            <p><strong>Kittichai Kaweekijmanee</strong></p>
                            <p>Writer</p>
                        </div>
                    </div>
                </div>
                <hr>
                <h6 class="related-articles-title">Related articles</h6>
                <div class="row row-cols-md-3">
                    <div class="col col-12">
                        <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                        </a>
                        <p class="mt-3 display-time">01 Dec 2022</p>
                    </div>
                    <div class="col col-12">
                        <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                        </a>
                        <p class="mt-3 display-time">01 Dec 2022</p>
                    </div>
                    <div class="col col-12">
                        <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                        <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                            <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                        </a>
                        <p class="mt-3 display-time">01 Dec 2022</p>
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
