@extends('layouts.admin_dashboard')

@section('content')

<div class="w-full">
    <!-----card container------>
    <div class="shadow-md rounded-lg p-6 flex flex-col gap-5">
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
</div>
@endsection
