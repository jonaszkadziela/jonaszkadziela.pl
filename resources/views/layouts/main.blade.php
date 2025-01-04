<!doctype html>
<html lang="{{ App::getLocale() }}" class="{{ Session::get('theme', config('app.default_theme')) }}">
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
        <meta property="og:image" content="{{ Vite::asset('resources/images/brand/og-image.jpg') }}">
        <meta property="og:url" content="{{ config('app.url') }}">
        <link href="{{ Vite::asset('resources/images/brand/favicon.png') }}" rel="shortcut icon" type="image/png">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="{{ isset($bodyClass) ? $bodyClass : '' }}">
        {{ $slot }}
    </body>
</html>
