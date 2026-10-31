@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-nav-bg border border-border text-text-primary placeholder:text-text-secondary/40 focus:border-accent focus:ring-1 focus:ring-accent rounded-lg text-sm px-3.5 py-2.5 transition shadow-xs disabled:opacity-50 disabled:cursor-not-allowed']) }}>
