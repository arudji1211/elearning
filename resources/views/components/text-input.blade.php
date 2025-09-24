@props(['label', 'type' => 'text', 'name', 'value' => ''])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-gray-700 font-medium mb-1">
            {{ $label }}
        </label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge([
            'class' => 'w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300'
        ]) }}
    >
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
