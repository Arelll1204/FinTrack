<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Detail Kategori
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Informasi lengkap mengenai kategori transaksi.
                </p>
            </div>
            <a href="{{ route('categories.index') }}"
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-text-primary">
                            {{ $category->name }}
                        </h2>
                        <span class="text-[11px] text-text-secondary">Pos Kategori FinTrack</span>
                    </div>
                </div>

                @if(strtolower($category->type) === 'income')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-income/15 text-income border border-income/30">
                        Pemasukan
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-expense/15 text-expense border border-expense/30">
                        Pengeluaran
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-nav-bg/50 border border-border p-4 rounded-lg">
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Nama Kategori</span>
                    <p class="text-sm font-semibold text-text-primary mt-1">{{ $category->name }}</p>
                </div>
                <div class="bg-nav-bg/50 border border-border p-4 rounded-lg">
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Tipe Klasifikasi</span>
                    <p class="text-sm font-semibold text-text-primary mt-1">{{ ucfirst($category->type) }}</p>
                </div>
                <div class="bg-nav-bg/50 border border-border p-4 rounded-lg sm:col-span-2">
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Waktu Pembuatan</span>
                    <p class="text-sm font-semibold text-text-primary mt-1">{{ $category->created_at ? $category->created_at->format('d/m/Y H:i') : '-' }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-border/80 flex items-center gap-3">
                <a href="{{ route('categories.edit', $category) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit Kategori</span>
                </a>

                <a href="{{ route('categories.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition ms-auto">
                    Kembali
                </a>
            </div>

        </div>

    </div>
</x-app-layout>
