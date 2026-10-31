<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Detail Anggaran
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Informasi batas kuota dan realisasi pengeluaran pada kategori terkait.
                </p>
            </div>
            <a href="{{ route('budgets.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-6">

        <div class="bg-surface border border-border rounded-lg p-6 shadow-xs">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 border-b border-border/80 pb-4">
                <div>
                    <h2 class="text-lg font-bold text-text-primary">
                        Anggaran Kategori: {{ $budget->category->name ?? '-' }}
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Periode: {{ $monthName }} {{ $budget->year }}
                    </p>
                </div>

                @if ($budget->percentage > 100)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-expense/15 text-expense border border-expense/30">
                        &#10007; Melebihi Batas
                    </span>
                @elseif ($budget->percentage >= 80)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-budget-warn/15 text-budget-warn border border-budget-warn/30">
                        &#9888; Hampir Habis
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-income/15 text-income border border-income/30">
                        &#10003; Batas Aman
                    </span>
                @endif
            </div>

            <!-- Progress Bar Card -->
            <div class="p-5 bg-nav-bg/70 border border-border rounded-lg mb-6">
                <div class="flex justify-between items-center text-xs font-semibold text-text-secondary mb-2">
                    <span>Tingkat Pemakaian: <strong class="{{ $budget->percentage > 100 ? 'text-expense' : ($budget->percentage >= 80 ? 'text-budget-warn' : 'text-income') }}">{{ $budget->percentage }}%</strong></span>
                    <span>
                        @if ($budget->remaining < 0)
                            <span class="text-expense">Melebihi Rp {{ number_format($budget->over_budget, 0, ',', '.') }}</span>
                        @else
                            <span class="text-income">Sisa Kuota Rp {{ number_format($budget->remaining, 0, ',', '.') }}</span>
                        @endif
                    </span>
                </div>

                <div class="w-full bg-page-bg border border-border rounded-full h-3 overflow-hidden mb-4">
                    <div class="{{ $budget->percentage > 100 ? 'bg-expense' : ($budget->percentage >= 80 ? 'bg-budget-warn' : 'bg-income') }} h-full rounded-full transition-all duration-300"
                         style="width: {{ min(100, $budget->percentage) }}%"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-border/80 text-center">
                    <div>
                        <span class="text-xs font-semibold text-text-secondary uppercase">Batas Anggaran</span>
                        <p class="text-lg font-bold text-text-primary mt-1">
                            Rp {{ number_format($budget->amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-text-secondary uppercase">Total Pengeluaran</span>
                        <p class="text-lg font-bold text-expense mt-1">
                            Rp {{ number_format($budget->calculated_spent, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-text-secondary uppercase">Sisa Anggaran</span>
                        <p class="text-lg font-bold {{ $budget->remaining < 0 ? 'text-expense' : 'text-income' }} mt-1">
                            @if ($budget->remaining < 0)
                                - Rp {{ number_format(abs($budget->remaining), 0, ',', '.') }}
                            @else
                                Rp {{ number_format($budget->remaining, 0, ',', '.') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Daftar Transaksi Terkait -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-bold text-text-primary">
                        Transaksi Pengeluaran Terkait ({{ $transactions->count() }})
                    </h3>
                </div>

                <div class="overflow-x-auto border border-border rounded-lg">
                    <table class="min-w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-border text-text-secondary uppercase tracking-wider text-[11px] bg-nav-bg/40">
                                <th scope="col" class="py-2.5 px-3">Tanggal</th>
                                <th scope="col" class="py-2.5 px-3">Keterangan</th>
                                <th scope="col" class="py-2.5 px-3">Dompet</th>
                                <th scope="col" class="py-2.5 px-3 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border/60">
                            @forelse ($transactions as $t)
                                <tr class="hover:bg-surface-hover/60 transition-colors">
                                    <td class="py-2.5 px-3 text-text-secondary whitespace-nowrap">
                                        {{ $t->transaction_date ? $t->transaction_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="py-2.5 px-3 text-text-primary font-medium">
                                        {{ $t->description }}
                                    </td>
                                    <td class="py-2.5 px-3 text-text-secondary">
                                        {{ $t->wallet->name ?? '-' }}
                                    </td>
                                    <td class="py-2.5 px-3 text-right font-semibold text-expense whitespace-nowrap">
                                        Rp {{ number_format($t->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-text-secondary text-xs">
                                        Belum ada mutasi pengeluaran pada kategori ini selama periode terkait.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-border/80 flex items-center gap-3">
                <a href="{{ route('budgets.edit', $budget->id) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit Anggaran</span>
                </a>

                <a href="{{ route('budgets.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition ms-auto">
                    Kembali
                </a>
            </div>

        </div>

    </div>
</x-app-layout>
