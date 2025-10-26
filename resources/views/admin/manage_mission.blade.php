@extends('layouts/app')

@section('content')

<div id="modal-add-event" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-15 p-5">
    <div class="flex flex-col w-md gap-2 shadow-sm rounded-sm p-5">
        <div class="text-center font-semibold text-2xl text-indigo-600">
            create event
        </div>
        <form method="POST" action="{{ route('admin.mission.create') }}">
        <div>
            @csrf
            <x-input label="Title" type="text" name="title"/>
            <x-input label="Description" type="text"  name="description"/>
            <x-input label="Reward" type="Number" name="reward"/>
            <div class="flex justify-between">
                <x-input label="Start" type="date" name="mission_start" />
                <x-input label="End" type="date" name="mission_end" />
            </div>
            <div class="mb-2">
                <label class="block text-sm/6 font-medium text-gray-900">Type</label>

                <select name="type" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    <option value="login"> Login </option>
                </select>
            </div>
            <div class="mb-2 flex gap-1">
                <input name="is_daily" value="1" type="checkbox" class="border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 accent-indigo-600"/>
                <label class="text-baseline">
                    Daily
                </label>
            </div>
        </div>


        <div class="flex gap-2">
            <button type="button" class="hover:shadow-md w-1/2 closeModalBtn bg-gray-200 cursor-pointer rounded-sm shadow-sm p-1 font-semibold" data-modalid="modal-add-event"> cancel </button>
            <input type="submit" class="hover:shadow-md w-1/2 bg-indigo-600 cursor-pointer rounded-sm shadow-sm p-1 text-white font-semibold" value="save" />
        </div>
        </form>

    </div>
    </div>


<!-------Page Wrapper---------->
<div class="flex gap-2">
    <div class="flex flex-col flex-1 gap-2 shadow-sm rounded-sm p-5">
        <!--------Header---------->
        <div class="text-3xl font-semibold text-indigo-600">
            Manage Event
        </div>
        <!--------EOF Header---------->

        <div class="text-end">
            <button type="button" class="font-semibold bg-indigo-600 text-white font-semibold aspect-square w-8 rounded-sm shadow-sm cursor-pointer shadow-md openModalBtn" data-modalid="modal-add-event">
               +
            </button>
        </div>
        <!-------- main content -------->
        <div>
            <table class="w-full rounded-lg border border-gray-300">
                <thead class="text-md text-white bg-indigo-600">
                    <th class="border border-gray-300 py-2" >
                        Title
                    </th>
                    <th class="border border-gray-300 py-2">
                        Description
                    </th>
                    <th class="border border-gray-300 py-2">
                        Type
                    </th>
                    <th class="border border-gray-300 py-2">
                        Start Date
                    </th >
                    <th class="border border-gray-300 py-2">
                        End Date
                    </th>
                    <th class="border border-gray-300 py-2">
                        Action
                    </th>
                </thead>
                <tbody>
                    @foreach($mission as $a)
                        <tr>
                            <td class="border border-gray-300 py-2 px-2" >
                                {{ $a->title }}
                            </td>
                            <td class="border border-gray-300 py-2 px-2">
                                {{ $a->description }}
                            </td>
                            <td class="border border-gray-300 py-2 px-2">
                                {{ $a->type }}
                            </td>
                            <td class="border border-gray-300 py-2 px-2">
                                 {{ $a->mission_start }}
                            </td>
                            <td class="border border-gray-300 py-2 px-2">
                                {{ $a->mission_end }}
                            </td>
                            <td>
                                <div class="flex gap-2 justify-center">
                                    <button class="font-semibold bg-orange-600 text-white font-semibold aspect-square w-9 rounded-sm shadow-sm cursor-pointer shadow-md">edit</button>
                                    <button class="font-semibold bg-red-600 text-white font-semibold aspect-square w-9 rounded-sm shadow-sm cursor-pointer shadow-md">edit</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <!-------- eof main content -------->


    </div>
    <div class="max-w-md w-md gap-2 shadow-sm rounded-sm  p-5">

    </div>
</div>
<!------- EOF Page Wrapper---------->

<div id="pageid" dataset-id="manage-event">

</div>

@endsection
