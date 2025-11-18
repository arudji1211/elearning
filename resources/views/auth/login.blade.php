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
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <x-input label="Username" type="text" name="username" />
                <x-input label="Password" type="password" name="password" />

                <div class="mt-2">
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
                </div>
            </form>
            <div class="text-gray-600 mt-2">
                Belum punya akun ? <a class="text-indigo-600 cursor-pointer" href="{{ route('register.post') }}"> daftar </a>
            </div>
        </div>


    </div>
</div>

@endsection

