@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-3.5 rounded-lg bg-income/10 border border-income/30 text-income text-xs font-medium flex items-center gap-2.5 shadow-xs']) }}>
        <svg class="w-4 h-4 shrink-0 text-income" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ $status }}</span>
    </div>
@endif
