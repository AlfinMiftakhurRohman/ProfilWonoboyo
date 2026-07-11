@props(['name', 'label' => null, 'value' => null, 'hint' => null, 'options' => []])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-forest mb-1.5">{{ $label }}</label>
    @endif
    <select id="{{ $name }}" name="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full rounded-lg border-ink/15 bg-white text-sm text-ink shadow-sm focus:border-leaf focus:ring-leaf']) }}>
        @foreach ($options as $optValue => $optLabel)
            <option value="{{ $optValue }}" @selected((string) old($name, $value) === (string) $optValue)>{{ $optLabel }}</option>
        @endforeach
    </select>
    @if ($hint)<p class="mt-1 text-xs text-muted">{{ $hint }}</p>@endif
    @error($name)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
