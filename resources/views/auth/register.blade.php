@extends('layouts.app')


@section('content')
<div class="bg-white px-8 py-6 w-full max-w-lg">
   <div class="sm:mx-auto sm:w-full sm:max-w-sm mb-6">
    <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" class="mx-auto h-15 w-auto" />
    <h2 class="mt-6 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign up</h2>
  </div>

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
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
                    <option value="{{ $c->id }}">{{ $c->title }}</option>
                @endforeach

            </select>
        </div>
              <div class="mt-2">
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign up</button>
      </div>
    </form>
</div>
@endsection
