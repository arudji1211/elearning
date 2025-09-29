@extends('layouts.admin_dashboard')

@section('content')

<div id="modal-add-contents" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-10 p-5">
    <div class="rounded shadow-lg p-5 w-full md:w-4xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
            <div class="text-indigo-600 font-semibold text-xl text-center mt-3">
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
                    <button type="button" id="closeModalBtn" data-modalid="modal-add-contents" class="flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
                </form>
            </div>

    </div>

</div>

<div class="flex flex-col gap-5">
    <div class="gap-5 p-6 flex flex-col gap-5 shadow-sm rounded-lg">
        <div class="text-indigo-600 font-semibold text-3xl">
            Manage Course
        </div>

        <div class="flex flex-col gap-2 rounded-lg w-full">
            <div>
                <div class="relative w-full">
                    <div class="absolute font-semibold text-center p-2 rounded-xs shadow-xs bg-indigo-600 text-white inset-x-0 bottom-0 text-md md:text-lg">{{ $data->title }}</div>
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
            <div class="font-semibold text-lg md:text-xl px-5 py-1 text-indigo-600 ">
                {{ $c->title }}
            </div>
            <div class="p-5 border border-transparent border-t-gray-300">
                <div class="prose block">
                    {!! $c->description !!}
                </div>

            </div>
    </div>
    @endforeach

    <div class="flex justify-center flex-wrap pb-5">
        <div class="text-center">
            <button type="button" id="openModalBtn" data-modalid="modal-add-contents" class="bg-indigo-600 rounded-md text-center text-white align-baseline p-3 font-semibold text-lg hover:shadow-md hover:bg-indigo-500"> new chapter </button>
        </div>
    </div>
</div>

@endsection

