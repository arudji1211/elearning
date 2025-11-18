@extends('layouts.course_manage')

@section('content')
    <!--
        Modal
    --->
    @error('error_details')
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">

        {{ $message }}
    </div>
    @enderror
    <div id="modal-add-course" class="fixed inset-0 flex items-center justify-center hidden bg-white bg-opacity-50">
        <div class="rounded shadow-lg p-5 w-md relative bg-white flex flex-col gap-5">
            <div class="text-indigo-600 font-semibold text-lg text-center">
                New Course
            </div>
            <div>
                <form method="POST" action="{{ route('admin.course.add') }}" enctype="multipart/form-data">
                    @csrf
                    <x-input label="Title" type="text" name="title" />
                    <x-input label="Description" type="text" name="description" />
                    <div>
                        <label class="block text-sm/6 font-medium text-gray-900">Course categories</label>
                        <select name="course_categories_id" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <option value="" selected> Choose a category </option>
                            @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-input label="Image" type="file" name="image" />
                    <div class="mt-2 flex gap-2">
                        <button type="button" data-modalid="modal-add-course" class="closeModalBtn bg-rose-500 hover:bg-rose-600 shadow-sm hover:shadow-md rounded-sm text-white w-full font-semibold cursor-pointer p-2">Cancel</button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 shadow-sm hover:shadow-md rounded-sm text-white w-full font-semibold cursor-pointer p-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($course as $c)
        <div id="modal-edit-course-{{ $c->id }}" class="fixed inset-0 flex items-center justify-center hidden bg-white bg-opacity-50">
            <div class="rounded shadow-lg p-5 w-md relative bg-white flex flex-col gap-5">
                <div class="text-indigo-600 font-semibold text-lg text-center">
                    Update Course
                </div>
                <div>
                    <form method="POST" action="{{ route('admin.course.update', ['id' => $c->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <x-input label="Title" type="text" name="title" value="{{ $c->title }}" />
                        <x-input label="Description" type="text" name="description" value=" {{ $c->description }}" />
                        <div>
                            <label class="block text-sm/6 font-medium text-gray-900">Course categories</label>
                            <select name="course_categories_id" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value=""> Choose a category </option>
                                @foreach ($categories as $d)
                                    <option value="{{ $d->id }}" @selected((string)$d->id == (string)$c->course_categories_id) >{{ $d->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input label="Image" type="file" name="image" />
                        <div class="mt-2 flex gap-2">
                            <button type="button" data-modalid="modal-edit-course-{{$c->id}}" class="closeModalBtn bg-rose-500 hover:bg-rose-600 shadow-sm hover:shadow-md rounded-sm text-white w-full font-semibold cursor-pointer p-2">Cancel</button>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 shadow-sm hover:shadow-md rounded-sm text-white w-full font-semibold cursor-pointer p-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endforeach

    <!---------wrapper---------->
    <div class="flex flex-col sm:flex-row gap-2 items-start">
        <!----------- main --------->
        <div class="flex sm:flex-1 w-full">
            <div class="flex flex-col bg-white rounded-sm shadow-sm w-full p-5 gap-2 flex-wrap">
                <!--------- header ---->
                <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                    Course
                </div>
                <!--- eof header --->
                <!---- content --------->
                <div class="flex flex-col overflow-auto gap-2">
                    <div class="flex justify-end mb-2">
                        <button type="button" data-modalid="modal-add-course" class="openModalBtn bg-indigo-600 text-white font-semibold aspect-square w-8 rounded-full shadow-sm cursor-pointer shadow-sm openModalBtn hover:bg-indigo-700 hover:shadow-md">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <div class="flex flex-col gap-4">
                        <table class="w-full rounded-lg border border-gray-300">
                            <thead class="text-md text-white bg-indigo-600">
                                <th class="border border-gray-300 py-2">Category</th>
                                <th class="border border-gray-300 py-2">Title</th>
                                <th class="border border-gray-300 py-2">Description</th>
                                <th class="border border-gray-300 py-2">Action</th>
                            </thead>
                            <tbody class="">
                                @foreach($course as $c)
                                    <tr class="">
                                        <td class="border border-gray-300 py-2 px-2">{{ $c->category->title }}</td>
                                        <td class="border border-gray-300 py-2 px-2">{{ $c->title }}</td>
                                        <td class="border border-gray-300 py-2 px-2">{{ $c->description }}</td>
                                        <td class="border border-gray-300 py-2 px-2 flex gap-2 justify-center flex-wrap">
                                            <a class="rounded-sm bg-rose-500 hover:bg-rose-600 text-white hover:shadow-md p-1 font-semibold cursor-pointer px-2" href="{{ route('admin.course.delete', ['id' => $c->id]) }}">
                                                <i class="fa-solid fa-trash"></i> delete
                                            </a>
                                            <button type="button" class="openModalBtn rounded-sm bg-violet-500 hover:bg-violet-600 text-white hover:shadow-md p-1 font-semibold cursor-pointer px-2" data-modalid="modal-edit-course-{{ $c->id }}">
                                                <i class="fa-solid fa-pen"></i> edit
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="flex gap-2">
                                {{ $course->links() }}
                        </div>
                    </div>
                </div>
                <!----- main content --->
            </div>
        </div>
        <!--------- eof main ------->
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
    <!--------- eof wrapper ---->
<div id="pageid" data-id="manage_course_admin">

</div>

@endsection
