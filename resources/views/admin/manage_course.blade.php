@extends('layouts.admin_dashboard')

@section('content')
    <!--
        Modal
    --->
    @error('error_details')
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ $code }}
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
                        <button type="button" data-modalid="modal-add-course" class="closeModalBtn flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="shadow-md rounded-lg p-6 flex flex-col gap-5">
        <div class="text-indigo-600 font-semibold text-3xl">
            Course
        </div>
        <div class="flex flex-col md:flex-row flex-nowrap overflow-auto gap-5">

            <div class="w-full">
                <div class="flex justify-end mb-2">
                    <button type="button" data-modalid="modal-add-course" class="openModalBtn flex justify-center rounded-md bg-indigo-600 px-3 pb-1 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">+</button>
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
                                    <td class="border border-gray-300 py-2 px-2"></td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="flex gap-2">
                            {{ $course->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
