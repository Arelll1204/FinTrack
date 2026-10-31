<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Detail Dompet
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Informasi akun dompet dan saldo saat ini.
                </p>
            </div>
            <a href="{{ route('wallets.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto space-y-6">

        <div class="bg-surface border border-border rounded-lg p-6 shadow-xs">
            <div class="flex items-center justify-between pb-4 mb-6 border-b border-border/80">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-accent/15 border border-accent/30 text-accent flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-text-primary">
                            {{ $wallet->name }}
                        </h2>
                        <span class="text-[11px] text-text-secondary">Akun Dompet FinTrack</span>
                    </div>
                </div>
            </div>

            <!-- Balance Highlight Card -->
            <div class="p-5 bg-nav-bg/70 border border-border rounded-lg mb-6">
                <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Saldo Saat Ini</span>
                <p class="text-3xl font-extrabold text-accent tracking-tight mt-1">
                    Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-nav-bg/50 border border-border p-4 rounded-lg">
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Nama Akun</span>
                    <p class="text-sm font-semibold text-text-primary mt-1">{{ $wallet->name }}</p>
                </div>
                <div class="bg-nav-bg/50 border border-border p-4 rounded-lg">
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Waktu Pembuatan</span>
                    <p class="text-sm font-semibold text-text-primary mt-1">{{ $wallet->created_at ? $wallet->created_at->format('d/m/Y H:i') : '-' }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-border/80 flex items-center gap-3">
                <a href="{{ route('wallets.edit', $wallet->id) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit Dompet</span>
                </a>

                <a href="{{ route('wallets.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition ms-auto">
                    Kembali
                </a>
            </div>

        </div>

    </div>
</x-app-layout>
