<div>
    @if (! empty($label))
        <label
            for="{{ $name }}"
            class="block font-medium text-sm text-gray-700 @error($name) text-red-400 @enderror">
            {{ $label }}
            @if ($required)
                <span class="text-red-400">*</span>
            @endif
        </label>
    @endif
    @if ($type == 'textarea')
        <textarea name="{{ $name }}" id="{{ $id ?? $name }}" {{ $attributes }}>{!! old($name, $value) !!}</textarea>
    @else
        <input
            id="{{ $id ?? $name }}"
            class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full @error($name) border-red-400 @enderror"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            {{ $attributes }}
        >
    @endif
    @error($name)
        <span class="text-sm text-red-400">{{ $message }}</span>
    @enderror
</div>