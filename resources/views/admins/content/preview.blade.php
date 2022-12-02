<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Spacebar | {{ $data->title }}</title>

    <!-- Social Media Meta -->
    <meta property="og:title" content="Spacebar | {{ $data->title }}">
    <meta property="og:description" content="{{ $data->ogdescription }}">
    <meta property="og:image" content="{{ $data->ogimage }}">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="">
    <meta property="fb:pages" content="">
    <meta property="fb:app_id" content="">
    <meta property="twitter:image" content="{{ $data->ogimage }}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/preview/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/preview/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/preview/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/preview/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('assets/preview/favicon/safari-pinned-tab.svg')}}" color="#002d9d">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="{{asset('assets/preview/plugin/plyr/plyr.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/preview/plugin/select2/select2.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/preview/plugin/swiper/swiper.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/preview/plugin/fancybox/jquery.fancybox.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/preview/plugin/slidetounlock/slideToUnlock.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/preview/plugin/bootstrap/css/bootstrap-grid.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/preview/css/animate.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/preview/css/iconfont.css')}}" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/preview/css/theme.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/preview/css/theme-rwd.css')}}" type="text/css">
    <style>
        .header-bar {
            padding: 5px 0 5px 0!important;
        }
        .text-end {
            text-align: right !important;
        }
        .tool-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
            color: #198754;
            background-color: #fff;
            border-color: #fff;
            margin-top: 0;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            user-select: none;
            border: 1px solid transparent;
        }
        .btn-publish{
            color: #198754;
            background-color: #fff;
            border-color: #fff;
        }
        .btn-publish:hover{
            background-color: #198754;
            border-color: #198754;
            color: #fff;
        }
        .btn-unpublish{
            color: #dc3545;
            background-color: #fff;
            border-color: #fff;
        }
        .btn-unpublish:hover{
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
        .btn-archive {
            color: #dc3545;
            background-color: #fff;
            border-color: #fff;
        }
        .btn-archive:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
        .btn-unarchive {
            color: #198754;
            background-color: #fff;
            border-color: #fff;
        }
        .btn-unarchive:hover {
            background-color: #198754;
            border-color: #198754;
            color: #fff;
        }
    </style>
</head>



<body>
<div id="page" class="header-transparent">


<!-- Header -->
<header id="header" class="header-fixed">
    <div class="header-bar">
        <div class="container">
            <div class="offset-10 col-2 text-end">
                @if($data->status == 'draft')
                    <button type="button" class="tool-btn btn-archive">Archive</button>
                    <button type="button" class="tool-btn btn-unarchive d-none">UnArchive</button>
                    <button type="button" class="tool-btn btn-unpublish d-none">Unpublish</button>
                    <button type="button" class="tool-btn btn-publish">Publish</button>
                @endif
                @if($data->status == 'publish')
                    <button type="button" class="tool-btn btn-archive d-none">Archive</button>
                    <button type="button" class="tool-btn btn-unarchive d-none">UnArchive</button>
                    <button type="button" class="tool-btn btn-unpublish">Unpublish</button>
                    <button type="button" class="tool-btn btn-publish d-none">Publish</button>
                @endif
                @if($data->status == 'archive')
                    <button type="button" class="tool-btn btn-archive d-none">Archive</button>
                    <button type="button" class="tool-btn btn-unarchive">UnArchive</button>
                    <button type="button" class="tool-btn btn-unpublish d-none">Unpublish</button>
                    <button type="button" class="tool-btn btn-publish d-none">Publish</button>
                @endif
            </div>
        </div>
    </div>
</header>
<!-- Content -->
<main id="content">

    <section class="article">
        <div class="container">
            <div class="sc-inner">
                <!-- Article Type Start -->
                <div class="article-original">
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-12 _center">
                            <div class="entry-heading">
                                <a href="javascript:;" class="entry-bookmark"></a>
                                <h1 class="entry-title">{{ $data->title }}</h1>
                                <div class="entry-meta">
                                    <i class="ic ic-clock"></i>
                                    <span class="entry-date">20 MAY 2021</span>
                                    <span class="entry-time">09:00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-12 col-md-12 col-12 _center">
                            <div class="consensus-vote">
                                <div class="vote-percent">
                                    <span>11%</span> Consensus
                                </div>
                                <div class="vote-heading-en">THE PEOPLE POWER</div>
                                <div class="vote-heading-th">โหวตบทความขึ้นหน้าแรก spacebar!</div>
                                <div class="vote-wrap">
                                    <a href="javascript:;"><i class="ic ic-vote-down"></i> โหวตลง</a>
                                    <a href="javascript:;"><i class="ic ic-vote-up"></i> โหวตขึ้น</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="entry-hero">
                                @if($data->type == 'hero')
                                <div class="hero-image object-fit">
                                    <img alt="" src="{{ $data->heroimage }}">
                                </div>
                                @endif
                                @if($data->type == 'video')
                                    {!! html_entity_decode($data->herovideo) !!}
                                @endif
                                @if($data->type == 'podcast')
                                    {!! html_entity_decode($data->heropodcast) !!}
                                @endif
                                @if($data->type == 'slide')
                                <div class="swiper-container default progressbar">
                                    <div class="swiper-wrapper">
                                        @foreach ($data->heroslide as $heroslide)
                                            <div class="swiper-slide">
                                                <div class="image object-fit"><img alt="" src="{{$heroslide->url}}"></div>
                                            </div>    
                                        @endforeach
                                    </div>
                                    <div class="swiper-pagination"></div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-12 _center">
                            <div class="entry-bullet">
                                <ul>
                                    @foreach ($data->entrybullet as $bullet)
                                    <li>{{$bullet->detail}}</li>    
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-12 _center">
                            <div class="entry-share animate fadeInUp">
                                <div class="entry-social">
                                    <span>Share with trust</span>
                                    <a href="#"><i class="ic ic-facebook"></i></a>
                                    <a href="#"><i class="ic ic-twitter"></i></a>
                                    <a href="#"><i class="ic ic-line"></i></a>
                                    <a href="javascript:;" class="copy-link">
                                        <i class="ic ic-link"></i>
                                        <div class="text-on">Link Copied</div>
                                    </a>
                                </div>
                                <a href="javascript:;" class="trust-link"><i class="ic ic-shield-tick"></i>Why trust Spacebar</a>
                            </div>
                        </div>
                    </div>
                    @if($data->type == 'podcast')
                                    
                                
                        <div class="row">
                            <div class="col-lg-8 col-md-12 col-12 _center">
                                <div class="podcast-soundcloud">
                                    {!! html_entity_decode($data->podcast) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-12 col-12 _center">
                                <div class="podcast-share">
                                    <span>You may also listen on</span>
                                    @foreach($data->podcastchannel as $channel)
                                        @switch($channel->channel)
                                            @case('spotify')
                                                <a href="@if($channel->link == '') # @else {{$channel->link}} @endif"><img alt="" src="{{asset('assets/preview/img/podcast-spotify.png')}}"></a>        
                                                @break
                                        
                                            @case('apple')
                                                <a href="@if($channel->link == '') # @else {{$channel->link}} @endif"><img alt="" src="{{asset('assets/preview/img/podcast-apple.png')}}"></a>        
                                                @break

                                            @case('google')
                                                <a href="@if($channel->link == '') # @else {{$channel->link}} @endif"><img alt="" src="{{asset('assets/preview/img/podcast-google.png')}}"></a>        
                                                @break 
                                        @endswitch
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-12 _center">
                            <div class="entry-content">
                                @foreach ($data->contents as $component)
                                    @if($component->display)
                                        @switch($component->component)
                                            @case('content')
                                                {!! html_entity_decode($component->content) !!}
                                                @break
                                            @case('bullet')
                                                {!! html_entity_decode($component->content) !!}
                                                @break
                                            @case('blockquote')
                                                <blockquote>
                                                    <h3 class="quote-title">{{$component->title}}</h3>
                                                    <div class="quote-text">
                                                        <p>{!! html_entity_decode($component->content) !!}</p>
                                                    </div>
                                                    <p class="quote-source">{{$component->credit}}</p>
                                                </blockquote>
                                                @break
                                            @case('ad')
                                                <a href="#"><div class="image object-fit ads ads970x250"><img alt="" src="{{asset('assets/preview/img/banner970x250.png')}}"></div></a>
                                                @break
                                            @case('image-left')
                                                Second case...
                                                @break
                                            @case('image-right')
                                                Second case...
                                                @break
                                            @case('double-image')
                                                Second case...
                                                @break
                                            @case('single-image')
                                                <figure>
                                                    <img alt="" src="{{ $component->image }}">
                                                    <figcaption>{{ $component->imagetitle }}</figcaption>
                                                </figure>
                                                @break
                                        @endswitch
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-12 _center">
                            <div class="entry-reference">
                                <h4 class="ref-heading">อ้างอิง:</h4>
                                <ul>
                                    @if(isset($data->reference))
                                        @foreach ($data->reference as $reference)
                                            <li><a href="{{$reference->link}}">{{$reference->title}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-12 _center">
                            <div class="entry-author">
                                @if(isset($data->pseudonym))
                                    @foreach ($data->pseudonym as $penname)
                                        <div class="col-lg-6 col-md-6 col-12 author">
                                            <div class="image"><img alt="" src="{{$penname->profileimage}}"></div>
                                            <div class="author-detail">
                                                <h4 class="author-name">{{$penname->name}}</h4>
                                                <p class="author-do">ผู้เขียน</p>
                                            </div>
                                        </div>        
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-12 _center">
                            <div class="entry-tag">
                                <a href="#">หมายจับ</a>
                                <a href="#">นายกรัฐมนตรี</a>
                                <a href="#">AIS</a>
                                <a href="#">Covid-19</a>
                                <a href="#">Business</a>
                                <a href="#">หุ้นไทย</a>
                                <a href="#">การลงทุน</a>
                                <a href="#">เลือกตั้ง 2565</a>
                                <a href="#">สินทรัพย์ดิจิทัล</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Article Type End -->
            </div>
        </div>
    </section>
</main>

<!-- jQuery -->
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>

<!-- Plugin Script -->
<script src="{{asset('assets/preview/plugin/plyr/plyr.min.js')}}"></script>
<script src="{{asset('assets/preview/plugin/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/preview/plugin/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('assets/preview/plugin/swiper/swiper.min.js')}}"></script>
<script src="{{asset('assets/preview/plugin/wow/wow.min.js')}}"></script>
<script src="{{asset('assets/preview/plugin/slidetounlock/slideToUnlock.js')}}"></script>
<script src="{{asset('assets/preview/plugin/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- Custom Script -->
<script src="{{asset('assets/preview/js/theme.js')}}"></script>

</div>
</body>
</html>
