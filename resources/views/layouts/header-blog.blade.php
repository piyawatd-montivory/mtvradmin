<?php
    $catesel = '';
    if(isset($category)){
        $catesel = $category->slug;
    }else{
        $catesel = isset(app('request')->slug)?app('request')->slug:'';
    }
?>
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img alt="Header Logo" class="logo" src="{{ asset('/images/frontend/montivory-logo.svg')}}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-nav ms-auto">
                <a class="nav-link" aria-current="page" href="{{ route('career') }}">CAREER</a>
                <a class="nav-link active" aria-current="blog" href="{{ route('blog') }}">READ.MONTIVORY.COM</a>
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid navbar-second">
    <div class="row">
        <div class="col-md-12 d-none d-md-block navbar-second-item px-0 justify-content-center">
            <ul class="px-0 mx-auto my-0">
                <li class="nav-item">
                  <a class="nav-link @if($catesel === 'binary-craft') category-active @endif" href="{{route('category',['slug'=>'binary-craft'])}}">BINARY.CRAFT</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @if($catesel === 'business') category-active @endif" href="{{route('category',['slug'=>'business'])}}">BUSINESS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @if($catesel === 'creative') category-active @endif" href="{{route('category',['slug'=>'creative'])}}">CREATIVE</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @if($catesel === 'data-and-tech') category-active @endif" href="{{route('category',['slug'=>'data-and-tech'])}}">DATA AND TECH</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($catesel === 'privacy') category-active @endif" href="{{route('category',['slug'=>'privacy'])}}">PRIVACY</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($catesel === 'research') category-active @endif" href="{{route('category',['slug'=>'research'])}}">RESEARCH</a>
                </li>
                <li class="nav-item search-block">
                    <button type="button" class="btn search-desktop" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <img src="{{asset('images/icon/Search-icon-w.png')}}" class="search-icon"/>
                    </button>
                </li>
            </ul>
        </div>
        <div class="col-10 d-md-none navbar-second-item navbar-second-mobile">
            <ul>
                <li class="nav-item">
                  <a class="nav-link @if($catesel === 'binary-craft') category-active @endif" href="{{route('category',['slug'=>'binary-craft'])}}">BINARY.CRAFT</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @if($catesel === 'business') category-active @endif" href="{{route('category',['slug'=>'business'])}}">BUSINESS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @if($catesel === 'creative') category-active @endif" href="{{route('category',['slug'=>'creative'])}}">CREATIVE</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link @if($catesel === 'data-and-tech') category-active @endif" href="{{route('category',['slug'=>'data-and-tech'])}}">DATA AND TECH</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($catesel === 'privacy') category-active @endif" href="{{route('category',['slug'=>'privacy'])}}">PRIVACY</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($catesel === 'research') category-active @endif" href="{{route('category',['slug'=>'research'])}}">RESEARCH</a>
                </li>
            </ul>
        </div>
        <div class="col-2 d-md-none mobile-search-block text-center px-0">
            <button type="button" class="btn btn-search px-0 py-0" data-bs-toggle="modal" data-bs-target="#searchModal">
                <img src="{{asset('images/icon/Search-icon-w.png')}}" class="search-icon-mobile"/>
            </button>
        </div>
    </div>
</div>
