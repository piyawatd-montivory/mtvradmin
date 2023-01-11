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
                    <div class="col-5">
                        <div class="dropdown dropdown-month">
                            <button class="btn custom-dropdown dropdown-toggle w-100 text-start dropdownMonth" type="button" id="dropdownMonth" data-bs-toggle="dropdown" aria-expanded="false">
                                All months
                            </button>
                            <ul class="dropdown-menu w-100" id="dropdownMonthList" aria-labelledby="dropdownMonth">
                            <li><a class="dropdown-item month-select month-select-desktop check-selected" href="javascript:void(0);" data="0">All months</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="1">January</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="2">February</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="3">March</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="4">April</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="5">May</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="6">June</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="7">July</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="8">August</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="9">September</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="10">October</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="11">November</a></li>
                            <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="12">December</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="dropdown dropdown-year">
                            <button class="btn custom-dropdown dropdown-toggle w-100 text-start dropdownYear" type="button" id="dropdownYear" data-bs-toggle="dropdown" aria-expanded="false">
                                All years
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownYear">
                            <li><a class="dropdown-item year-select year-select-desktop check-selected" href="javascript:void(0);" data="0">All years</a></li>
                            <li><a class="dropdown-item year-select year-select-desktop" href="javascript:void(0);" data="2022">2022</a></li>
                            <li><a class="dropdown-item year-select year-select-desktop" href="javascript:void(0);" data="2021">2021</a></li>
                            <li><a class="dropdown-item year-select year-select-desktop" href="javascript:void(0);" data="2020">2020</a></li>
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="col-3">
                        <div class="dropdown dropdown-year">
                            <button class="btn custom-dropdown dropdown-toggle w-100 text-start" type="button" id="dropdownTag" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                All tags
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownTag">
                                <li>
                                    <a class="dropdown-item tag-clear" href="javascript:cleartag();">CLEAR</a>
                                </li>
                                <li>
                                    <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-desktop" value="valtag1" label="Tag 1">Tag 1</a>
                                </li>
                                <li>
                                    <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-desktop" value="tag2" label="Tag 2">Tag 2</a>
                                </li>
                                <li>
                                    <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-desktop" value="tag3" label="Tag 3">Tag 3</a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
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
                    // if(app('request')->input('page') === null){
                    //     $params = '?';
                    // }
                    // if($month > 0){
                    //     $params = $params.'&month='.$month.'&year='.$year;
                    // }
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
                            <div class="dropdown dropdown-month">
                                <button class="btn custom-dropdown dropdown-toggle w-100 text-start ps-0 dropdownMonth" type="button" id="dropdownMonth" data-bs-toggle="dropdown" aria-expanded="false">
                                    All months
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMonth">
                                <li><a class="dropdown-item month-select month-select-mobile check-selected" href="javascript:void(0);" data="0">All months</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="1">January</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="2">February</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="3">March</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="4">April</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="5">May</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="6">June</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="7">July</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="8">August</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="9">September</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="10">October</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="11">November</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="12">December</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="dropdown dropdown-year">
                                <button class="btn custom-dropdown dropdown-toggle w-100 text-start ps-0 dropdownYear" type="button" id="dropdownYear" data-bs-toggle="dropdown" aria-expanded="false">
                                    All years
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownYear">
                                <li><a class="dropdown-item year-select year-select-mobile check-selected" href="javascript:void(0);" data="all">All years</a></li>
                                <li><a class="dropdown-item year-select year-select-mobile" href="javascript:void(0);" data="2022">2022</a></li>
                                <li><a class="dropdown-item year-select year-select-mobile" href="javascript:void(0);" data="2021">2021</a></li>
                                <li><a class="dropdown-item year-select year-select-mobile" href="javascript:void(0);" data="2020">2020</a></li>
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="col-12">
                            <div class="dropdown dropdown-year">
                                <button class="btn custom-dropdown dropdown-toggle w-100 text-start ps-0 dropdownTag" type="button" id="dropdownTagMobile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    All tags
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownTagMobile">
                                    <li>
                                        <a class="dropdown-item tag-clear" href="javascript:cleartag();">CLEAR</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-mobile" value="valtag1" label="Tag 1">Tag 1</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-mobile" value="tag2" label="Tag 2">Tag 2</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-mobile" value="tag3" label="Tag 3">Tag 3</a>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}
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
            $('.dropdownYear').text($(this).text());
        });
    })

    // const tagDropdown = document.getElementById('dropdownTag')
    // tagDropdown.addEventListener('hide.bs.dropdown', function () {
    //     let showlabel = ''
    //     $.each($('.form-check-input-desktop'),function(index,value){
    //         if(value.checked){
    //             if(showlabel === ''){
    //                 showlabel = $(value).attr('label');
    //             }else{
    //                 let checklabel = $(value).attr('label');
    //                 showlabel = `${showlabel}, ${checklabel}`;
    //             }
    //         }
    //     })
    //     if(showlabel === ''){
    //         showlabel = 'All tags';
    //     }
    //     $('#dropdownTag').text(showlabel);
    // })

    // const tagDropdownMobile = document.getElementById('dropdownTagMobile')
    // tagDropdownMobile.addEventListener('hide.bs.dropdown', function () {
    //     let showlabel = ''
    //     $.each($('.form-check-input-mobile'),function(index,value){
    //         if(value.checked){
    //             if(showlabel === ''){
    //                 showlabel = $(value).attr('label');
    //             }else{
    //                 let checklabel = $(value).attr('label');
    //                 showlabel = `${showlabel}, ${checklabel}`;
    //             }
    //         }
    //     })
    //     if(showlabel === ''){
    //         showlabel = 'All tags';
    //     }
    //     $('#dropdownTagMobile').text(showlabel);
    // })

    const cleartag = () => {
        $.each($('.form-check-input'),function(index,value){
            $(value).prop("checked",false);
        });
    }

    const filtercontent = (typewindows) => {
        let month = 0;
        let year = 0;
        // let tags = []
        if(typewindows === 'desktop')
        {
            $.each($('.month-select-desktop'),function(index,value){
                if($(value).hasClass('check-selected')){
                    month = $(value).attr('data');
                }
            });
            $.each($('.year-select-desktop'),function(index,value){
                if($(value).hasClass('check-selected')){
                    year = $(value).attr('data');
                }
            });
            // $.each($('.form-check-input-desktop'),function(index,value){
            //     if(value.checked){
            //         tags.push(value.defaultValue);
            //     }
            // })
            // if(tags.length === 0){
            //     tags.push("all");
            // }
        }else{
            $.each($('.month-select-mobile'),function(index,value){
                if($(value).hasClass('check-selected')){
                    month = $(value).attr('data');
                }
            });
            $.each($('.year-select-mobile'),function(index,value){
                if($(value).hasClass('check-selected')){
                    year = $(value).attr('data');
                }
            });
            // $.each($('.form-check-input-mobile'),function(index,value){
            //     if(value.checked){
            //         tags.push(value.defaultValue);
            //     }
            // })
            // if(tags.length === 0){
            //     tags.push("all");
            // }
        }
        // filter.tags = tags;
        window.location.href = "/category/{{ $category->slug }}?year="+year+"&month="+month;
    }

</script>
@endsection
