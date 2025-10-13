<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'My App') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   @vite(['resources/css/app.css','resources/js/app.js']) {{-- Tailwind --}}

</head>
<body class="min-h-screen flex items-center justify-center">
    <div id="modal-add-contents" class="fixed inset-0 top-0 flex items-center justify-center bg-white bg-opacity-50 z-10 p-4">
        <div class="rounded shadow-lg p-4 w-full sm:w-lg bg-white flex flex-col gap-4 overflow-y-auto max-h-[90vh]">
            <div class="text-indigo-600 font-semibold text-xl text-center">
                {{ $course->title }}
            </div>
            <div class="flex flex-col gap-2">
                <div class="">
                    <img src="{{ asset('storage/' . $course->image->path) }}" class="object-fill h-full rounded-sm"/>
                </div>
                <div class="flex justify-between gap-4">
                    <a href="/#" class="rounded-sm font-semibold p-2 bg-gray-300 shadow-sm hover:bg-gray-200 flex w-full max-w-1/2 justify-center">
                        cancel
                    </a>
                    <a href="{{ route('student.course.enrollme', $course->id) }}" class="rounded-sm text-white font-semibold p-2 bg-indigo-600 shadow-sm hover:bg-indigo-500 flex w-full max-w-1/2 justify-center">
                        enroll
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

