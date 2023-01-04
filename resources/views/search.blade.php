@extends('layouts.blog')
@section('title')
Montivory @if(count($data) > 0) Search @else Not Found @endif
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
        @if(count($data) > 0)
            <div class="row filter-block">
                <div class="col-12 col-md-10 d-none d-md-block">
                    <h6 class="search-result-display"><span class="font-normal">{{ count($data) }} results of: </span>Keywords</h6>
                    <div class="row">
                        <div class="col-11">
                            <div class="row">
                                <div class="col-3">
                                    <div class="dropdown dropdown-month">
                                        <button class="btn custom-dropdown dropdown-toggle w-100 text-start dropdownMonth" type="button" id="dropdownMonth" data-bs-toggle="dropdown" aria-expanded="false">
                                            All months
                                        </button>
                                        <ul class="dropdown-menu w-100" id="dropdownMonthList" aria-labelledby="dropdownMonth">
                                        <li><a class="dropdown-item month-select month-select-desktop check-selected" href="javascript:void(0);" data="all">All months</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="january">January</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="february">February</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="march">March</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="april">April</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="may">May</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="june">June</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="july">July</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="august">August</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="september">September</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="november">November</a></li>
                                        <li><a class="dropdown-item month-select month-select-desktop" href="javascript:void(0);" data="december">December</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="dropdown dropdown-year">
                                        <button class="btn custom-dropdown dropdown-toggle w-100 text-start dropdownYear" type="button" id="dropdownYear" data-bs-toggle="dropdown" aria-expanded="false">
                                            All years
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownYear">
                                        <li><a class="dropdown-item year-select year-select-desktop check-selected" href="javascript:void(0);" data="all">All years</a></li>
                                        <li><a class="dropdown-item year-select year-select-desktop" href="javascript:void(0);" data="2022">2022</a></li>
                                        <li><a class="dropdown-item year-select year-select-desktop" href="javascript:void(0);" data="2021">2021</a></li>
                                        <li><a class="dropdown-item year-select year-select-desktop" href="javascript:void(0);" data="2020">2020</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="dropdown dropdown-year">
                                        <button class="btn custom-dropdown dropdown-toggle w-100 text-start" type="button" id="dropdownCategoryDesktopLabel" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                            All categories
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownCategoryDesktopLabel" id="dropdownCategoryDesktop">
                                            <li>
                                                <a class="dropdown-item tag-clear" href="javascript:clearselect('category');">CLEAR</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="binary-craft" label="Binary Craft">Binary Craft</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="business" label="Business">Business</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="creative" label="Creative">Creative</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="data-and-tech" label="Data and Tech">Data and Tech</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="privacy" label="Privacy">Privacy</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="research" label="Research">Research</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="dropdown dropdown-year">
                                        <button class="btn custom-dropdown dropdown-toggle w-100 text-start" type="button" id="dropdownTagDesktopLabel" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                            All tags
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownTagDesktopLabel" id="dropdownTagDesktop">
                                            <li>
                                                <a class="dropdown-item tag-clear" href="javascript:clearselect('tag');">CLEAR</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input" value="valtag1" label="Tag 1">Tag 1</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input" value="tag2" label="Tag 2">Tag 2</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input" value="tag3" label="Tag 3">Tag 3</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-apply px-3" type="button" onclick="filtercontent('desktop');" >APPLY</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-md-none">
                    <h6 class="search-result-display"><span class="font-normal">{{ count($data) }} results of: <br></span>Keywords</h6>
                    <button class="btn px-3 btn-outline-filter" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <img src="{{asset('images/icon/Filter-icon.png')}}" class="filter-icon"/>
                        FILTER
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 content-block">
                    <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                    <a href="{{route('category',['slug'=>'sample'])}}" class="category-link">
                        <h6>Category</h6>
                    </a>
                    <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                        <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                    </a>
                    <p class="mt-3 display-time">01 Dec 2022</p>
                </div>
                <div class="col-12 col-md-4 content-block">
                    <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                    <a href="{{route('category',['slug'=>'sample'])}}" class="category-link">
                        <h6>Category</h6>
                    </a>
                    <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                        <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                    </a>
                    <p class="mt-3 display-time">01 Dec 2022</p>
                </div>
                <div class="col-12 col-md-4 content-block">
                    <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                    <a href="{{route('category',['slug'=>'sample'])}}" class="category-link">
                        <h6>Category</h6>
                    </a>
                    <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                        <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                    </a>
                    <p class="mt-3 display-time">01 Dec 2022</p>
                </div>
                <div class="col-12 col-md-4 content-block">
                    <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                    <a href="{{route('category',['slug'=>'sample'])}}" class="category-link">
                        <h6>Category</h6>
                    </a>
                    <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                        <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                    </a>
                    <p class="mt-3 display-time">01 Dec 2022</p>
                </div>
                <div class="col-12 col-md-4 content-block">
                    <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                    <a href="{{route('category',['slug'=>'sample'])}}" class="category-link">
                        <h6>Category</h6>
                    </a>
                    <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                        <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                    </a>
                    <p class="mt-3 display-time">01 Dec 2022</p>
                </div>
                <div class="col-12 col-md-4 content-block">
                    <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                    <a href="{{route('category',['slug'=>'sample'])}}" class="category-link">
                        <h6>Category</h6>
                    </a>
                    <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                        <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                    </a>
                    <p class="mt-3 display-time">01 Dec 2022</p>
                </div>
            </div>
            <div class="row page-row">
                <div class="col-12 text-center d-none d-md-block">
                    <a href="" class="btn btn-page btn-page-nav">FIRST</a>
                    <a href="" class="btn btn-page btn-page-nav">PREVIOUS</a>
                    <a href="" class="btn btn-page active">1</a>
                    <a href="" class="btn btn-page">2</a>
                    <a href="" class="btn btn-page">3</a>
                    <a href="" class="btn btn-page btn-page-nav">NEXT</a>
                    <a href="" class="btn btn-page btn-page-nav">LAST</a>
                </div>
                <div class="col-12 text-center d-md-none">
                    <a href="" class="btn btn-page btn-page-nav">
                        <img src="{{ asset('images/icon/btn-first-mb.png')}}"/>
                    </a>
                    <a href="" class="btn btn-page btn-page-nav">
                        <img src="{{ asset('images/icon/btn-previous-mb.png')}}"/>
                    </a>
                    <a href="" class="btn btn-page active">1</a>
                    <a href="" class="btn btn-page">2</a>
                    <a href="" class="btn btn-page">3</a>
                    <a href="" class="btn btn-page btn-page-nav">
                        <img src="{{ asset('images/icon/btn-next-mb.png')}}"/>
                    </a>
                    <a href="" class="btn btn-page btn-page-nav">
                        <img src="{{ asset('images/icon/btn-last-mb.png')}}"/>
                    </a>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 d-none d-md-block">
                    <h6 class="search-result-display"><span class="font-normal">{{ count($data) }} results of: </span>Keywords</h6>
                </div>
                <div class="col-12 d-md-none">
                    <h6 class="search-result-display"><span class="font-normal">{{ count($data) }} results of: <br></span>Keywords</h6>
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
                    <a href="#" class="pill btn btn-primary">
                        Politic
                    </a>
                    <a href="#" class="pill btn btn-primary">
                        Politic
                    </a>
                    <a href="#" class="pill btn btn-primary">
                        Politic
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 mt-4">
                    <h4 class="mb-0 article-like">Article you may like</h4>
                    <div class="row article-like-section">
                        <div class="col-12 col-md-4 content-block">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                            <a href="{{route('category',['slug'=>'sample'])}}" class="category-link">
                                <h6>Category</h6>
                            </a>
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                                <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                        <div class="col-12 col-md-4 content-block">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                            <a href="{{route('category',['slug'=>'sample'])}}" class="category-link">
                                <h6>Category</h6>
                            </a>
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                                <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
                        <div class="col-12 col-md-4 content-block">
                            <img src="{{asset('images/default/ArticleTeaser.jpg')}}" class="card-img-top" alt="...">
                            <a href="{{route('category',['slug'=>'sample'])}}" class="category-link">
                                <h6>Category</h6>
                            </a>
                            <a href="{{route('blogpost',['slug'=>'sample'])}}" class="content-link">
                                <h6 class="content-title content-title-three-row">Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article Article Title Article Title Article Title Article Title Article Title Article Title Article Title Article</h6>
                            </a>
                            <p class="mt-3 display-time">01 Dec 2022</p>
                        </div>
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
                            <div class="dropdown dropdown-month">
                                <button class="btn custom-dropdown dropdown-toggle w-100 text-start ps-0 dropdownMonth" type="button" id="dropdownMonth" data-bs-toggle="dropdown" aria-expanded="false">
                                    All months
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMonth">
                                <li><a class="dropdown-item month-select month-select-mobile check-selected" href="javascript:void(0);" data="all">All months</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="january">January</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="february">February</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="march">March</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="april">April</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="may">May</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="june">June</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="july">July</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="august">August</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="september">September</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="november">November</a></li>
                                <li><a class="dropdown-item month-select month-select-mobile" href="javascript:void(0);" data="december">December</a></li>
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
                        <div class="col-12">
                            <div class="dropdown dropdown-category">
                                <button class="btn custom-dropdown dropdown-toggle w-100 text-start ps-0 dropdownCategory" type="button" id="dropdownCategoryMobileLabel" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    All categories
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownCategoryMobile" id="dropdownCategoryMobile">
                                    <li>
                                        <a class="dropdown-item tag-clear" href="javascript:clearselect('category');">CLEAR</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="binary-craft" label="Binary Craft">Binary Craft</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="business" label="Business">Business</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="creative" label="Creative">Creative</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="data-and-tech" label="Data and Tech">Data and Tech</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="privacy" label="Privacy">Privacy</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="research" label="Research">Research</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dropdown">
                                <button class="btn custom-dropdown dropdown-toggle w-100 text-start ps-0 dropdownTag" type="button" id="dropdownTagMobileLabel" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    All tags
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownTagMobileLabel" id="dropdownTagMobile">
                                    <li>
                                        <a class="dropdown-item tag-clear" href="javascript:clearselect('tag');">CLEAR</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="valtag1" label="Tag 1">Tag 1</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="tag2" label="Tag 2">Tag 2</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item tag-select"><input type="checkbox" class="form-check-input" value="tag3" label="Tag 3">Tag 3</a>
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

    const dropdownCategoryDesktop = document.getElementById('dropdownCategoryDesktopLabel')
    dropdownCategoryDesktop.addEventListener('hide.bs.dropdown', function () {
        let showlabel = ''
        $.each($('#dropdownCategoryDesktop a .form-check-input'),function(index,value){
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
        $('#dropdownCategoryDesktopLabel').text(showlabel);
    })

    const dropdownCategoryMobile = document.getElementById('dropdownCategoryMobileLabel')
    dropdownCategoryMobile.addEventListener('hide.bs.dropdown', function () {
        let showlabel = ''
        $.each($('#dropdownCategoryMobile a .form-check-input'),function(index,value){
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
        $('#dropdownCategoryMobileLabel').text(showlabel);
    })

    const tagDropdownDesktop = document.getElementById('dropdownTagDesktopLabel')
    tagDropdownDesktop.addEventListener('hide.bs.dropdown', function () {
        let showlabel = ''
        $.each($('#dropdownTagDesktop a .form-check-input'),function(index,value){
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
            showlabel = 'All tags';
        }
        $('#dropdownTagDesktopLabel').text(showlabel);
    })

    const tagDropdownMobile = document.getElementById('dropdownTagMobileLabel')
    tagDropdownMobile.addEventListener('hide.bs.dropdown', function () {
        let showlabel = ''
        $.each($('#dropdownTagMobile a .form-check-input'),function(index,value){
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
            showlabel = 'All tags';
        }
        $('#dropdownTagMobileLabel').text(showlabel);
    })

    const clearselect = (typeclear) => {
        if(typeclear === 'tag'){
            $.each($('#dropdownTagDesktop a .form-check-input'),function(index,value){
                $(value).prop("checked",false);
            });
            $.each($('#dropdownTagMobile a .form-check-input'),function(index,value){
                $(value).prop("checked",false);
            });
        }
        if(typeclear === 'category'){
            $.each($('#dropdownCategoryDesktop a .form-check-input'),function(index,value){
                $(value).prop("checked",false);
            });
            $.each($('#dropdownCategoryMobile a .form-check-input'),function(index,value){
                $(value).prop("checked",false);
            });
        }

    }

    const filtercontent = (typewindows) => {
        let filter = {}
        filter.tags = []
        filter.category = []
        if(typewindows === 'desktop')
        {
            $.each($('.month-select-desktop'),function(index,value){
                if($(value).hasClass('check-selected')){
                    filter.month = $(value).attr('data');
                }
            });
            $.each($('.year-select-desktop'),function(index,value){
                if($(value).hasClass('check-selected')){
                    filter.year = $(value).attr('data');
                }
            });
            $.each($('#dropdownCategoryDesktop a .form-check-input'),function(index,value){
                if(value.checked){
                    filter.category.push(value.defaultValue);
                }
            })
            if(filter.category.length === 0){
                filter.category.push("all");
            }
            $.each($('#dropdownTagDesktop a .form-check-input'),function(index,value){
                if(value.checked){
                    filter.tags.push(value.defaultValue);
                }
            })
            if(filter.tags.length === 0){
                filter.tags.push("all");
            }
        }else{
            $.each($('.month-select-mobile'),function(index,value){
                if($(value).hasClass('check-selected')){
                    filter.month = $(value).attr('data');
                }
            });
            $.each($('.year-select-mobile'),function(index,value){
                if($(value).hasClass('check-selected')){
                    filter.year = $(value).attr('data');
                }
            });
            $.each($('#dropdownCategoryMobile a .form-check-input'),function(index,value){
                if(value.checked){
                    filter.category.push(value.defaultValue);
                }
            })
            if(filter.category.length === 0){
                filter.category.push("all");
            }
            $.each($('#dropdownTagMobile a .form-check-input'),function(index,value){
                if(value.checked){
                    filter.tags.push(value.defaultValue);
                }
            })
            if(filter.tags.length === 0){
                filter.tags.push("all");
            }
        }
        console.log(filter)
    }

</script>
@endsection
