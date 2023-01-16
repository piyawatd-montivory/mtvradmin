@extends('layouts.blog')
@section('title')
Montivory Category : {{ $category->title }}
@endsection
@section('meta')
    <meta property="og:title" content="Montivory Category : {{ $category->title }}">
    <meta property="og:description" content="">
    <meta property="og:image" content="{{ asset('/images/frontend/og.jpg')}}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Montivory">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="" />
    <meta property="fb:pages" content="">
    <meta property="fb:app_id" content="">
    <meta property="twitter:image" content="{{ asset('/images/frontend/og.jpg')}}">
@endsection
@section('stylesheet')
<link rel="stylesheet" href="{{asset('/css/blog-category.css')}}" type="text/css">
<!-- Latest compiled and minified CSS -->
<style>
.hero-section {
    background-image: url("{{$category->banner->url}}");
}
</style>
@endsection
@section('content')
<!-- Content -->
<section class="hero-section {{ $category->slug}}-header-line">
    {{-- <img src="{{ $category->banner->url }}" class="img-fluid hero-content-banner mx-auto d-block"/> --}}
    <div class="container-fluid hero-content">
        <h3 class="hero-title hero-title-mobile">{{ $category->title}}</h3>
        <h6 class="hero-sub-title">{{ $category->description}}</h6>
    </div>
</section>
<section class="content">
    <div class="container pt-4">
        <div class="row filter-block">
            <div class="col-12 d-none d-md-block">
                <div class="row">
                    <div class="col-3">
                        <div class="dropdown dropdown-year">
                            <button class="btn custom-dropdown dropdown-toggle w-100 text-start dropdownYear" type="button" id="dropdownYear" data-bs-toggle="dropdown" aria-expanded="false">
                                @if($year == 0)
                                    All years
                                @else
                                    {{$year}}
                                @endif
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownYear">
                            <li><a class="dropdown-item year-select year-select-desktop @if($year == 0) check-selected @endif" href="javascript:void(0);" data="0">All years</a></li>
                            @foreach (getYears() as $iyear)
                                <li><a class="dropdown-item year-select year-select-desktop @if($year == $iyear) check-selected @endif" href="javascript:void(0);" data="{{ $iyear }}">{{ $iyear }}</a></li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="dropdown dropdown-month">
                            <button class="btn @if($year == 0) disabled @endif custom-dropdown dropdown-toggle w-100 text-start dropdownMonth" type="button" id="dropdownMonth" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ getMonthName($month) }}
                            </button>
                            <ul class="dropdown-menu w-100" id="dropdownMonthList" aria-labelledby="dropdownMonth">
                            <li><a class="dropdown-item month-select month-select-desktop @if($month == 0) check-selected @endif default-month" href="javascript:void(0);" data="0">All months</a></li>
                            @foreach (getMonths() as $imonth)
                                <li><a class="dropdown-item month-select month-select-desktop @if($month == ($loop->index + 1)) check-selected @endif" href="javascript:void(0);" data="{{$loop->index + 1}}">{{$imonth}}</a></li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-apply px-3" type="button" onclick="filtercontent('desktop');" >APPLY</button>
                    </div>
                </div>
            </div>
            <div class="col-12 d-md-none">
                <button class="btn px-3 btn-outline-filter" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <img src="{{asset('images/icon/Filter-icon.png')}}" class="filter-icon"/>
                    FILTER
                </button>
            </div>
        </div>
        <div class="row">
            @foreach ($data->data as $item)
                <div class="col-12 col-md-4 content-block">
                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="...">
                    <a href="{{$item->url}}" class="content-link">
                        <h6 class="content-title content-title-three-row">{{ $item->title }}</h6>
                    </a>
                    <p class="display-time">{{ $item->createAt }}</p>
                </div>
            @endforeach
        </div>
        <div class="row page-row">
            <div class="col-12 text-center d-none d-md-block">
                @php
                    $params = '';
                    if($year > 0){
                        $params = '&year='.$year;
                        if($month > 0){
                            $params = $params.'&month='.$month;
                        }
                    }
                @endphp
                <a href="{{ route('category',['slug'=>$category->slug,'page'=>1]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->first) d-none @endif first-btn">FIRST</a>
                <a href="{{ route('category',['slug'=>$category->slug,'page'=>$currentPage-1]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->first) d-none @endif previous-btn">PREVIOUS</a>
                @for($i = $page->min;$i <= $page->max;$i++)
                    @if($i == $currentPage)
                        <a href="javascript:void(0);" class="btn btn-page active">{{ $i }}</a>
                    @else
                        <a href="{{ route('category',['slug'=>$category->slug,'page'=>$i]) }}{{$params}}" class="btn btn-page">{{ $i }}</a>
                    @endif
                @endfor
                <a href="{{ route('category',['slug'=>$category->slug,'page'=>$currentPage+1]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->last) d-none @endif next-btn">NEXT</a>
                <a href="{{ route('category',['slug'=>$category->slug,'page'=>$data->pages]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->last) d-none @endif last-btn">LAST</a>
            </div>
            <div class="col-12 text-center d-md-none">
                <a href="{{ route('category',['slug'=>$category->slug,'page'=>1]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->first) d-none @endif first-btn">
                    <img src="{{ asset('images/icon/btn-first-mb.png')}}"/>
                </a>
                <a href="{{ route('category',['slug'=>$category->slug,'page'=>$currentPage-1]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->first) d-none @endif previous-btn">
                    <img src="{{ asset('images/icon/btn-previous-mb.png')}}"/>
                </a>
                @for($i = $page->min;$i <= $page->max;$i++)
                    @if($i == $currentPage)
                        <a href="javascript:void(0);" class="btn btn-page active">{{ $i }}</a>
                    @else
                        <a href="{{ route('category',['slug'=>$category->slug,'page'=>$i]) }}{{$params}}" class="btn btn-page">{{ $i }}</a>
                    @endif
                @endfor
                <a href="{{ route('category',['slug'=>$category->slug,'page'=>$currentPage+1]) }}{{$params}}" class="btn btn-page btn-page-nav next-btn @if(!$page->last) d-none @endif ">
                    <img src="{{ asset('images/icon/btn-next-mb.png')}}"/>
                </a>
                <a href="{{ route('category',['slug'=>$category->slug,'page'=>$data->pages]) }}{{$params}}" class="btn btn-page btn-page-nav last-btn @if(!$page->last) d-none @endif ">
                    <img src="{{ asset('images/icon/btn-last-mb.png')}}"/>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="filterModalLabel">Filter</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="dropdown dropdown-year">
                                <button class="btn custom-dropdown dropdown-toggle w-100 text-start ps-0 dropdownYear" type="button" id="dropdownYear" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if($year == 0)
                                    All years
                                    @else
                                    {{$year}}
                                    @endif
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownYear">
                                <li><a class="dropdown-item year-select year-select-mobile @if($year == 0) check-selected @endif" href="javascript:void(0);" data="all">All years</a></li>
                                @foreach (getYears() as $iyear)
                                    <li><a class="dropdown-item year-select year-select-mobile @if($year == $iyear) check-selected @endif" href="javascript:void(0);" data="{{ $iyear }}">{{ $iyear }}</a></li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="dropdown dropdown-month">
                                <button class="btn  @if($month == 0) disabled @endif  custom-dropdown dropdown-toggle w-100 text-start ps-0 dropdownMonth" type="button" id="dropdownMonth" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ getMonthName($month) }}
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMonth">
                                <li><a class="dropdown-item month-select month-select-mobile  @if($month == 0) check-selected @endif default-month" href="javascript:void(0);" data="0">All months</a></li>
                                @foreach (getMonths() as $imonth)
                                    <li><a class="dropdown-item month-select month-select-mobile @if($month == ($loop->index + 1)) check-selected @endif" href="javascript:void(0);" data="{{ $loop->index + 1}}">{{$imonth}}</a></li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="d-grid gap-2 col-12">
                <button type="button" class="btn btn-primary btn-search-mobile" onclick="filtercontent('mobile');">APPLY</button>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">

    $(function(){
        $('.month-select').on('click',function(){
            $('.month-select').removeClass('check-selected');
            $(this).addClass('check-selected');
            $('.dropdownMonth').text($(this).text());
        });
        $('.year-select').on('click',function(){
            $('.year-select').removeClass('check-selected');
            $(this).addClass('check-selected');
            if($(this).text() !== 'All years'){
                $('.dropdownMonth').removeClass('disabled');
            }else{
                $('.dropdownMonth').addClass('disabled');
                $('.month-select').removeClass('check-selected');
                $('.default-month').addClass('check-selected');
                $('.dropdownMonth').text('All months');
            }
            $('.dropdownYear').text($(this).text());
        });
    })

    const cleartag = () => {
        $.each($('.form-check-input'),function(index,value){
            $(value).prop("checked",false);
        });
    }

    const filtercontent = (typewindows) => {
        let params = '';
        // let tags = []
        if(typewindows === 'desktop')
        {
            $.each($('.year-select-desktop'),function(index,value){
                if($(value).hasClass('check-selected')){
                    if($(value).attr('data') > 0){
                        params = '?year='+$(value).attr('data');
                    }
                }
            });
            $.each($('.month-select-desktop'),function(index,value){
                if($(value).hasClass('check-selected')){
                    if($(value).attr('data') > 0){
                        if(params === ''){
                            params = '?';
                        }else{
                            params = params+'&';
                        }
                        params = params+'month='+$(value).attr('data');
                    }
                }
            });
        }else{
            $.each($('.year-select-mobile'),function(index,value){
                if($(value).hasClass('check-selected')){
                    if($(value).attr('data') > 0){
                        params = '?year='+$(value).attr('data');
                    }
                }
            });
            $.each($('.month-select-mobile'),function(index,value){
                if($(value).hasClass('check-selected')){
                    if($(value).attr('data') > 0){
                        if(params === ''){
                            params = '?';
                        }else{
                            params = params+'&';
                        }
                        params = params+'month='+$(value).attr('data');
                    }
                }
            });
        }
        window.location.href = "/category/{{ $category->slug }}"+params;
    }

</script>
@endsection
