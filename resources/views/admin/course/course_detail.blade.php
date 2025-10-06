@extends('layouts.course_manage')

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
                    <button type="button" data-modalid="modal-add-contents" class="closeModalBtn flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
                </form>
            </div>
    </div>
</div>

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

<div id="modal-add-soal" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-10 p-5">
    <div class="rounded shadow-lg p-5 w-full md:w-4xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
            <div class="text-indigo-600 font-semibold text-xl text-center mt-3">
                Soal
            </div>
            <div>
                <form method="POST" action="{{ route('admin.course.soal.add', $data->id) }}" class="" enctype="multipart/form-data">
                    @csrf
                    <x-input label="Pertanyaan" name="soal_description" type="text"/>
                    <div class="mb-2">
                        <label class="block text-sm/6 font-medium text-gray-900">
                            level
                        </label>
                        <select name="level_id" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            @foreach($data->level as $level)
                            <option value="{{ $level->id }}">
                                {{ $level->level }}
                            </option>
                            @endforeach
                        </select>

                    </div>
                    <x-input label="Image" name="soal_image" type="file"/>

                        @for ($i = 1;$i < 5;$i++)
                        <div class="mt-2 pt-5">

                        <div class="text-center border border-transparent  border-t-gray-300 py-4 mb-2 text-indigo-600">
                            Answer {{ $i }}
                        </div>
                        <x-input label="description" name="answer[{{$i}}][description]" type="text"/>
                        <x-input label="image" name="answer[{{$i}}][image]" type="file"/>
                        <div class="mb-2 flex gap-2">

                            <input type="checkbox" value="is_true" name="answer[{{$i}}][is_true]" class="border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                            <label class="block text-sm/6 font-medium text-gray-900">
                                Jawaban Benar ?
                            </label>
                        </div>
                        </div>
                        @endfor

                <div class="mt-2 flex gap-2">
                    <button type="button" data-modalid="modal-add-soal" class="closeModalBtn flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f53003]">Save</button>
                </div>
                </form>
            </div>
    </div>
</div>


@foreach($data->contents as $c)
<div id="modal-add-task-{{ $c->id }}" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-15 p-5">
    <div class="rounded shadow-lg p-5 w-full md:w-xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
            <div class="text-indigo-600 font-semibold text-xl text-center mt-3">
                New Task Section
            </div>
            <div class="">
                <form method="POST" action="{{ route('admin.course.content.task.add', ['course_id' => $data->id, 'content_id' => $c->id]) }}">
                    @csrf

                    <x-input label="Title" name="title" type="text"/>
                    <div class="flex flex-col md:flex-row gap-2 justify-between">
                        <x-input label="Start Time" name="event_start" type="date" />
                        <x-input label="End Time" name="event_stop" type="date" />
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm/6 font-medium text-gray-900">
                            Tambah Soal
                        </label>
                        <input id="search_soal" placeholder="Cari soal" type="text" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        <div id="search-results" class="mt-1 w-full bg-white border border-gray-300 rounded shadow hidden">
                            @foreach($data->question as $s)
                                <div class="p-2 hover:bg-indigo-100 border border-transparent border-b-gray-100 cursor-pointer search-item"
                                    data-id="{{ $s->id }}"
                                    data-description="{{ $s->description }}">
                                    {{ $s->description }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="selected-products" class="space-y-4 my-4">
                        <div class="text-indigo-600 font-semibold text-lg text-center border border-transparent border-y-gray-300 py-1">
                            List Soal
                        </div>
                    </div>


                <div class="mt-2 flex gap-2">
                    <button type="button" data-modalid="modal-add-task-{{ $c->id }}" class="closeModalBtn flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f53003]">Save</button>
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
<div class="flex flex-col sm:flex-row w-full flex-wrap">
    <!---- quick action ---->
    <div class="w-full sm:max-w-1/2 p-2">
        <div class="flex flex-col w-full rounded-sm bg-white shadow-sm gap-5 p-5 h-full">
            <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                Quick Action
            </div>

            <div class="flex flex-col gap-5 rounded-lg w-full">
                <div class="flex justify-center-safe flex-wrap gap-2 sm:justify-normal">
                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8 max-w-md">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/input category.svg')) !!}
                        </div>
                        <button type="button" data-modalid="modal-add-soal" class="openModalBtn bg-indigo-600 text-white rounded-lg p-1 text-center hover:shadow-lg hover:bg-indigo-500"> Soal </button>
                    </div>
                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8 max-w-md">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/input category.svg')) !!}
                        </div>
                        <button type="button" data-modalid="modal-add-tingkat-kesulitan" class="openModalBtn bg-indigo-600 text-white rounded-lg p-1 text-center hover:shadow-lg hover:bg-indigo-500"> Tingkat Kesulitan </button>
                    </div>
                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8 max-w-md">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/input category.svg')) !!}
                        </div>
                        <a class="bg-indigo-600 text-white rounded-lg p-1 text-center" href="{{  route('admin.course_category.manage') }}">
                            Practice with bot
                        </a>
                    </div>
                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8 max-w-md">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/input category.svg')) !!}
                        </div>
                        <button type="button" data-modalid="modal-add-contents" class="openModalBtn bg-indigo-600 text-white rounded-lg p-1 text-center hover:shadow-lg hover:bg-indigo-500"> Chapter </button>
                    </div>
                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8 max-w-md">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/input category.svg')) !!}
                        </div>
                        <button type="button" data-modalid="modal-add-contents" class="openModalBtn bg-indigo-600 text-white rounded-lg p-1 text-center hover:shadow-lg hover:bg-indigo-500"> Manage User </button>
                    </div>

                    <div class="p-3 shadow-sm rounded-md w-fit flex flex-col gap-8 max-w-md">
                        <div class="w-42 h-42">
                            {!! file_get_contents(resource_path('svg/input category.svg')) !!}
                        </div>
                        <button type="button" data-modalid="modal-add-contents" class="openModalBtn bg-indigo-600 text-white rounded-lg p-1 text-center hover:shadow-lg hover:bg-indigo-500"> Activity </button>
                    </div>
                </div>
            </div>
        </div>
        <!---- end of quick action ---->
    </div>
    <!--- Soal ----->
    <div class="w-full sm:max-w-1/2 p-2">
        <div class="flex flex-col w-full rounded-sm bg-white shadow-sm gap-5 p-5 h-full">
            <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                Soal
            </div>
            <table class="w-full rounded-lg border border-gray-300">
                <thead class="text-md text-white bg-indigo-600">
                    <th class="border border-gray-300 py-2">Description</th>
                        <th class="border border-gray-300 py-2">Tingkat Kesulitan</th>
                        <th class="border border-gray-300 py-2">Action</th>
                </thead>
                <tbody>
                    @foreach($data->question as $soal)
                        <tr>
                            <td class="border border-gray-300 py-2 px-2">{{ $soal->description }}</td>
                            <td class="border border-gray-300 py-2 px-2">{{ $soal->level->level }}</td>
                            <td class="border border-gray-300 py-2 px-2 text-center flex gap-2 justify-center flex-wrap">
                                <button class="rounded bg-indigo-600 text-sm text-white px-4 py-2 font-semibold hover:shadow-lg hover:bg-indigo-500 shadow-sm"> edit </button>
                                <button class="rounded bg-gray-200 text-sm text-black px-4 py-2 font-semibold hover:shadow-lg hover:bg-gray-100 shadow-sm"> delete </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--- end of Soal ----->
    </div>
    <!----- chapter ----->
    <div class="w-full sm:max-w-2/3 p-2">
        @foreach($data->contents as $c)
            <div class="flex flex-col w-full rounded-sm bg-white shadow-sm p-5">
                <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                    Chapter
                </div>
                <div class="flex ">
                    <div class="border border-transparent border-r-gray-300 pe-5 pt-5 max-w-1/3">
                        <ul class="flex flex-wrap w-full">
                        @foreach($data->contents as $b)
                            <li class="mb-2 bg-indigo-600 text-white font-semibold rounded-md p-2 shadow-xs hover:bg-indigo-500 hover:shadow-sm  text-wrap w-full"> <a class="text-wrap" href="#">{{ $b->chapter }} . {{ $b->title }}</a> </li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="flex-1 p-5">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.content.delete', $c->id) }}"><div  class="p-2 rounded-lg bg-orange-600 text-white hover:bg-orange-500 max-w-24 w-full"> Edit </div> </a>
                            <a href="{{ route('admin.content.delete', $c->id) }}"><div class="p-2 rounded-lg bg-red-600 text-white hover:bg-red-500 max-w-24 w-full"> Delete </div> </a>
                        </div>
                        <div class="prose max-w-none p-2">
                            {!! $c->description !!}
                        </div>
                        <div class="p-5 border border-transparent border-t-gray-300 flex flex-col gap-2">
                            <div class="text-center font-semibold text-indigo-600 text-2xl">
                                Task
                            </div>
                            @foreach($c->task as $t)
                                <div class="">
                                    <a href="/#" class=""> {{ $t->title }} </a>
                                </div>
                            @endforeach
                            <div class="flex justify-end">
                                <button type="button" data-modalid="modal-add-task-{{ $c->id }}" class="openModalBtn bg-indigo-600 rounded-md text-center text-white align-baseline p-2 font-semibold text-md hover:shadow-md hover:bg-indigo-500 mx-center"> add task </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    <!--- end of chapter ---->
    </div>
    <!------- enrollment ---------->
    <div class="w-full flex-1 p-2">
       <div class="flex flex-col w-full rounded-sm bg-white shadow-sm p-5 h-full">
            <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                    Participants
            </div>
       </div>
    </div>
    <!---- end of wrapper content ----->
</div>
@endsection

