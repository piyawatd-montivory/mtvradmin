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
    <h4 class="text-center"><a href="{{route('category',['slug'=>'binary-craft'])}}" class="text-decoration-none text-white binary-craft-header">Binary Craft</a></h4>
    <p class="text-center">Montivory’s exclusive contents</p>
    <div class="container mt-3 pb-5">
        <div class="row">
            @foreach ($data->binarycrafts as $item)
                <div class="col-12 col-md-6">
                    <img src="{{ $item->thumbnail }}" class="img-fluid"/>
                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="binary-craft-link">
                        <h5 class="binary-craft-title mt-3">
                            {{ $item->title }}
                        </h5>
                    </a>
                    <p class="mt-3 display-time-w">{{ $item->createAt }}</p>
                </div>
            @endforeach
        </div>
        <div class="d-grid gap-2 mt-3 d-md-block text-center">
            <a class="btn btn-viewall" type="button" href="{{route('category',['slug'=>'binary-craft'])}}">VIEW ALL</a>
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
                    @foreach ($data->business as $item)
                        @if ($loop->first)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                                </div>
                                <div class="col-12">
                                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                                        <h6 class="content-title">{{ $item->title }}</h6>
                                    </a>
                                    <p class="mt-3 display-time">{{ $item->createAt }}</p>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-12 col-md-4">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                                </div>
                                <div class="col-12 col-md-8">
                                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                                    <h6 class="content-title content-title-three-row mt-md-0">{{ $item->title }}</h6>
                                    </a>
                                    <p class="mt-3 display-time">{{ $item->createAt }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
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
                    @foreach ($data->dataandtech as $item)
                        @if ($loop->first)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                                </div>
                                <div class="col-12">
                                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                                        <h6 class="content-title">{{ $item->title }}</h6>
                                    </a>
                                    <p class="mt-3 display-time">{{ $item->createAt }}</p>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-12 col-md-4">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                                </div>
                                <div class="col-12 col-md-8">
                                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                                    <h6 class="content-title content-title-three-row mt-md-0">{{ $item->title }}</h6>
                                    </a>
                                    <p class="mt-3 display-time">{{ $item->createAt }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
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
                    @foreach ($data->creative as $item)
                        @if ($loop->first)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                                </div>
                                <div class="col-12">
                                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                                    <h6 class="content-title content-title-three-row">{{ $item->title }}</h6>
                                    </a>
                                    <p class="mt-3 display-time">{{ $item->createAt }}</p>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                                </div>
                                <div class="col-12 col-md-6">
                                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                                    <h6 class="content-title content-title-four-row mt-md-0">{{ $item->title }}</h6>
                                    </a>
                                    <p class="mt-3 display-time">{{ $item->createAt }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-4 content-block">
                <h4 class="content-main-title">
                    <a href="{{route('category',['slug'=>'privacy'])}}">Privacy<span class="icon-chevron"></span></a>
                </h4>
                <hr class="privacy-line">
                <div class="col-12">
                    @foreach ($data->privacy as $item)
                        @if ($loop->first)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                                </div>
                                <div class="col-12">
                                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                                    <h6 class="content-title content-title-three-row">{{ $item->title }}</h6>
                                    </a>
                                    <p class="mt-3 display-time">{{ $item->createAt }}</p>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                                </div>
                                <div class="col-12 col-md-6">
                                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                                    <h6 class="content-title content-title-four-row mt-md-0">{{ $item->title }}</h6>
                                    </a>
                                    <p class="mt-3 display-time">{{ $item->createAt }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-4 content-block">
                <h4 class="content-main-title">
                    <a href="{{route('category',['slug'=>'research'])}}">Research<span class="icon-chevron"></span></a>
                </h4>
                <hr class="research-line">
                <div class="col-12">
                    @foreach ($data->research as $item)
                        @if ($loop->first)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                                </div>
                                <div class="col-12">
                                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                                    <h6 class="content-title content-title-three-row">{{ $item->title }}</h6>
                                    </a>
                                    <p class="mt-3 display-time">{{ $item->createAt }}</p>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                                </div>
                                <div class="col-12 col-md-6">
                                    <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                                    <h6 class="content-title content-title-four-row mt-md-0">{{ $item->title }}</h6>
                                    </a>
                                    <p class="mt-3 display-time">{{ $item->createAt }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container pb-4">
    <h4 class="content-main-title text-center"><a href="{{route('category',['slug'=>'trending'])}}">Trending</a></h4>
    <p class="text-center">Keep up with the latest trending articles</p>
    <section class="trending-slide mt-3 pb-2">
        @foreach ($data->research as $item)
        <div>
            <div class="text-white pb-2 trending-card">
                <a href="{{route('blogpost',['slug'=>$item->slug])}}" class="content-link">
                    <img src="{{$item->thumbnail}}" class="img-fluid" alt="...">
                    <div class="slide-img-overlay">
                        <h6 class="content-title slide-content-title content-title-three-row mt-md-0 text-white">{{ $item->title }}</h6>
                        <p class="display-time-w display-time-w-slick">{{ $item->createAt }}</p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
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
                        arrows: false,
                        centerPadding: '32px',
                    }
                }
            ]
        });
    });

</script>
@endsection
