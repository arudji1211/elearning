@props(['category_title','image_path','title', 'description', 'id'])

<div class="flex rounded-lg flex-col gap-2 flex-wrap shadow-sm max-w-full">
    <div class="font-semibold text-xs p-2 rounded-xs shadow-xs absolute place-items-start bg-indigo-600 text-white">{{ $category_title }}</div>
    <div class="w-max max-w-full">
        <img src="{{ asset('storage/' . $image_path) }}" class="max-w-full object-contain"/>
    </div>
    <div class="flex flex-col gap-1 p-2">
        <div class="text-center text-lg font-semibold">
            {{ $title }}
        </div>
        <div class="text-md text-center">
            {{ $description }}
        </div>
    </div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
</div>
