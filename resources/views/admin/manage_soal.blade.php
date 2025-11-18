@extends('layouts.course_manage')

@section('content')

<!---- modal add soal ------->
<div id="modal-add-soal" class="fixed inset-0 top-0 flex items-center justify-center hidden bg-white bg-opacity-50 z-10 p-5">
    <div class="rounded shadow-lg p-5 w-full md:w-4xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
            <div class="text-indigo-600 font-semibold text-xl text-center mt-3">
                Soal
            </div>
            <div>
                <form method="POST" action="{{ route('admin.soal.add') }}" class="" enctype="multipart/form-data">
                    @csrf
                    <x-input label="Pertanyaan" name="soal_description" type="text"/>
                    <div class="mb-2">
                        <label class="block text-sm/6 font-medium text-gray-900">
                            level
                        </label>
                        <select name="level_id" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            @foreach($level as $l)
                            <option value="{{ $l->id }}">
                                {{ $l->level }}
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

<!-----eof moda add soal ---->


<!-------- wrapper ---->
<div class="flex flex-col sm:flex-row gap-2 items-start">
    <!----- main ----->
    <div class="flex sm:flex-1 w-full">
        <div class="flex flex-col bg-white rounded-sm shadow-sm w-full p-5 gap-2 flex-wrap">
            <!--------- header ---->
            <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                Soal
            </div>
            <!----- eof Header ----->
            <!------ body ---------->
            <div class="flex flex-col overflow-auto gap-2">
                <div class="flex justify-end mb-2">
                    <button type="button" data-modalid="modal-add-soal" class="openModalBtn bg-indigo-600 text-white font-semibold aspect-square w-8 rounded-full shadow-sm cursor-pointer shadow-sm openModalBtn hover:bg-indigo-700 hover:shadow-md">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <div class="flex sm:flex-row flex-wrap">
                    @foreach($soal as $a)

                    <!----modal edit--------->
                    <div id="modal-edit-soal-{{ $a->id }}" class="fixed inset-0 flex items-center justify-center hidden bg-white bg-opacity-50">
                        <!-------- container ---->
                        <div class="rounded-sm shadow-lg p-5 w-full md:w-4xl bg-white flex flex-col gap-5 overflow-y-auto max-h-[90vh]">
                            <div class="text-indigo-600 font-semibold text-xl text-center">
                                Soal
                            </div>
                            <div>
                                <form method="POST" action="{{ route('admin.soal.edit', ['id' => $a->id]) }}">
                                    @csrf
                                    <x-input label="Pertanyaan" name="soal_description" type="text" value="{{ $a->description }}"/>
                                    <div class="mb-2">
                                        <label class="block text-sm/6 font-medium text-gray-900">
                                            level
                                        </label>
                                        <select name="level_id" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                        @foreach($level as $l)
                                            <option value="{{ $l->id }}" @selected($l->id == $a->level->id)>
                                                {{ $l->level }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <x-input label="Image" name="soal_image" type="file"/>


                                    @for ($i = 1;$i < 5;$i++)
                                        <div class="mt-5 pt-5">

                                            <div class="text-center border border-transparent  border-t-gray-300 py-4 mb-2 text-indigo-600 font-semibold">
                                                Opsi Jawaban {{ $i }}
                                            </div>
                                            <input type="hidden" name="answer[{{$i}}][id]" value="{{ $a->answers[$i-1]->id }}"/>
                                            <x-input label="description" name="answer[{{$i}}][description]" type="text" value="{{ $a->answers[$i-1]->description }}"/>
                                            <x-input label="image" name="answer[{{$i}}][image]" type="file"/>
                                            <div class="mb-2 flex gap-2">

                                                <input type="checkbox" value="is_true" name="answer[{{$i}}][is_true]" class="border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                                                <label class="block text-sm/6 font-medium text-gray-900">
                                                    Jawaban Benar ?
                                                </label>
                                            </div>
                                        </div>
                                    @endfor

                                    <div class="flex gap-2">
                                        <button type="button" class="w-full closeModalBtn rounded-sm shadow-sm hover:shadow-md bg-rose-500 hover:bg-rose-600 text-white cursor-pointer p-1 font-semibold" data-modalid="modal-edit-soal-{{ $a->id }}">
                                            cancel
                                        </button>
                                        <button type="submit" class="w-full rounded-sm shadow-sm hover:shadow-md bg-violet-500 hover:bg-violet-600 text-white cursor-pointer p-1 font-semibold" data-modalid="modal-edit-soal-{{ $a->id }}">
                                            <i class="fa-solid fa-floppy-disk"></i> save
                                        </button>
                                    </div>

                                </form>

                            </div>

                        </div>
                        <!---- eof container ---->

                    </div>
                    <!----eof modal edit ---->

                    <div class="p-1 sm:w-1/2 w-full flex-none">
                    <div class="soal flex flex-col rounded-sm shadow-sm hover:shadow-md p-5  border border-gray-100 gap-2">
                        <div class="flex gap-2 justify-end">
                            <button type="button" class="bg-indigo-600 text-white rounded-sm shadow-sm hover:shadow-md hover:bg-indigo-700 p-1 cursor-pointer openModalBtn" data-modalid="modal-edit-soal-{{ $a->id }}">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="button" class="bg-rose-500 text-white rounded-sm shadow-sm hover:shadow-md hover:bg-rose-600 p-1 cursor-pointer">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                        @if($a->image != null)
                        <div class="flex justify-center">
                            <img class="object-contain" src=" {{ asset('storage/' . $a->image->path) }}"/>
                        </div>
                        @endif
                        <div class="text-xl font-semibold text-slate-900">
                            {{ $a->description }}
                        </div>
                        <div class="flex flex-col rounded-sm gap-2 mt-2">
                            @foreach($a->answers as $q)
                                <div class="bg-violet-500 text-white p-2 rounded-sm shadow-sm font-semibold hover:shadow-md">
                                     {{ chr(64 + $loop->iteration) }}. {{ $q->description }}
                                </div>
                            @endforeach
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
<div id="pageid" data-id="manage_soal_admin">

</div>
@endsection
