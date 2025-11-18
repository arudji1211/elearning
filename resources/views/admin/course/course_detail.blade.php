@extends('layouts.course_manage')

@section('content')
<meta name="course_id" content="{{ $data->id }}">

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
                    <button type="button" data-modalid="modal-add-contents" class="closeModalBtn flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
                </form>
            </div>
    </div>
</div>

@foreach($data->contents as $b)

<div id="modal-edit-contents-{{ $b->id }}" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-10 p-5">
    <div class="rounded shadow-lg p-5 w-full md:w-4xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
            <div class="text-indigo-600 font-semibold text-xl text-center mt-3">
                Update Content Section
            </div>
            <div class="">
                <form method="POST" action="{{ route('admin.course.content.edit', ['id' => $data->id, 'content_id' => $b->id]) }}">
                    @csrf
                    <x-input label="Chapter" name="chapter" type="Number" value="{{ $b->chapter }}"/>
                    <x-input label="Title" name="title" type="text" value="{{ $b->title }}"/>
                    <div class="mb-2" id="description-{{ $b->id }}">
                        <label class="block text-sm/6 font-medium text-gray-900">Content</label>
                        <textarea id="myeditor-{{ $b->id }}" name="description" class="">

                        </textarea>
                    </div>
                <div class="mt-2 flex gap-2">
                    <button type="button" data-modalid="modal-edit-contents-{{ $b->id }}" class="closeModalBtn flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
                </form>
            </div>
    </div>
</div>


@endforeach

<div id="modal-add-tingkat-kesulitan" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-10 p-5">
    <div class="rounded shadow-lg p-5 w-full md:w-4xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
            <div class="text-indigo-600 font-semibold text-xl text-center mt-3">
                Tingkat Kesulitan
            </div>
            <div class="">
                <form method="POST" action="{{ route('admin.course.level.add', $data->id) }}">
                    @csrf
                    <x-input label="Level" name="level" type="text"/>
                    <x-input label="Delay Bot" name="delay" type="Number"/>

                <div class="mt-2 flex gap-2">
                    <button type="button" data-modalid="modal-add-tingkat-kesulitan" class="closeModalBtn flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
                </form>
            </div>
    </div>
</div>



@foreach($data->contents as $c)

<div id="modal-add-berkas-pendukung-{{ $c->id }}" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-10 p-5">
    <div class="rounded shadow-lg p-5 w-full md:w-md bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
            <div class="text-indigo-600 font-semibold text-xl text-center mt-3">
                Bahan Bacaan
            </div>
            <div class="">
                <form method="POST" action="{{ route('admin.course.berkas.add', $data->id) }}" enctype="multipart/form-data">
                    @csrf
                    <x-input label="Berkas" name="berkas" type="file"/>
                    <input type="hidden" name="content_id" value="{{$c->id}}"/>
                <div class="mt-2 flex gap-2">
                    <button type="button" data-modalid="modal-add-berkas-pendukung-{{ $c->id }}" class="closeModalBtn flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
                </form>
            </div>
    </div>
</div>

@endforeach

@foreach ($errors->get('error_details') as $error)
    <div class="text-red-500">{{ $error }}</div>
@endforeach
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
<!---- wrapper content ----->
<div class="flex flex-col sm:flex-row w-full flex-wrap gap-2">

    <!----- chapter ----->
    <div class="w-full sm:max-w-2/3">
            <div class="flex flex-col w-full rounded-sm bg-white shadow-sm p-5">
                <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                    Chapter
                </div>
                <div class="flex ">
                    <div class="border border-transparent border-r-gray-300 pe-5 pt-5 max-w-sm w-sm gap-2 flex flex-col">
                        <div class="text-end">
                            <button class="openModalBtn text-white bg-indigo-600 rounded-full shadow-sm hover:shadow-md hover:bg-indigo-700 w-7 aspect-square cursor-pointer" data-modalid="modal-add-contents">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <ul class="flex flex-wrap w-full" id="contentList">
                        @foreach($data->contents as $b)

                            <li class="mb-2 bg-violet-500 text-white font-semibold rounded-md p-2 shadow-xs hover:bg-violet-600 hover:shadow-sm  text-wrap w-full cursor-pointer"
                                data-id="{{ $b->id }}" data-chapter="{{ $b->chapter }}" data-title="{{ $b->title }}" data-description="{{ $b->description }}" data-deletelink="{{ route('admin.content.delete', $b->id) }}" data-task='@json($b->task)' data-berkaspendukung='@json($b->berkas_pendukung)'> {{ $b->chapter }} . {{ $b->title }}</li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="flex-1 p-5">
                        <div class="flex justify-end gap-1" id="contentsAction">

                        </div>
                        <div class="prose max-w-none p-2" id="contentsDescription">

                        </div>

                        <div id="contentsBacaanWajib" class="p-5 border border-transparent border-t-gray-300 flex flex-col gap-2">

                        </div>
                    </div>
                </div>

            </div>

    <!--- end of chapter ---->
    </div>
    <!------- enrollment ---------->
    <div class="w-full flex-1 flex flex-col gap-2">
       <div class="flex flex-col w-full rounded-sm shadow-sm p-5 gap-2 bg-white">
            <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                    Leaderboard
            </div>
            <ul class="flex flex-col gap-1" id="leaderboard_container">

            </ul>
        </div>
        <div class="flex flex-col w-full rounded-sm shadow-sm  p-5 gap-2 bg-white">
            <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                    Participants
            </div>
            <ul class="gap-4">
                @foreach($users as $e)
                <li class="shadow-xs rounded px-1 text-m flex gap-2 py-2 justify-between">
                    <div class="flex gap-2">
                             @if($e->image != null)

                                <div>
                                    <img src="{{ asset('storage/' . $e->image->path) }}" class="size-10 rounded-full outline -outline-offset-1 outline-white/10 mx-auto"/>
                                </div>

                            @endif
                            @if($e->image == null)
                                <div>
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full outline -outline-offset-1 outline-white/10 mx-auto"/>
                                </div>

                            @endif

                                                <div class="flex items-baseline">
                            <p>
                                {{ $e->first_name }} {{ $e->last_name }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-1 user_point_adjustment_form" data-courseId="{{ $data->id }}" data-id="{{ $e->id }}" data-endpoint="{{ route('admin.point.adjustment') }}">
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
    <!---- end of wrapper content ----->
    <div id="pageid" data-id="course_admin">

    </div>
</div>
@endsection


