<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-accent text-page-bg hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-page-bg border border-transparent rounded-lg font-semibold text-sm tracking-tight transition active:scale-[0.99] disabled:opacity-50 shadow-xs cursor-pointer']) }}>
    {{ $slot }}
</button>
