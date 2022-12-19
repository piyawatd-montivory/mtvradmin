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
<section class="hero-section">
    <img src="{{ asset('images/default/cover-image.jpg') }}" class="img-fluid hero-content-banner mx-auto d-block"/>
    <div class="container-fluid hero-content">
        <h3 class="hero-title">Binary Craft</h3>
        <h6>Description</h6>
    </div>
</section>
<section class="content">
    <div class="container pt-4">
        <div class="row">
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
                    </div>
                    <div class="col-3">
                        <button class="btn btn-readnow px-3" type="button" onclick="filtercontent('desktop');" >APPLY</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="d-grid gap-2 col-12">
                <button type="button" class="btn btn-primary" onclick="filtercontent('mobile');">APPLY</button>
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

    const tagDropdown = document.getElementById('dropdownTag')
    tagDropdown.addEventListener('hide.bs.dropdown', function () {
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
            showlabel = 'All tags';
        }
        $('#dropdownTag').text(showlabel);
    })

    const tagDropdownMobile = document.getElementById('dropdownTagMobile')
    tagDropdownMobile.addEventListener('hide.bs.dropdown', function () {
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
            showlabel = 'All tags';
        }
        $('#dropdownTagMobile').text(showlabel);
    })

    const cleartag = () => {
        $.each($('.form-check-input'),function(index,value){
            $(value).prop("checked",false);
        });
    }

    const filtercontent = (typewindows) => {
        let filter = {}
        let tags = []
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
                    tags.push(value.defaultValue);
                }
            })
            if(tags.length === 0){
                tags.push("all");
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
                    tags.push(value.defaultValue);
                }
            })
            if(tags.length === 0){
                tags.push("all");
            }
        }
        filter.tags = tags;
        console.log(filter)
    }

</script>
@endsection
