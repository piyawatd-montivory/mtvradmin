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
<!-- Latest compiled and minified CSS -->
<style>

</style>
@endsection
@section('content')
<!-- Content -->
<section class="content">
    <div class="container pt-5">
        <h3 class="hero-title pb-4">Tag : Politic</h3>
        <div class="row filter-block">
            <div class="col-12 d-none d-md-block">
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
                            <button class="btn custom-dropdown dropdown-toggle w-100 text-start" type="button" id="dropdownCategory" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                All categories
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownCategory">
                                <li>
                                    <a class="dropdown-item tag-clear" href="javascript:cleartag();">CLEAR</a>
                                </li>
                                <li>
                                    <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-desktop" value="binary-craft" label="Binary Craft">Binary Craft</a>
                                </li>
                                <li>
                                    <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-desktop" value="business" label="Business">Business</a>
                                </li>
                                <li>
                                    <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-desktop" value="creative" label="Creative">Creative</a>
                                </li>
                                <li>
                                    <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-desktop" value="data-and-tech" label="Data and Tech">Data and Tech</a>
                                </li>
                                <li>
                                    <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-desktop" value="privacy" label="Privacy">Privacy</a>
                                </li>
                                <li>
                                    <a class="dropdown-item tag-select" data="all"><input type="checkbox" class="form-check-input form-check-input-desktop" value="research" label="Research">Research</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-3">
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
                                <button class="btn custom-dropdown dropdown-toggle w-100 text-start ps-0 dropdownCategory" type="button" id="dropdownCategoryMobile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    All categories
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownCategoryMobile">
                                    <li>
                                        <a class="dropdown-item tag-clear" href="javascript:cleartag();">CLEAR</a>
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

    const cleartag = () => {
        $.each($('.form-check-input'),function(index,value){
            $(value).prop("checked",false);
        });
    }

    const filtercontent = (typewindows) => {
        let filter = {}
        let category = []
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
            $.each($('.form-check-input-desktop'),function(index,value){
                if(value.checked){
                    category.push(value.defaultValue);
                }
            })
            if(tags.length === 0){
                category.push("all");
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
            $.each($('.form-check-input-mobile'),function(index,value){
                if(value.checked){
                    category.push(value.defaultValue);
                }
            })
            if(category.length === 0){
                category.push("all");
            }
        }
        filter.category = category;
        console.log(filter)
    }

</script>
@endsection
