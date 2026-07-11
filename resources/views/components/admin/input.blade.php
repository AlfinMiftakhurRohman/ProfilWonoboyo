@props(['name', 'label' => null, 'value' => null, 'hint' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-forest mb-1.5">{{ $label }}</label>
    @endif
    <input id="{{ $name }}" name="{{ $name }}"
           value="{{ old($name, $value) }}"
           {{ $attributes->merge(['class' => 'w-full rounded-lg border-ink/15 bg-white text-sm text-ink shadow-sm focus:border-leaf focus:ring-leaf placeholder:text-muted/60']) }}>
    @if ($hint)<p class="mt-1 text-xs text-muted">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
