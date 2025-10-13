@extends('layouts.admin_dashboard')

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
<div class="shadow-md rounded-lg p-6 flex flex-col gap-7">
    <div class="text-indigo-600 font-semibold text-3xl">
        Dashboard
    </div>
    <div class="flex flex-wrap gap-5">
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
            <div class="bg-indigo-600 text-white rounded-lg p-1 text-center">
                Event
            </div>
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

<div class="shadow-md rounded-lg p-6 flex flex-col gap-5">
    <div class="text-indigo-600 font-semibold text-3xl">
        Courses
    </div>
    <div class="flex flex-col md:flex-row md:justify-normal gap-5 justify-center-safe md:max-w-sm">
        @foreach ($course as $c)
        <x-card title="{{ $c->title }}" description="{{ $c->description }}" image_path="{{ $c->image->path }}" id="{{ $c->id }}" category_title="{{ $c->category->title }}" />
        @endforeach
    </div>


</div>




@endsection
