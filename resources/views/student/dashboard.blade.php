@extends('layouts.course_manage')

@section('content')

    @if (session('response'))
        <div class="absolute right-0 bottom-0 z-50 p-3" id="alert">
            <div class="sticky p-6 bg-emerald-500 rounded-md shadow-lg">
                <div class="text-center text-white font-semibold text-xl">
                    Notification
                </div>
                <ul>
                    @foreach ((array)session('response') as $n)
                        <li class="text-white">{{ $n }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    @if ($errors->any())
        <div class="absolute right-0 bottom-0 z-50 p-3" id="alert">
            <div class="sticky p-6 bg-red-800 rounded-md shadow-lg">
                <div class="text-center text-white font-semibold text-xl">
                    Error Notification
                </div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-white">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
<div class="w-full flex gap-2 items-start">
    <!-----card container------>
    <div class="shadow-sm rounded-sm p-5 flex flex-col gap-4 flex-1 bg-white">
        <div class="text-3xl text-indigo-600 font-semibold border border-transparent border-b-gray-300 pb-2">
            Courses
        </div>
        <div class="flex flex-col md:flex-row md:justify-normal gap-5 justify-center-safe md:max-w-sm">
            @foreach ($course as $c)
                <x-card-student title="{{ $c->title }}" description="{{ $c->description }}" image_path="{{ $c->image->path }}" id="{{ $c->id }}" category_title="{{ $c->category->title }}" />
            @endforeach
        </div>
    </div>
    <!--- end of card container--->
    <!---------- side -------->
    <div class="flex flex-col max-w-md md:w-md gap-2">
        <!--------- event ---------->
        <div class="flex flex-col shadow-md rounded-md py-5 px-3 gap-2 bg-white">
            <div class="text-3xl text-indigo-600 font-semibold border border-transparent border-b-gray-300 pb-2">
                Event
            </div>
            <div class="flex flex-col gap-2" id="event_container">
            </div>
        </div>
        <!-----------eof event------------->

        <!--------- practice ---------->
        <div class="flex flex-col shadow-md rounded-md py-5 px-3 gap-2 bg-white">
            <div class="text-3xl text-indigo-600 font-semibold border border-transparent border-b-gray-300 pb-2">
                Practice
            </div>
            <div class="flex gap-2" id="game_container">
                @foreach($game as $g)
                <div class="flex flex-col rounded-sm shadow-sm p-3 gap-2 hover:shadow-md w-60 aspect-ratio">
                    <img src="{{ Vite::asset('resources/svg/game.svg') }}" class="mx-auto "/>
                    <div class="flex flex-col gap-2 ">
                        <div class="text-lg text-center text-indigo-500 font-semibold">
                            {{ $g->title }}
                        </div>
                        <div class="text-slate-900 text-sm">
                            {{ $g->description }}
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('student.game.create.session', ['id' => $g->id]) }}" class="p-1 shadow-sm text-center rounded-sm bg-violet-500 hover:bg-violet-600 text-white font-semibold w-full">tantang</a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <!-----------eof practice------------->



        <!-------- leaderboard--------->
        <div class="flex flex-col shadow-md rounded-md py-5 px-3 gap-2 bg-white">
            <div class="text-3xl text-indigo-600 font-semibold border border-transparent border-b-gray-300 pb-2">
                Leaderboard
            </div>
            <ul class="gap-2" id="leaderboard_container">

            </ul>
        </div>
        <!-------- eof leaderboard -------->

    </div>
    <!---------- eof side -------->

</div>
<div id="pageid" data-id="dashboard_student"></div>
@endsection
