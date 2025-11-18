@extends('layouts.course_manage')

@section('content')
<!-------- wrapper ---->
<div class="flex flex-col sm:flex-row gap-2 items-start">
    <!-------- main ----------->
    <div class="flex sm:flex-1 w-full">
        <div class="flex flex-col bg-white rounded-sm shadow-sm w-full p-5 gap-2 flex-wrap">
            <!--------- header ---->

            <!----- eof Header ----->
            <div class="flex flex-col overflow-auto gap-2 w-full justify-center">
                <div>

                    @if($profile->image != null)
                        <img src="{{ asset('storage/'. $profile->image->path) }}"
                    @endif
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-50 rounded-full outline -outline-offset-1 outline-white/10 mx-auto"/>
                </div>
                <div class="flex gap-2 w-full">
                    <div class="text-lg text-center w-full font-semibold text-slate-800">
                        {{ $profile->first_name . " " . $profile->last_name }}
                    </div>
                </div>
                <div class="flex w-full flex-col justify-center mt-5">
                    <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col w-md mx-auto" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-2 justify-between">
                            <x-input label="First Name" type="text" name="first_name" value="{{ $profile->first_name }}"/>
                            <x-input label="Last Name" type="text" name="last_name" value="{{ $profile->last_name }}"/>
                        </div>
                        <x-input label="Username" type="text" name="username" value="{{ $profile->username }}"/>
                        <x-input label="Password" type="password" name="password"/>
                        <x-input label="Email" type="text" name="email" value="{{ $profile->email }}"/>
                        <x-input label="Foto Profile" type="file" name="foto_profile"/>

                        <div>
                            <button type="submit" class="rounded-sm bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm hover:shadow-md cursor-pointer w-full p-2 font-semibold">
                                <i class="fa-solid fa-floppy-disk"></i> save
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
    <!-------- eof main ----------->
    <!-------- aside -------------->
    <div class="flex flex-col w-full sm:w-md gap-2 flex-none">
        <div class="flex flex-col w-full rounded-sm shadow-sm p-5 gap-2 bg-white">
            <div class="pb-5 text-indigo-600 font-semibold text-3xl border border-transparent border-b-gray-300">
                Leaderboard
            </div>
            <ul class="flex flex-col gap-1" id="leaderboard_container">

            </ul>
        </div>

    </div>
    <!------ eof aside ------------>

<div id="pageid" data-id="manage_profile_student">

</div>

</div>

<!---------- eof wrapper ---->
@endsection

