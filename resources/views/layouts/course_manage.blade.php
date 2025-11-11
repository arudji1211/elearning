<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{{ config('app.name', 'My App') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(['resources/css/app.css','resources/js/app.js']) {{-- Tailwind --}}
    </head>

    <body class="bg-gray-50">
        <x-navbar />
        @yield('content')
    </body>
</html>


