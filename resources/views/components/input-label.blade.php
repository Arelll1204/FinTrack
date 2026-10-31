@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-2']) }}>
    {{ $value ?? $slot }}
</label>
