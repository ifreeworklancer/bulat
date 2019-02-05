<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @isset($page_title)
            {{ $page_title . ' | ' }}
        @endisset
        {{ config('app.name') }}
    </title>

    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="preload" href="{{ asset('css/app.css') }}" as="style">
    <link rel="preload" href="{{ asset('js/app.js') }}" as="script">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
@includeIf('partials.app.layout.icons')
@include('partials.app.layout.header')
<main id="app" v-cloak>
    @yield('content')
</main>
@include('partials.app.layout.footer')
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
