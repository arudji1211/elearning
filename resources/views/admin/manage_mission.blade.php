@extends('layouts.course_manage')

@section('content')
    @if ($errors->any())
        <div class="absolute right-0 bottom-0 z-50 p-3" id="alert">
            <div class="sticky p-6 bg-rose-500 rounded-md shadow-lg">
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
            <div class="flex justify-between">
                <x-input label="Progress Requirement" type="Number" name="progress_requirement"/>
                <x-input label="Reward" type="Number" name="reward"/>
            </div>

            <div class="mb-2">
                <label class="block text-sm/6 font-medium text-gray-900">Type</label>

                <select name="type" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    <option value="login"> Login </option>
                    <option value="course_log"> Akses Materi Pembelajaran </option>
                </select>
            </div>

            <div class="flex justify-between">
                <x-input label="Start" type="date" name="mission_start" />
                <x-input label="End" type="date" name="mission_end" />
            </div>
            <div class="mb-2 flex gap-1">
                <input name="is_daily" value="1" type="checkbox" class="border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 accent-indigo-600"/>
                <label class="text-baseline">
                    Daily
                </label>
            </div>
        </div>


        <div class="flex gap-2">
            <button type="button" class="hover:shadow-md w-1/2 closeModalBtn bg-rose-500 cursor-pointer rounded-sm shadow-sm p-1 font-semibold hover:bg-rose-600 text-white" data-modalid="modal-add-event"> cancel </button>
            <input type="submit" class="hover:shadow-md w-1/2 bg-violet-500 cursor-pointer rounded-sm shadow-sm p-1 text-white font-semibold hover:bg-violet-600" value="save" />
        </div>
        </form>

    </div>
</div>

@foreach($mission as $a)

<div id="modal-edit-event-{{ $a->id }}" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-15 p-5">
    <div class="flex flex-col w-md gap-2 shadow-sm rounded-sm p-5">
        <div class="text-center font-semibold text-2xl text-indigo-600">
            update event
        </div>
        <form method="POST" action="{{ route('admin.mission.update', ['id' => $a->id]) }}">
        <div>
            @csrf
            <x-input label="Title" type="text" name="title" value="{{ $a->title }}"/>
            <x-input label="Description" type="text"  name="description" value="{{ $a->description }}"/>
            <div class="flex justify-between">
                <x-input label="Progress Requirement" type="Number" name="progress_requirement" value="{{ $a->progres_requirement }}"/>
                <x-input label="Reward" type="Number" name="reward" value="{{ $a->reward }}"/>
            </div>

            <div class="mb-2">
                <label class="block text-sm/6 font-medium text-gray-900">Type</label>

                <select name="type" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    <option value="login" @selected($a->type == "login")> Login </option>
                    <option value="course_log" @selected($a->type == "course_log") > Akses Materi Pembelajaran </option>
                </select>
            </div>

            <div class="flex justify-between">
                <x-input label="Start" type="date" name="mission_start" value="{{ \Carbon\Carbon::parse($a->mission_start)->format('Y-m-d') }}"/>
                <x-input label="End" type="date" name="mission_end" value="{{ \Carbon\Carbon::parse($a->mission_end)->format('Y-m-d') }}" />
            </div>
            <div class="mb-2 flex gap-1">
                <input name="is_daily" value="1" type="checkbox" class="border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 accent-indigo-600" @checked('1' == $a->is_daily )/>
                <label class="text-baseline">
                    Daily
                </label>
            </div>
        </div>


        <div class="flex gap-2">
            <button type="button" class="hover:shadow-md w-1/2 closeModalBtn bg-rose-500 cursor-pointer rounded-sm shadow-sm p-1 font-semibold hover:bg-rose-600 text-white" data-modalid="modal-edit-event-{{ $a->id }}"> cancel </button>
            <input type="submit" class="hover:shadow-md w-1/2 bg-violet-500 cursor-pointer rounded-sm shadow-sm p-1 text-white font-semibold hover:bg-violet-600" value="save" />
        </div>
        </form>

    </div>
</div>


@endforeach


<!------------ Game -------->
<div id="modal-add-game" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-15 p-5">
    <div class="flex flex-col w-md gap-2 shadow-sm rounded-sm p-5">
        <div class="text-center font-semibold text-2xl text-indigo-600">
            create game
        </div>
        <form method="POST" action="{{ route('admin.game.create') }}">
        <div>
            @csrf
            <x-input label="Title" type="text" name="title"/>
            <x-input label="Description" type="text"  name="description"/>
            <x-input label="Reward" type="Number" name="reward"/>



            <div class="mb-2 flex gap-1">
                <input name="is_active" value="1" type="checkbox" class="border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 accent-indigo-600"/>
                <label class="text-baseline">
                    Is Active
                </label>
            </div>

            <div class="mb-2 flex gap-1">
                <input name="is_daily" value="1" type="checkbox" class="border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 accent-indigo-600"/>
                <label class="text-baseline">
                    Is Daily
                </label>
            </div>

        </div>


        <div class="flex gap-2">
            <button type="button" class="hover:shadow-md w-1/2 closeModalBtn bg-gray-200 cursor-pointer rounded-sm shadow-sm p-1 font-semibold" data-modalid="modal-add-game"> cancel </button>
            <input type="submit" class="hover:shadow-md w-1/2 bg-indigo-600 cursor-pointer rounded-sm shadow-sm p-1 text-white font-semibold" value="save" />
        </div>
        </form>

    </div>
</div>

<!-------EOF Game ---------->


@foreach($game as $g)
<!------------ Game -------->
<div id="modal-edit-game-{{ $g->id }}" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-15 p-5">
    <div class="flex flex-col w-md gap-2 shadow-sm rounded-sm p-5">
        <div class="text-center font-semibold text-2xl text-indigo-600">
            Update Game
        </div>
        <form method="POST" action="{{ route('admin.game.update', ['id' => $g->id]) }}">
        <div>
            @csrf
            <x-input label="Title" type="text" name="title" value="{{ $g->title }}"/>
            <x-input label="Description" type="text"  name="description" value="{{ $g->description }}"/>
            <x-input label="Reward" type="Number" name="reward" value="{{ $g->reward }}" />



            <div class="mb-2 flex gap-1">
                <input name="is_active" value="1" type="checkbox" class="border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 accent-indigo-600" @checked($g->is_active == '1')/>
                <label class="text-baseline">
                    Is Active
                </label>
            </div>

            <div class="mb-2 flex gap-1">
                <input name="is_daily" value="1" type="checkbox" class="border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300 accent-indigo-600" @checked($g->is_daily == '1')/>
                <label class="text-baseline">
                    Is Daily
                </label>
            </div>

        </div>


        <div class="flex gap-2">
            <button type="button" class="hover:shadow-md w-1/2 closeModalBtn bg-gray-200 cursor-pointer rounded-sm shadow-sm p-1 font-semibold closeModalBtn cursor-pointer" data-modalid="modal-edit-game-{{$g->id}}"> cancel </button>
            <input type="submit" class="hover:shadow-md w-1/2 bg-indigo-600 cursor-pointer rounded-sm shadow-sm p-1 text-white font-semibold" value="save" />
        </div>
        </form>

    </div>
</div>

<!-------EOF Game ---------->
@endforeach


<!-------Page Wrapper---------->
<div class="flex flex-col sm:flex-row gap-2 items-start">
    <div class="flex flex-1 flex-col gap-2">
        <div class="flex flex-col flex-1 gap-2 shadow-sm rounded-sm p-5 bg-white">
            <!--------Header---------->
            <div class="text-3xl font-semibold text-indigo-600">
                Event
            </div>
            <!--------EOF Header---------->

            <div class="text-end">
                <button type="button" class="bg-indigo-600 text-white font-semibold aspect-square w-8 rounded-full shadow-sm cursor-pointer shadow-sm openModalBtn hover:bg-indigo-700 hover:shadow-md" data-modalid="modal-add-event">
                   <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <!-------- main content -------->
            <div class="py-2">
                <table class="w-full border border-gray-300 rounded-sm">
                    <thead class="text-md text-white bg-indigo-600 rounded-sm">
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
                                <td class="border border-gray-300 py-2 px-2">
                                    <div class="flex gap-2 justify-center p-1">
                                        <button class="openModalBtn font-semibold bg-violet-500 text-white font-semibold aspect-square w-7 rounded-sm shadow-sm cursor-pointer hover:shadow-md hover:bg-violet-600" data-modalid="modal-edit-event-{{ $a->id }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <a class="text-center font-semibold bg-rose-500 text-white font-semibold aspect-square w-7 rounded-sm shadow-sm cursor-pointer hover:shadow-md hover:bg-rose-600" href="{{ route('admin.mission.delete', ['id' => $a->id]) }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <!-------- eof main content -------->


        </div>
        <div class="flex gap-2 w-full shadow-sm rounded-sm bg-white p-5 flex-col">
            <!--------Header---------->
            <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                Game
            </div>
            <!--------EOF Header---------->

            <div class="text-end">
                <button type="button" class="bg-indigo-600 text-white font-semibold aspect-square w-8 rounded-full shadow-sm cursor-pointer shadow-sm openModalBtn hover:bg-indigo-700 hover:shadow-md" data-modalid="modal-add-game">
                   <i class="fa-solid fa-plus"></i>
                </button>
            </div>


                <div class="flex flex-col sm:flex-row gap-2 py-5">
                    @foreach($game as $g)
                        <div class="flex flex-col rounded-sm shadow-sm p-3 gap-2 hover:shadow-md max-w-sm w-full">
                            <div class="object-contain">
                                {!! file_get_contents(resource_path('svg/game.svg')) !!}
                            </div>

                            <div class="flex flex-col gap-2 ">
                                <div class="text-lg text-center text-violet-500 font-semibold">
                                    {{ $g->title }}
                                </div>
                                <div class="text-slate-900">
                                    {{ $g->description }}
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" data-modalid="modal-edit-game-{{$g->id}}" class="p-1 shadow-sm text-center rounded-sm bg-violet-500 hover:bg-violet-600 text-white font-semibold w-1/2 openModalBtn cursor-pointer"> <i class="fa-solid fa-pen"></i> edit</button>

                                    <a href="{{ route('admin.game.delete', ['id' => $g->id]) }}" class="p-1 shadow-sm text-center rounded-sm bg-rose-500 hover:bg-rose-600 text-white font-semibold w-1/2"><i class="fa-solid fa-trash"></i> delete</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


        </div>
    </div>

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
<!------- EOF Page Wrapper---------->

<div id="pageid" data-id="manage_event_admin">

</div>

@endsection
