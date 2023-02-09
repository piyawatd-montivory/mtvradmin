@extends('layouts.blog')
@section('title')
Montivory : {{ $data->title }}
@endsection
@section('meta')
    <meta property="og:title" content="{{ $data->ogtitle }}">
    <meta property="og:description" content="{{ $data->ogdescription }}">
    <meta property="og:image" content="{{ $data->ogdescription }}">
    <meta property="og:url" content="{{ $data->url }}">
    <meta property="og:site_name" content="montivory">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="th" />
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
                    <li class="breadcrumb-item"><a href="#">{{$category->title}}</a></li>
                    {{-- <li class="breadcrumb-item">Library</li> --}}
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
                <h3 class="content-detail-title mt-3">{{ $data->title }}</h3>
                <div class="row pt-3">
                    <div class="col-12 col-md-6">
                        <p class="published-label">Published:{{ $data->createAt }}</p>
                    </div>
                    <div class="col-12 col-md-6 text-md-end mb-3">
                        <span class="share-label">Share</span>
                        <a href="https://www.facebook.com/dialog/share?app_id=570634668210667&display=popup&href={{ urlencode($data->url) }}&redirect_uri={{ urlencode($data->url) }}" class="social-link px-2"><img src="{{ asset('images/icon/facebook-b.png')}}"/></a>
                        {{-- <a href="#" class="social-link px-2"><img src="{{ asset('images/icon/instagram-b.png')}}"/></a> --}}
                        <script type="IN/Share" data-url="{{ $data->url }}"></script>
                        <a href="https://twitter.com/share?ref_src={{ $data->url }}" class="twitter-share-button" data-show-count="false">Tweet</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pb-5">
                        <img src="{{ $data->heroimage }}" class="img-fluid w-100">
                    </div>
                    <div class="col-12 content-detail-block">
                        {{ renderContent($data->content) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-12 pt-5">
                @if(count($data->reference) > 0)
                <div class="row pb-3">
                    <div class="col-12">
                        <strong class="info-title">Source:</strong>
                        @foreach ($data->reference as $reference)
                            <a href="{{ $reference->link }}" class="hyper-link">{{ $reference->title }}</a>
                        @endforeach
                    </div>
                </div>
                @endif
                @if(count($data->tags) > 0)
                <div class="row">
                    <div class="col-12">
                        <strong class="info-title">Tags:</strong>
                        @foreach ($data->tags as $tag)
                            <a href="{{ $tag->url }}" class="btn tag-link">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="row">
                    <strong class="pb-2">Writer</strong>
                    <div class="col-12">
                        <img src="{{ $data->pseudonym->profileimage }}" class="profile-img"/>
                        <div class="profile-detail">
                            <p><strong>{{ $data->pseudonym->name }}</strong></p>
                            <p>{{ $data->pseudonym->title }}</p>
                        </div>
                    </div>
                </div>
                <hr>
                <h6 class="related-articles-title">Related articles</h6>
                <div class="row row-cols-md-3 related-articles-section">
                    @foreach ($relateds as $related)
                        <div class="col col-12">
                            <img src="{{$related->thumbnail}}" class="card-img-top" alt="...">
                            <a href="{{ $related->categoryurl }}" class="category-link">
                                <h6>{{ $related->category }}</h6>
                            </a>
                            <a href="{{$related->url}}" class="content-link">
                                <h6 class="content-title content-title-three-row">{{$related->title}}</h6>
                            </a>
                            <p class="mt-3 display-time">{{$related->createAt}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<div id="fb-root"></div>

@endsection
@section('script')
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
@endsection
