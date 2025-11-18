
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{ config('app.name', 'My App') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css','resources/js/app.js']) {{-- Tailwind --}}
    </head>
    <body style="background-image: url({{ asset('img/background.webp')}})" class="bg-cover">
        <div class="absolute inset-0 bg-white opacity-75"></div>
        <div class="relative min-h-screen content-center">
            <div class="flex gap-2 content-center">
                <div class="gap-2 flex flex-col w-md max-w-md shadow-sm rounded-sm bg-indigo-600 " id="userContainer">
                    <div class="gap-2 flex p-4 ml-auto" id="points">

                    </div>
                    <div class="pb-5" id="userProfile">
                        <div class="flex justify-center" >
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-35 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" id="userfoto"/>
                        </div>
                        <div class="text-2xl text-white font-semibold text-center" id="userName">

                        </div>
                    </div>
                </div>

                <div class="flex-1 shadow-sm rounded-sm border border-gray-200 bg-white" id="soalContainer">
                    <div class="flex justify-end" id="soal_timer">

                        <div id="timercountdown" class="text-white bg-violet-500 flex-wrap p-2 font-semibold flex-none">
                            00:00
                        </div>
                    </div>
                    <div id="soal_container" class="p-5 flex flex-col gap-4">
                        <div id="soal" class="text-slate-900 text-xl p-1 font-semibold" id="plainSoal">

                        </div>
                        <div id="jawaban" class="flex flex-col gap-2">

                        </div>
                        <div id="action">

                        </div>

                    </div>
                </div>
                <div class="gap-2 flex flex-col w-md max-w-md shadow-sm rounded-sm bg-indigo-600 flex-none" id="botContainer">
                    <div class="gap-2 flex p-4" id="points_bot">

                    </div>
                    <div class="pb-5" id="botProfile">
                        <div class="flex justify-center">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-35 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
                        </div>
                        <div class="text-2xl text-white font-semibold text-center">
                            Kick Andy
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="pageid" data-id="game_session" data-user='@json($user)' data-endpoints='@json($endpoints)'>

        </div>
    </body>
</html>

