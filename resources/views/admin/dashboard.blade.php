@extends('layouts.course_manage')

@section('content')

<!-----
<div class="shadow-md rounded-lg p-6">
    <div class="text-indigo-600 font-semibold text-lg">
        My Profile
    </div>
    <div class="">
        <div class="mx-auto text-center">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-50 rounded-full outline -outline-offset-1 outline-white/10 mx-auto" />
        </div>
        <div class="mx-auto text-center text-lg mt-1">
            Arudji Hermatyar, S.Kom.
        </div>
        <div class="mx-auto text-center text-indigo-600 opacity-85"> Teknik Informatika</div>

    </div>
</div>
----->

    <!--------------- Wrapper ----------------->
    <div class="flex flex-col sm:flex-row gap-2 items-start">
        <!----------- main ---->
        <div class="flex sm:flex-1 w-full flex-col gap-2">
            <!----- body ------------------------>
            <div class="flex flex-col bg-white rounded-sm shadow-sm w-full p-5 gap-2 flex-wrap">
                <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                    Dashboard
                </div>
                <div class="flex flex-wrap gap-4">
                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8 mw-md">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/input category.svg')) !!}
                        </div>
                        <a class="bg-indigo-600 text-white rounded-lg p-1 text-center" href="{{  route('admin.course_category.manage') }}">
                            Course Category
                        </a>
                    </div>

                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8 mw-md">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/Input soal.svg')) !!}
                        </div>
                        <a class="bg-indigo-600 text-white rounded-lg p-1 text-center" href="{{ route('admin.course.manage') }}">
                            Course
                        </a>
                    </div>

                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/enrollment manage.svg')) !!}
                        </div>
                        <div class="bg-indigo-600 text-white rounded-lg p-1 text-center">
                            Enrollment
                        </div>
                    </div>


                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/beripoint.svg')) !!}
                        </div>
                        <a class="bg-indigo-600 text-white rounded-lg p-1 text-center" href="{{ route('admin.mission.dashboard') }}">
                            Event
                        </a>
                    </div>

                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/manage users.svg')) !!}
                        </div>
                        <div class="bg-indigo-600 text-white rounded-lg p-1 text-center">
                            User
                        </div>
                    </div>

                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/beripoint.svg')) !!}
                        </div>
                        <div class="bg-indigo-600 text-white rounded-lg p-1 text-center">
                            Report
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex flex-col bg-white rounded-sm shadow-sm w-full p-5 gap-2 flex-wrap">
                <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                    Courses
                </div>
                <div class="flex flex-col md:flex-row md:justify-normal gap-5 justify-center-safe md:max-w-sm">
                    @foreach ($course as $c)
                        <x-card title="{{ $c->title }}" description="{{ $c->description }}" image_path="{{ $c->image->path }}" id="{{ $c->id }}" category_title="{{ $c->category->title }}" />
                    @endforeach
                </div>
            </div>

            <!---- eof body---------------------->
        </div>
        <!-------- eof main ---->

        <!--------aside------>
        <div class="flex flex-col w-full sm:w-md gap-2 flex-none">
            <div class="flex flex-col w-full rounded-sm shadow-sm p-5 gap-2 bg-white">
                <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                    Leaderboard
                </div>
                <ul class="flex flex-col gap-1" id="leaderboard_container">

                </ul>
            </div>

            <div class="flex flex-col w-full rounded-sm shadow-sm p-5 gap-2 bg-white">
                <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                    Participants
                </div>
                <ul class="flex flex-col gap-1" id="leaderboard_container">
                    @foreach($user as $e)
                    <li class="shadow-xs rounded text-m flex gap-2 py-2 justify-between">
                        <div class="flex gap-2">
                            <div>
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full outline -outline-offset-1 outline-white/10 mx-auto"/>
                            </div>
                            <div class="flex items-baseline">
                                <p>
                                    {{ $e->first_name }} {{ $e->last_name }}
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-1 user_point_adjustment_form" data-id="{{ $e->id }}" data-endpoint="{{ route('admin.point.adjustment') }}">
                            <button type="button" data-tipe="credit"  class="action_btn bg-rose-500 text-white font-bold shadow-sm hover:bg-rose-600 hover:shadow-md cursor-pointer w-10 aspect-ratio rounded-full">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input type="number" id="adjust_user_point" class="w-20 rounded-sm p-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <button type="button" data-tipe="debit" class="action_btn bg-emerald-500 text-white shadow-sm hover:bg-emerald-600 hover:shadow-md cursor-pointer w-10 aspect-ration rounded-full">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>
        <!----eof aside------->
    </div>
    <!------------- eof Wrapper ----------------->
    <div id="pageid" data-id="dashboard_admin">

    </div>

@endsection





