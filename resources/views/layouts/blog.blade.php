<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>@yield('title')</title>

    @yield('meta')

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('/images/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{ asset('/images/favicon/safari-pinned-tab.svg')}}" color="#182b45">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    @include('layouts.stylesheet-blog')
    @yield('stylesheet')
</head>
<body>
    <!-- Header -->
    @include('layouts.header-blog')
    <main>
    <!-- Content -->
    @yield('content')
    </main>
    @include('layouts.footer-blog')
    <!-- Plugin Script -->
    @include('layouts.javascript-blog')
    @yield('script')
</body>
</html>
