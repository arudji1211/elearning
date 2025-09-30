@extends('layouts.admin_dashboard')

@section('content')

<div id="modal-add-contents" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-10 p-5">
    <div class="rounded shadow-lg p-5 w-full md:w-4xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
            <div class="text-[#f53003] font-semibold text-xl text-center mt-3">
                New Content Section
            </div>
            <div class="">
                <form method="POST" action="{{ route('admin.course.content.add', $data->id) }}">
                    @csrf
                    <x-input label="Chapter" name="chapter" type="Number"/>
                    <x-input label="Title" name="title" type="text"/>
                    <div class="mb-2">
                        <label class="block text-sm/6 font-medium text-gray-900">Content</label>
                        <textarea id="myeditor" name="description" class=""></textarea>
                    </div>
                <div class="mt-2 flex gap-2">
                    <button type="button" data-modalid="modal-add-contents" class="closeModalBtn flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-[#f53003] px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f53003]">Save</button>
                </div>
                </form>
            </div>
    </div>
</div>

@foreach($data->contents as $c)
<div id="modal-add-task-{{ $c->id }}" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-15 p-5">
    <div class="rounded shadow-lg p-5 w-full md:w-xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
            <div class="text-[#f53003] font-semibold text-xl text-center mt-3">
                New Task Section
            </div>
            <div class="">
                <form method="POST" action="{{ route('admin.course.content.add', $data->id) }}">
                    @csrf

                    <x-input label="Title" name="title" type="text"/>
                    <div class="flex flex-col md:flex-row gap-2 justify-between">
                        <x-input label="Start Time" name="event-start" type="date" />
                        <x-input label="End Time" name="event-stop" type="date" />
                    </div>

                <div class="mt-2 flex gap-2">
                    <button type="button" data-modalid="modal-add-task-{{ $c->id }}" class="closeModalBtn flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-[#f53003] px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f53003]">Save</button>
                </div>
                </form>
            </div>

    </div>
</div>
@endforeach

<div class="flex flex-col gap-5">
    <div class="gap-5 p-6 flex flex-col gap-5 shadow-sm rounded-lg">
        <div class="text-[#f53003] font-semibold text-3xl">
            Manage Course
        </div>

        <div class="flex flex-col gap-2 rounded-lg w-full">
            <div>
                <div class="relative w-full">
                    <div class="absolute font-semibold text-center p-2 rounded-xs shadow-xs bg-[#f53003] text-white inset-x-0 bottom-0 text-md md:text-lg">{{ $data->title }}</div>
                    <img src="{{ asset('storage/' . $data->image->path) }}" class="w-full rounded-md"/>

                </div>
            </div>
            <div class="flex flex-col gap-2">
                <div class="md:text-xl">
                    {{ $data->description }}
                </div>
            </div>
        </div>


    </div>

    @foreach($data->contents as $c)
    <div class="gap-2 flex flex-col shadow-sm rounded-lg">
            <div class="font-semibold text-lg md:text-xl px-5 py-1 text-[#f53003] ">
                {{ $c->title }}
            </div>
            <div class="p-5 border border-transparent border-t-gray-300">
                <div class="flex justify-end gap-1">
                    <a href="{{ route('admin.content.delete', $c->id) }}"><div  class="p-2 rounded-lg bg-orange-600 text-white hover:bg-orange-500 max-w-24 w-full"> Edit </div> </a>
                    <a href="{{ route('admin.content.delete', $c->id) }}"><div class="p-2 rounded-lg bg-red-600 text-white hover:bg-red-500 max-w-24 w-full"> Delete </div> </a>
                </div>

                <div class="prose max-w-none p-2">
                    {!! $c->description !!}
                </div>


            </div>
            <div class="p-5 border border-transparent border-t-gray-300">
                <button type="button" data-modalid="modal-add-task-{{ $c->id }}" class="openModalBtn bg-[#f53003] rounded-md text-center text-white align-baseline p-2 font-semibold text-md hover:shadow-md hover:bg-indigo-500"> add task </button>
            </div>
    </div>
    @endforeach

    <div class="flex justify-center flex-wrap pb-5">
        <div class="text-center">
            <button type="button" data-modalid="modal-add-contents" class="openModalBtn bg-[#f53003] rounded-md text-center text-white align-baseline p-3 font-semibold text-md shadow-md hover:shadow-lg hover:bg-indigo-500"> new chapter </button>
        </div>
    </div>
</div>

@endsection

