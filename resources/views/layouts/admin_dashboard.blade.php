<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'My App') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css','resources/js/app.js']) {{-- Tailwind --}}
</head>

<body style="background-image: url({{Vite::asset('resources/img/background.webp')}})" class="bg-cover">
    <div class="absolute inset-0 bg-white opacity-80 h-full"></div>


    <div class="relative">
        <x-navbar />
        <div class="flex gap-2 items-start flex-col md:flex-row">
            <div class="flex flex-1 flex-col gap-2 w-full">
                @yield('content')
            </div>
            <aside class="flex flex-col flex-none w-full md:max-w-md gap-2">
                <x-leader-board />
                <x-events />
            </aside>
        </div>
    </div>

</body>
</html>

