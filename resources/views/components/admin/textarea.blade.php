@props(['name', 'label' => null, 'value' => null, 'hint' => null, 'rows' => 4])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-forest mb-1.5">{{ $label }}</label>
    @endif
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}"
              {{ $attributes->merge(['class' => 'w-full rounded-lg border-ink/15 bg-white text-sm text-ink shadow-sm focus:border-leaf focus:ring-leaf placeholder:text-muted/60']) }}>{{ old($name, $value) }}</textarea>
    @if ($hint)<p class="mt-1 text-xs text-muted">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
