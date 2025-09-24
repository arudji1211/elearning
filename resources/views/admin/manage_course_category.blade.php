@extends('layouts.admin_dashboard')

@section('content')
    <!--
        Modal
    --->
    <div id="myModal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="rounded shadow-lg p-5 w-md relative bg-white flex flex-col gap-5">
            <div class="text-indigo-600 font-semibold text-lg text-center">
                New Course Category
            </div>
            <div>
                <form method="POST" action="{{ route('admin.course_category.add') }}">
                    @csrf
                    <x-input label="Title" type="text" name="title" />
                    <x-input label="Description" type="text" name="description" />

                    <div class="mt-2 flex gap-2">
                        <button type="button" id="closeModalBtn" class="flex w-full justify-center rounded-md bg-gray-200 px-3 py-1.5 text-sm/6 font-semibold text-black shadow-xs hover:bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-100">Cancel</button>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="shadow-md rounded-lg p-6 flex flex-col gap-5">
        <div class="text-indigo-600 font-semibold text-lg">
            Course Category
        </div>
        <div class="flex flex-col md:flex-row flex-nowrap overflow-auto gap-5">

            <div class="w-full">
                <div class="flex justify-end mb-2">
                    <button type="button" id="openModalBtn" class="flex justify-center rounded-md bg-indigo-600 px-3 pb-1 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">+</button>
                </div>
                <div class="flex flex-col gap-4">
                    <table class="w-full rounded-lg border border-gray-300">
                        <thead class="text-md text-white bg-indigo-600">
                            <th class="border border-gray-300 py-2">Title</th>
                            <th class="border border-gray-300 py-2">Description</th>
                            <th class="border border-gray-300 py-2">Action</th>
                        </thead>
                        <tbody class="">
                            @foreach($course_categories as $c)
                                <tr class="">
                                    <td class="border border-gray-300 py-2 px-2">{{ $c->title }}</td>
                                    <td class="border border-gray-300 py-2 px-2">{{ $c->description }}</td>
                                    <td class="border border-gray-300 py-2 px-2"></td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="flex gap-2">
                            {{ $course_categories->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
