@extends('layouts.course_manage')

@section('content')

<div id="modal-add-level" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-10 p-5">
    <div class="rounded shadow-lg p-5 w-full md:w-4xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
            <div class="text-indigo-600 font-semibold text-xl text-center mt-3">
                Tingkat Kesulitan
            </div>
            <div class="">
                <form method="POST" action="{{ route('admin.level.add') }}">
                    @csrf
                    <x-input label="Tingkat Kesulitan" name="level" type="text"/>
                    <x-input label="Delay Bot" name="delay" type="Number"/>

                <div class="mt-2 flex gap-2">
                    <button type="button" data-modalid="modal-add-level" class="closeModalBtn shadow-sm w-full rounded-sm bg-rose-500 text-white hover:bg-rose-600 hover:shadow-md font-semibold cursor-pointer p-2">Cancel</button>
                    <button type="submit" class="shadow-sm w-full rounded-sm bg-emerald-500 text-white hover:bg-emerald-600 hover:shadow-md font-semibold cursor-pointer p-2">Save</button>
                </div>
                </form>
            </div>
    </div>
</div>


<!-------- wrapper ---->
<div class="flex flex-col sm:flex-row gap-2 items-start">
    <!----- main ----->
    <div class="flex sm:flex-1 w-full">
        <div class="flex flex-col bg-white rounded-sm shadow-sm w-full p-5 gap-2 flex-wrap">
            <!--------- header ---->
            <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                Tingkat Kesulitan
            </div>
            <!----- eof Header ----->
            <!------ body ---------->
            <div class="flex flex-col overflow-auto gap-2">
                <div class="flex justify-end mb-2">
                    <button type="button" data-modalid="modal-add-level" class="openModalBtn bg-indigo-600 text-white font-semibold aspect-square w-8 rounded-full shadow-sm cursor-pointer shadow-sm openModalBtn hover:bg-indigo-700 hover:shadow-md">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <div class="flex sm:flex-row flex-wrap">
                    @foreach($level as $a)

                    <!----modal edit--------->
                    <div id="modal-edit-level-{{ $a->id }}" class="fixed inset-0 flex items-center justify-center hidden bg-white bg-opacity-50">
                        <!-------- container ---->
                        <div class="rounded-sm shadow-lg p-5 w-full md:w-4xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
                            <div class="text-indigo-600 font-semibold text-xl text-center">
                                Tingkat Kesulitan
                            </div>
                            <div>
                                <form method="POST" action="{{ route('admin.level.edit', ['id' => $a->id]) }}">
                                    @csrf
                                    <x-input label="Tingkat Kesulitan" name="level" type="text" value="{{ $a->level }}"/>
                                    <x-input label="delay Menjawab" name="delay" type="number" value="{{ $a->delay }}"/>

                                   <div class="flex gap-2">
                                        <button type="button" class="w-full closeModalBtn rounded-sm shadow-sm hover:shadow-md bg-rose-500 hover:bg-rose-600 text-white cursor-pointer p-1 font-semibold" data-modalid="modal-edit-level-{{ $a->id }}">
                                            cancel
                                        </button>
                                        <button type="submit" class="w-full rounded-sm shadow-sm hover:shadow-md bg-violet-500 hover:bg-violet-600 text-white cursor-pointer p-1 font-semibold">
                                            <i class="fa-solid fa-floppy-disk"></i> save
                                        </button>
                                    </div>

                                </form>

                            </div>

                        </div>
                        <!---- eof container ---->

                    </div>
                    <!----eof modal edit ---->

                    <div class="p-1 flex-wrap">
                    <div class="soal flex rounded-sm shadow-sm hover:shadow-md p-5  border border-gray-100 gap-5 justify-between">
                        <div class="text-lg font-semibold text-slate-900 flex gap-1">
                            <div class="text-emerald-500">
                                Tingkat Kesulitan {{ $a->level }}
                            </div>
                            <div class="text-violet-500">
                                ||
                            </div>
                            <div class="text-rose-500">
                                {{ $a->delay }} detik
                            </div>
                        </div>
                        <div class="flex gap-2 justify-end">
                            <button type="button" class="bg-indigo-600 text-white rounded-sm shadow-sm hover:shadow-md hover:bg-indigo-700 p-1 cursor-pointer openModalBtn" data-modalid="modal-edit-level-{{ $a->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <a href="{{ route('admin.level.delete', ['id' => $a->id]) }}" class="bg-rose-500 text-white rounded-sm shadow-sm hover:shadow-md hover:bg-rose-600 p-1 cursor-pointer">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>


                    </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!----- eof body ------->

        </div>
    </div>
    <!----- eof main ---->
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
<!-------- eof wrapper ---->
<div id="pageid" data-id="manage_level_admin">

</div>

@endsection
