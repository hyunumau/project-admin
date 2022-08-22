@forelse ($items as $item)
    <label class="form-check-label" for="{{ $id }}">
        <input
            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            type="checkbox"
            name="{{ $name }}"
            id="{{ $id . $item->id }}"
            value="{{ $item->id }}"
            @if (in_array($item->id, $selected)) checked @endif
        > {{ $item->name }}
    </label>
    @empty
    ----
@endforelse