@extends('layouts.blog')
@section('title')
Montivory @if($data->total > 0) Search : {{$search}} @else Not Found @endif
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
<link rel="stylesheet" href="{{asset('/css/blog-search.css')}}" type="text/css">
<!-- Latest compiled and minified CSS -->
<style>

</style>
@endsection
@section('content')
<!-- Content -->
<section class="content">
    <div class="container pt-3">
        @if($data->total > 0)
            <div class="row filter-block">
                <div class="col-12 col-md-10 d-none d-md-block">
                    <h6 class="search-result-display"><span class="font-normal">{{ $data->total }} results of : </span>{{$search}}</h6>
                    <div class="row">
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
                            <div class="col-3">
                                <div class="dropdown dropdown-year">
                                    <button class="btn custom-dropdown dropdown-toggle w-100 text-start" type="button" id="dropdownCategory" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                        @php
                                        $cateLabel = 'All categories';
                                        if(count($categoryfilter) > 0){
                                            $cateLabel = '';
                                            foreach (getFeCategory() as $cateFilter)
                                            {
                                                foreach ($categoryfilter as $cateSel){
                                                    if($cateSel == $cateFilter->slug)
                                                    {
                                                        if($cateLabel == ''){
                                                            $cateLabel = $cateFilter->name;
                                                        }else{
                                                            $cateLabel = $cateLabel.', '.$cateFilter->name;
                                                        }
                                                    }
                                                }

                                            }
                                        }
                                        @endphp
                                        {{ $cateLabel }}
                                    </button>
                                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownCategory">
                                        <li>
                                            <a class="dropdown-item tag-clear" href="javascript:clearcategory();">CLEAR</a>
                                        </li>
                                        @foreach (getFeCategory() as $cateFilter)
                                            @php
                                            $sel = false;
                                            foreach ($categoryfilter as $cateSel){
                                                if($cateSel == $cateFilter->slug){
                                                    $sel = true;
                                                    break;
                                                }
                                            }
                                            @endphp
                                            <li>
                                                <a class="dropdown-item tag-select" data="{{$cateFilter->slug}}"><input type="checkbox" class="form-check-input form-check-input-desktop" value="{{$cateFilter->slug}}" label="{{$cateFilter->name}}" @if($sel) checked @endif>{{$cateFilter->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-apply px-3" type="button" onclick="filtercontent('desktop');" >APPLY</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-md-none">
                    <h6 class="search-result-display"><span class="font-normal">{{ $data->total }} results of : <br></span>{{$search}}</h6>
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
                        <a href="{{ $item->categoryurl }}" class="category-link">
                            <h6 class="category-label">{{ $item->category }}</h6>
                        </a>
                        <a href="{{$item->url}}" class="content-link">
                            <h6 class="content-title content-title-three-row">{{ $item->title }}</h6>
                        </a>
                        <p class="mt-3 display-time">{{ $item->createAt }}</p>
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
                    if(count($categoryfilter) > 0){
                        $cateLabel = '';
                        foreach ($categoryfilter as $cateSel){
                            if($cateLabel == ''){
                                $cateLabel = $cateFilter->name;
                            }else{
                                $cateLabel = $cateLabel.', '.$cateFilter->name;
                            }
                        }
                        $params = $params.'&category='.$cateLabel;
                    }
                    @endphp
                    <a href="{{ route('search',['search'=>$search,'page'=>1]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->first) d-none @endif first-btn">FIRST</a>
                    <a href="{{ route('search',['search'=>$search,'page'=>$currentPage-1]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->first) d-none @endif previous-btn">PREVIOUS</a>
                    @for($i = $page->min;$i <= $page->max;$i++)
                        @if($i == $currentPage)
                            <a href="javascript:void(0);" class="btn btn-page active">{{ $i }}</a>
                        @else
                            <a href="{{ route('search',['search'=>$search,'page'=>$i]) }}{{$params}}" class="btn btn-page">{{ $i }}</a>
                        @endif
                    @endfor
                    <a href="{{ route('search',['search'=>$search,'page'=>$currentPage+1]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->last) d-none @endif next-btn">NEXT</a>
                    <a href="{{ route('search',['search'=>$search,'page'=>$data->pages]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->last) d-none @endif last-btn">LAST</a>
                </div>
                <div class="col-12 text-center d-md-none">
                    <a href="{{ route('search',['search'=>$search,'page'=>1]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->first) d-none @endif first-btn">
                        <img src="{{ asset('images/icon/btn-first-mb.png')}}"/>
                    </a>
                    <a href="{{ route('search',['search'=>$search,'page'=>$currentPage-1]) }}{{$params}}" class="btn btn-page btn-page-nav @if(!$page->first) d-none @endif previous-btn">
                        <img src="{{ asset('images/icon/btn-previous-mb.png')}}"/>
                    </a>
                    @for($i = $page->min;$i <= $page->max;$i++)
                        @if($i == $currentPage)
                            <a href="javascript:void(0);" class="btn btn-page active">{{ $i }}</a>
                        @else
                            <a href="{{ route('search',['search'=>$search,'page'=>$i]) }}{{$params}}" class="btn btn-page">{{ $i }}</a>
                        @endif
                    @endfor
                    <a href="{{ route('search',['search'=>$search,'page'=>$currentPage+1]) }}{{$params}}" class="btn btn-page btn-page-nav next-btn @if(!$page->last) d-none @endif ">
                        <img src="{{ asset('images/icon/btn-next-mb.png')}}"/>
                    </a>
                    <a href="{{ route('search',['search'=>$search,'page'=>$data->pages]) }}{{$params}}" class="btn btn-page btn-page-nav last-btn @if(!$page->last) d-none @endif ">
                        <img src="{{ asset('images/icon/btn-last-mb.png')}}"/>
                    </a>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 d-none d-md-block">
                    <h6 class="search-result-display"><span class="font-normal">0 results of : </span>{{$search}}</h6>
                </div>
                <div class="col-12 d-md-none">
                    <h6 class="search-result-display"><span class="font-normal">0 results of : <br></span>{{$search}}</h6>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 text-center">
                    <img src="{{ asset('images/icon/Not-found-icon.png') }}" class="notfound-img mx-auto d-block"/>
                    <h3 class="notfound-color sorry-title">Sorry</h3>
                    <h6 class="notfound-color sorry-sub-title">Please try another keyword</h6>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 text-center mt-2">
                    @foreach ($tags as $tag)
                        <a href="{{ route('tags',['slug'=>$tag->id]) }}" class="pill btn btn-primary mb-3">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 mt-4">
                    <h4 class="mb-0 article-like">Article you may like</h4>
                    <div class="row article-like-section">
                        @foreach ($relateds->data as $item)
                            <div class="col-12 col-md-4 content-block">
                                <img src="{{$item->thumbnail}}" class="card-img-top" alt="...">
                                <a href="{{$item->categoryurl}}" class="category-link">
                                    <h6>{{ $item->category }}</h6>
                                </a>
                                <a href="{{$item->url}}" class="content-link">
                                    <h6 class="content-title content-title-three-row">{{ $item->title }}</h6>
                                </a>
                                <p class="mt-3 display-time">{{$item->createAt}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="filterModalLabel">Filter</h5>
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
                        <div class="col-12">
                            <div class="dropdown dropdown-category">
                                <button class="btn custom-dropdown dropdown-toggle w-100 text-start ps-0 dropdownCategory" type="button" id="dropdownCategoryMobile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    All categories
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownCategoryMobile">
                                    <li>
                                        <a class="dropdown-item tag-clear" href="javascript:clearcategory();">CLEAR</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-mobile" value="binary-craft" label="Binary Craft">Binary Craft</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-mobile" value="business" label="Business">Business</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-mobile" value="creative" label="Creative">Creative</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-mobile" value="data-and-tech" label="Data and Tech">Data and Tech</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-mobile" value="privacy" label="Privacy">Privacy</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-mobile" value="research" label="Research">Research</a>
                                    </li>
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

    @if($data->total > 0)
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

    const categoryDropdown = document.getElementById('dropdownCategory')
    categoryDropdown.addEventListener('hide.bs.dropdown', function () {
        let showlabel = ''
        $.each($('.form-check-input-desktop'),function(index,value){
            if(value.checked){
                if(showlabel === ''){
                    showlabel = $(value).attr('label');
                }else{
                    let checklabel = $(value).attr('label');
                    showlabel = `${showlabel}, ${checklabel}`;
                }
            }
        })
        if(showlabel === ''){
            showlabel = 'All categories';
        }
        $('#dropdownCategory').text(showlabel);
    })

    const categoryDropdownMobile = document.getElementById('dropdownCategoryMobile')
    categoryDropdownMobile.addEventListener('hide.bs.dropdown', function () {
        let showlabel = ''
        $.each($('.form-check-input-mobile'),function(index,value){
            if(value.checked){
                if(showlabel === ''){
                    showlabel = $(value).attr('label');
                }else{
                    let checklabel = $(value).attr('label');
                    showlabel = `${showlabel}, ${checklabel}`;
                }
            }
        })
        if(showlabel === ''){
            showlabel = 'All categories';
        }
        $('#dropdownCategoryMobile').text(showlabel);
    })

    const clearcategory = () => {
        $.each($('.form-check-input'),function(index,value){
            $(value).prop("checked",false);
        });
    }

    const filtercontent = (typewindows) => {
        let category = '';
        let params = '';
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
            $.each($('.form-check-input-desktop'),function(index,value){
                if(value.checked){
                    if(category === ''){
                        category = value.defaultValue;
                    }else{
                        category += ','+value.defaultValue;
                    }
                }
            })
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
            $.each($('.form-check-input-mobile'),function(index,value){
                if(value.checked){
                    if(category === ''){
                        category = value.defaultValue;
                    }else{
                        category += ','+value.defaultValue;
                    }
                }
            })
        }
        if(category !== ''){
            if(params === ''){
                params = '?category='+category;
            }else{
                params = params+'&category='+category;
            }
        }
        window.location.href = "/search/{{ $search }}"+params;
    }
    @endif

</script>
@endsection
