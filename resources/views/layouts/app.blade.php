<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Linksy - link shortener & manager">
    <meta name="application-name" content="{{ config('app.name', 'Linksy') }}">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name', 'Linksy') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#0d6efd">
    <meta name="msapplication-TileColor" content="#0d6efd">

    <title>{{ config('app.name', 'Linksy') }}</title>

    <!-- Favicons / App icons -->

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="d-flex flex-column min-vh-100">

    @include('partials.navbar')

    <main class="flex-fill">
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
