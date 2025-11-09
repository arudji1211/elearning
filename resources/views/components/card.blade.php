@props(['link','category_title','image_path','title', 'description', 'id'])

<div class="flex rounded-lg hover:shadow-xl flex-col gap-2 flex-wrap shadow-sm max-w-full">
    <a href="{{ route('admin.course.detail', $id) }}" class="w-full">

    <div class="font-semibold text-xs p-2 rounded-xs shadow-xs absolute place-items-start bg-violet-500 text-white">{{ $category_title }}</div>
    <div class="w-max max-w-full h-max-60 h-50">
        <img src="{{ asset('storage/' . $image_path) }}" class="object-fill h-full"/>
    </div>
    <div class="flex flex-col gap-1 p-2 pb-5">
        <div class="text-center text-lg font-semibold text-gray-900">
            {{ $title }}
        </div>
        <div class="text-md text-center text-gray-500">
            {{ $description }}
        </div>
    </div>
    </a>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
</div>
