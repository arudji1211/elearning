<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'My App') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   @vite(['resources/css/app.css','resources/js/app.js']) {{-- Tailwind --}}

</head>
<body>
    <x-navbar />

    <div class="w-full">
        @yield('content')
    </div>
</body>
</html>

