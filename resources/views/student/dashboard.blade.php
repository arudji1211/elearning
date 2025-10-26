@extends('layouts.app')

@section('content')

<div class="w-full flex gap-2">
    <!-----card container------>
    <div class="shadow-md rounded-lg p-5 flex flex-col gap-4 flex-1">
        <div class="text-indigo-600 font-semibold text-3xl">
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
        <div class="flex shadow-md rounded-md py-5 px-3 gap-2">
            <div class="text-3xl text-indigo-600 font-semibold border border-transparent border-b-gray-300">
                Event
            </div>
        </div>
        <!-----------eof event------------->
        <!-------- leaderboard--------->
        <div class="flex flex-col shadow-md rounded-md py-5 px-3 gap-2">
            <div class="text-3xl text-indigo-600 font-semibold border border-transparent border-b-gray-300">
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
