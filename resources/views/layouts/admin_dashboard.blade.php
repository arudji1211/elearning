<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'My App') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css','resources/js/app.js']) {{-- Tailwind --}}
</head>

<body class="">

    <x-navbar />
       <div class="flex gap-2 items-start flex-col md:flex-row">
        <div class="flex-1 flex flex-col gap-4 w-full">
            @yield('content')
        </div>
        <aside class="flex flex-col flex-none w-full md:max-w-md gap-5" >
            <x-leader-board />
            <x-events />
        </aside>

    </div>

    </body>
</html>

