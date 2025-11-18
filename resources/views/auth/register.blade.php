@extends('layouts.app')


@section('content')
<div class="flex">
    <div class="flex-1 relative content-center bg-cover" style="background-image: url({{Vite::asset('resources/img/background.webp')}})">
            <div class="absolute min-h-full bg-cover inset-0 bg-indigo-600/50">

            </div>

        <div class="relative text-5xl font-semibold text-white p-2" >
            <p>
                E-Learning
            </p>
            <p>
                Program Studi
            </p>
            <p>
                Ilmu Pendidikan Kedokteran S2
            </p>
        </div>
    </div>
    <div class="sm:w-1/3 w-full bg-white min-h-screen content-center p-5 justify-center">
        <div class="sm:w-md mx-auto">
            <div>
                <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" class="mx-auto h-15 w-auto" />
                <h2 class="mt-6 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
            </div>
            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <x-input label="First Name" type="first_name" name="first_name" />
                <x-input label="Last Name" type="last_name" name="last_name" />
                <x-input label="Username" type="username" name="username" />
                <x-input label="Email" type="email" name="email" />
                <x-input label="Password" type="password" name="password" />
                <div>
                    <label class="block text-sm/6 font-medium text-gray-900">Role</label>
                    <select name="role" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        @foreach ($roles as $c)

                            <option value="{{ $c->id }}" class="@if( $c->title == 'admin' ) hidden @endif">{{ $c->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2">
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign up</button>
                </div>
            </form>
            <div class="text-gray-600 mt-2">
                Sudah punya akun ? <a class="text-indigo-600 cursor-pointer" href="{{ route('login') }}"> login </a>
            </div>
        </div>


    </div>
</div>


@endsection
