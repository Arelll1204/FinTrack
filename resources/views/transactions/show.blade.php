<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Detail Transaksi
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Rincian data transaksi keuangan yang tercatat pada sistem.
                </p>
            </div>
            <a href="{{ route('transactions.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto space-y-6">

        <div class="bg-surface border border-border rounded-lg p-6 shadow-xs">
            <div class="flex justify-between items-center mb-6 border-b border-border/80 pb-4">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Informasi Mutasi
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        ID Transaksi: #{{ $transaction->id }}
                    </p>
                </div>

                @if ($transaction->type === 'income')
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-income/15 text-income border border-income/30">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        <span>Pemasukan</span>
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-expense/15 text-expense border border-expense/30">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        <span>Pengeluaran</span>
                    </span>
                @endif
            </div>

            <!-- Amount Highlight Banner -->
            <div class="p-5 bg-nav-bg/70 border border-border rounded-lg mb-6 flex flex-col justify-center">
                <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">
                    Nominal Transaksi
                </span>
                <p class="text-3xl font-extrabold tracking-tight mt-1 {{ $transaction->type === 'income' ? 'text-income' : 'text-expense' }}">
                    {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                </p>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-nav-bg/50 border border-border p-4 rounded-lg">
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Tanggal Transaksi</span>
                    <p class="text-sm font-semibold text-text-primary mt-1">
                        {{ $transaction->transaction_date ? $transaction->transaction_date->format('d F Y') : '-' }}
                    </p>
                </div>

                <div class="bg-nav-bg/50 border border-border p-4 rounded-lg">
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Kategori</span>
                    <p class="text-sm font-semibold text-text-primary mt-1">
                        {{ $transaction->category->name ?? '-' }}
                    </p>
                </div>

                <div class="bg-nav-bg/50 border border-border p-4 rounded-lg">
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Dompet / Rekening</span>
                    <p class="text-sm font-semibold text-text-primary mt-1">
                        {{ $transaction->wallet->name ?? '-' }}
                    </p>
                </div>

                <div class="bg-nav-bg/50 border border-border p-4 rounded-lg">
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Waktu Pencatatan</span>
                    <p class="text-sm font-semibold text-text-primary mt-1">
                        {{ $transaction->created_at ? $transaction->created_at->format('d/m/Y H:i') : '-' }}
                    </p>
                </div>
            </div>

            <div class="bg-nav-bg/50 border border-border p-4 rounded-lg mb-6">
                <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Deskripsi / Keterangan</span>
                <p class="text-sm text-text-primary mt-1.5 whitespace-pre-line leading-relaxed">
                    {{ $transaction->description }}
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-4 border-t border-border/80">
                <a href="{{ route('transactions.edit', $transaction->id) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit Transaksi</span>
                </a>

                <form action="{{ route('transactions.destroy', $transaction->id) }}"
                      method="POST"
                      class="inline"
                      onsubmit="return confirm('Apakah kamu yakin ingin menghapus transaksi ini? Saldo dompet akan disesuaikan kembali.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold bg-expense/15 border border-expense/30 text-expense hover:bg-expense/25 transition cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Hapus</span>
                    </button>
                </form>

                <a href="{{ route('transactions.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition ms-auto">
                    Kembali
                </a>
            </div>

        </div>

    </div>
</x-app-layout>
