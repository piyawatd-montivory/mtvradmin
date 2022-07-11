@extends('layouts.template')
@section('title')
@endsection
@section('meta')

@endsection
@section('stylesheet')
@endsection
@section('content')
<main id="content">

    <section class="error404">
        <div class="container">
            <div class="sc-inner">
                <div class="error-content">
                    <h2 class="error-text">404</h2>
                    <h2 class="error-text">PAGE NOT FOUND</h2>
                </div>
                <a href="{{ route('home') }}" class="btn">BACK TO HOMEPAGE</a>
                <img alt="" src="{{ asset('/images/frontend/404.jpg')}}" class="error-img">
            </div>
        </div>
    </section>

</main>
@endsection
@section('scripts')
@endsection
