<!DOCTYPE html>
{{--@langrtl--}}
{{--    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">--}}
{{--@else--}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{--@endlangrtl--}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', 'Laravel Startup')">
    <meta name="author" content="@yield('meta_author', 'Sam Ngu | Acadea')">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

@yield('meta')

@stack('before-styles')

    <link rel="stylesheet" href="{{mix('css/app.css')}}">


@stack('after-styles')
</head>
<body>
<div id="app">

    @yield('content')

</div><!-- #app -->

<!-- Scripts -->
@stack('before-scripts')
<script src="{{mix('js/manifest.js')}}"></script>
<script src="{{mix('js/vendor.js')}}"></script>
@stack('after-scripts')

@include('includes.partials.ga')
</body>
</html>
