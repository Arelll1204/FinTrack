<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Transaksi
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Kelola seluruh catatan mutasi arus kas pemasukan dan pengeluaran kamu.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('transactions.export', request()->query()) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface border border-border text-text-primary hover:bg-surface-hover hover:border-border-light transition shadow-xs">
                    <svg class="w-3.5 h-3.5 text-income" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span>Ekspor Excel</span>
                </a>

                <a href="{{ route('transactions.create') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Transaksi</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">

        @if (session('success'))
            <div class="p-3.5 rounded-lg bg-income/10 border border-income/30 text-income text-xs font-medium flex items-center gap-2.5 shadow-xs">
                <svg class="w-4 h-4 shrink-0 text-income" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Card Filter Periode & Tipe -->
        <div class="bg-surface border border-border rounded-lg p-4 shadow-xs">
            <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 items-end">
                <div>
                    <label for="start_date" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Tanggal Mulai
                    </label>
                    <input type="date"
                           id="start_date"
                           name="start_date"
                           value="{{ $startDate }}"
                           class="w-full bg-nav-bg border border-border text-text-primary rounded-lg text-xs py-2 px-3 focus:border-accent focus:ring-1 focus:ring-accent transition">
                </div>

                <div>
                    <label for="end_date" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Tanggal Akhir
                    </label>
                    <input type="date"
                           id="end_date"
                           name="end_date"
                           value="{{ $endDate }}"
                           class="w-full bg-nav-bg border border-border text-text-primary rounded-lg text-xs py-2 px-3 focus:border-accent focus:ring-1 focus:ring-accent transition">
                </div>

                <div>
                    <label for="type" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Tipe Mutasi
                    </label>
                    <select id="type"
                            name="type"
                            class="w-full bg-nav-bg border border-border text-text-primary rounded-lg text-xs py-2 px-3 focus:border-accent focus:ring-1 focus:ring-accent transition cursor-pointer">
                        <option value="">Semua Tipe</option>
                        <option value="income" {{ $type === 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ $type === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-1.5 bg-accent text-page-bg hover:bg-accent/90 px-3.5 py-2 rounded-lg text-xs font-semibold transition cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span>Filter Data</span>
                    </button>

                    @if ($startDate || $endDate || $type)
                        <a href="{{ route('transactions.index') }}"
                           class="inline-flex items-center justify-center px-3 py-2 rounded-lg text-xs font-semibold bg-nav-bg border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-surface border border-border rounded-lg p-5 shadow-xs">
            <div class="flex justify-between items-center pb-4 mb-2 border-b border-border/80">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Daftar Catatan Transaksi
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Menampilkan riwayat transaksi keuangan aktif Anda.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-border text-text-secondary uppercase tracking-wider text-[11px]">
                            <th scope="col" class="py-3 px-3">Tanggal</th>
                            <th scope="col" class="py-3 px-3">Deskripsi / Keterangan</th>
                            <th scope="col" class="py-3 px-3">Kategori</th>
                            <th scope="col" class="py-3 px-3">Dompet</th>
                            <th scope="col" class="py-3 px-3 text-center">Tipe</th>
                            <th scope="col" class="py-3 px-3 text-right">Nominal</th>
                            <th scope="col" class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border/60">
                        @forelse ($transactions as $transaction)
                            <tr class="hover:bg-surface-hover/60 transition-colors">
                                <td class="py-3 px-3 text-text-secondary whitespace-nowrap">
                                    {{ $transaction->transaction_date ? $transaction->transaction_date->format('d/m/Y') : '-' }}
                                </td>

                                <td class="py-3 px-3 font-medium text-text-primary max-w-xs truncate">
                                    {{ $transaction->description }}
                                </td>

                                <td class="py-3 px-3 text-text-secondary">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-nav-bg border border-border text-text-primary">
                                        {{ $transaction->category->name ?? '-' }}
                                    </span>
                                </td>

                                <td class="py-3 px-3 text-text-secondary whitespace-nowrap">
                                    {{ $transaction->wallet->name ?? '-' }}
                                </td>

                                <td class="py-3 px-3 text-center whitespace-nowrap">
                                    @if ($transaction->type === 'income')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-income/15 text-income border border-income/30">
                                            Pemasukan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-expense/15 text-expense border border-expense/30">
                                            Pengeluaran
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3 px-3 text-right font-semibold whitespace-nowrap {{ $transaction->type === 'income' ? 'text-income' : 'text-expense' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>

                                <td class="py-3 px-3 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                           title="Lihat Detail"
                                           class="text-accent hover:underline font-medium text-xs">
                                            Detail
                                        </a>

                                        <span class="text-border">|</span>

                                        <a href="{{ route('transactions.edit', $transaction->id) }}"
                                           title="Edit Data"
                                           class="text-blue-400 hover:underline font-medium text-xs">
                                            Edit
                                        </a>

                                        <span class="text-border">|</span>

                                        <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Apakah kamu yakin ingin menghapus transaksi ini? Saldo dompet akan disesuaikan kembali.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-expense hover:underline font-medium text-xs cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-10 text-center text-text-secondary text-xs">
                                    Belum ada data transaksi. Silakan klik tombol <strong>+ Tambah Transaksi</strong> di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($transactions->hasPages())
                <div class="pt-4 border-t border-border/80 mt-4">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
