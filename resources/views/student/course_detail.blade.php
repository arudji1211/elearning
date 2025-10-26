@extends('layouts/student_course')

@section('content')

<!---- page wrapper ------>
<div class="flex gap-4">
    <!-------- CONTENTS --------->
    <div class="flex flex-col flex-1 gap-2 rounded-sm shadow-sm p-2 w-full">
    <!--- Chapter ---->
        <div class="text-3xl text-indigo-600 p-4 font-semibold border border-transparent border-b-gray-300">
            {{ $data->title }}
        </div>
        <div class="flex p-4">
            <!----------- Chapter List --------->
            <div class="border border-transparent border-r-gray-300 pr-3 md:max-w-sm w-sm">

                <ul class="flex flex-wrap w-full" id="contentList">
                    @foreach($data->contents as $b)
                        <li class="mb-2 bg-indigo-600 text-white font-semibold rounded-md p-2 shadow-xs hover:bg-indigo-500 hover:shadow-sm  text-wrap w-full cursor-pointer active:bg-indigo-300"
                                data-description="{{ $b->description }}" data-id="{{ $b->id }}" data-chapter="{{ $b->chapter }}" data-title="{{ $b->title }}"  data-berkaspendukung='@json($b->berkas_pendukung)'> {{ $b->chapter }} . {{ $b->title }}</li>
                    @endforeach
                </ul>
            </div>
            <!----------- EOF Chapter List --------->

            <!-------- Chapter Content ----------->
            <div class="flex-1 p-2">
                <div class="prose max-w-none p-5" id="contentsDescription">

                </div>
                <div id="contentsBacaanWajib" class="p-5 border border-transparent border-t-gray-300 flex flex-col gap-2">

                </div>
                <div id="contentsAction" class="p-5 border border-transparent border-t-gray-300 flex gap-2 justify-between">

                </div>
            </div>
            <!-------- EOF Chapter Content ----------->
        </div>
        <!--- EOF Chapter ---->
    </div>
    <!-------- EOF CONTENTS --------->

    <!-------- Leaderboard ----------->
    <div class="flex w-full max-w-1/3 w-1/3">
        <div class="flex flex-col rounded-sm shadow-sm p-2 w-full gap-2">
            <div class="text-3xl text-indigo-600 p-4 font-semibold border border-transparent border-b-gray-300">
                Leaderboard
            </div>
            <ul class="gap-2" id="leaderboard_container">

            </ul>
        </div>

    </div>
    <!-------- EOF Leaderboard ----------->
</div>
<!---- EOF page wrapper ------>
<div id="pageid" data-id="course_student">

</div>
@endsection
