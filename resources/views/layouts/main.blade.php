<!doctype html>
<html lang="{{ App::getLocale() }}">
    <head>
        <title>
            {{ (isset($title) ? $title . ' - ' : '') . config('app.name') }}
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ Lang::get('main.description') }}">
        <meta name="keywords" content="jonaszkadziela, jonasz, kądziela, portfolio, personal, website">
        <meta name="author" content="Jonasz Kądziela">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:locale" content="{{ App::getLocale() }}">
        <meta property="og:locale:alternate" content="{{ App::getFallbackLocale() }}">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:title" content="{{ (isset($title) ? $title . ' - ' : '') . config('app.name') }}">
        <meta property="og:description" content="{{ Lang::get('main.description') }}">
        <meta property="og:url" content="{{ config('app.url') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="{{ isset($bodyClass) ? $bodyClass : '' }}">
        {{ $slot }}
    </body>
</html>
