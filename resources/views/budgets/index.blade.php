<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Anggaran Kategori
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Kendalikan batas pengeluaran bulanan agar tidak melebihi kemampuan finansial.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Filter Bulan & Tahun Form -->
                <form method="GET" action="{{ route('budgets.index') }}" class="flex items-center gap-1.5">
                    <select name="month"
                            onchange="this.form.submit()"
                            class="text-xs bg-nav-bg border border-border text-text-primary rounded-lg focus:border-accent focus:ring-1 focus:ring-accent py-1.5 px-3 cursor-pointer transition">
                        @foreach ($monthNames as $num => $name)
                            <option value="{{ $num }}" {{ $num == $selectedMonth ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="year"
                            onchange="this.form.submit()"
                            class="text-xs bg-nav-bg border border-border text-text-primary rounded-lg focus:border-accent focus:ring-1 focus:ring-accent py-1.5 px-3 cursor-pointer transition">
                        @foreach ($availableYears as $y)
                            <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <a href="{{ route('budgets.create') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Anggaran</span>
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

        <!-- Summary Metric Cards (Compact & Consistent) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Anggaran -->
            <div class="bg-surface border border-border rounded-lg p-4 transition hover:border-accent/40 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-text-secondary uppercase tracking-wider">Total Anggaran</span>
                    <div class="w-8 h-8 rounded-lg bg-accent/15 border border-accent/25 flex items-center justify-center text-accent">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2.5">
                    <p class="text-2xl font-bold text-text-primary tracking-tight">
                        Rp {{ number_format($totalBudget, 0, ',', '.') }}
                    </p>
                    <p class="text-[11px] text-text-secondary mt-1">{{ $budgets->count() }} kategori pada {{ $selectedMonthName }} {{ $selectedYear }}</p>
                </div>
            </div>

            <!-- Total Pengeluaran -->
            <div class="bg-surface border border-border rounded-lg p-4 transition hover:border-expense/40 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-text-secondary uppercase tracking-wider">Total Pengeluaran</span>
                    <div class="w-8 h-8 rounded-lg bg-expense/15 border border-expense/25 flex items-center justify-center text-expense">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2.5">
                    <p class="text-2xl font-bold text-expense tracking-tight">
                        Rp {{ number_format($totalSpent, 0, ',', '.') }}
                    </p>
                    <p class="text-[11px] text-text-secondary mt-1">Realisasi pada kategori anggaran</p>
                </div>
            </div>

            <!-- Sisa Anggaran -->
            <div class="bg-surface border border-border rounded-lg p-4 transition hover:border-income/40 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-text-secondary uppercase tracking-wider">Sisa Anggaran</span>
                    <div class="w-8 h-8 rounded-lg {{ $totalOver > 0 ? 'bg-expense/15 border-expense/25 text-expense' : 'bg-income/15 border-income/25 text-income' }} border flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2.5">
                    <p class="text-2xl font-bold tracking-tight {{ $totalOver > 0 ? 'text-expense' : 'text-income' }}">
                        @if ($totalOver > 0)
                            - Rp {{ number_format($totalOver, 0, ',', '.') }}
                        @else
                            Rp {{ number_format($totalRemaining, 0, ',', '.') }}
                        @endif
                    </p>
                    <p class="text-[11px] text-text-secondary mt-1">
                        {{ $totalOver > 0 ? 'Kelebihan belanja' : 'Sisa kuota belanja aktif' }}
                    </p>
                </div>
            </div>

            <!-- Pemakaian Keseluruhan -->
            <div class="bg-surface border border-border rounded-lg p-4 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-text-secondary uppercase tracking-wider">Pemakaian Keseluruhan</span>
                    <span class="text-xs font-semibold {{ $totalPercentage > 100 ? 'text-expense' : ($totalPercentage >= 80 ? 'text-budget-warn' : 'text-income') }}">
                        {{ $totalPercentage }}%
                    </span>
                </div>
                <div class="mt-2.5">
                    <div class="w-full bg-page-bg border border-border rounded-full h-2 overflow-hidden">
                        <div class="{{ $totalPercentage > 100 ? 'bg-expense' : ($totalPercentage >= 80 ? 'bg-budget-warn' : 'bg-income') }} h-full rounded-full transition-all duration-300"
                             style="width: {{ min(100, $totalPercentage) }}%"></div>
                    </div>
                    <p class="text-[11px] text-text-secondary mt-2">
                        Status: <strong class="{{ $totalPercentage > 100 ? 'text-expense' : ($totalPercentage >= 80 ? 'text-budget-warn' : 'text-income') }} font-semibold">
                            {{ $totalPercentage > 100 ? 'Melebihi Limit' : ($totalPercentage >= 80 ? 'Mendekati Batas' : 'Dalam Batas Aman') }}
                        </strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- Budget Table Card -->
        <div class="bg-surface border border-border rounded-lg p-5 shadow-xs">
            <div class="flex justify-between items-center pb-4 mb-2 border-b border-border/80">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Rincian Anggaran Kategori
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Monitoring batas dan pemakaian pengeluaran per kategori.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-border text-text-secondary uppercase tracking-wider text-[11px]">
                            <th scope="col" class="py-3 px-3">Kategori</th>
                            <th scope="col" class="py-3 px-3 text-right">Batas Anggaran</th>
                            <th scope="col" class="py-3 px-3 text-right">Realisasi Pengeluaran</th>
                            <th scope="col" class="py-3 px-3 text-right">Sisa / Lebih</th>
                            <th scope="col" class="py-3 px-3" style="width: 220px;">Progress Pemakaian</th>
                            <th scope="col" class="py-3 px-3 text-center">Status</th>
                            <th scope="col" class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border/60">
                        @forelse ($budgets as $budget)
                            <tr class="hover:bg-surface-hover/60 transition-colors">
                                <td class="py-3 px-3 font-semibold text-text-primary whitespace-nowrap">
                                    {{ $budget->category->name ?? '-' }}
                                </td>

                                <td class="py-3 px-3 text-right font-medium text-text-primary whitespace-nowrap">
                                    Rp {{ number_format($budget->amount, 0, ',', '.') }}
                                </td>

                                <td class="py-3 px-3 text-right font-medium text-expense whitespace-nowrap">
                                    Rp {{ number_format($budget->calculated_spent, 0, ',', '.') }}
                                </td>

                                <td class="py-3 px-3 text-right font-semibold whitespace-nowrap {{ $budget->remaining < 0 ? 'text-expense' : 'text-income' }}">
                                    @if ($budget->remaining < 0)
                                        - Rp {{ number_format(abs($budget->remaining), 0, ',', '.') }}
                                        <span class="block text-[10px] font-normal text-expense">
                                            (Lebih Rp {{ number_format($budget->over_budget, 0, ',', '.') }})
                                        </span>
                                    @else
                                        Rp {{ number_format($budget->remaining, 0, ',', '.') }}
                                    @endif
                                </td>

                                <td class="py-3 px-3">
                                    <div class="flex items-center justify-between text-[11px] font-semibold text-text-secondary mb-1">
                                        <span class="{{ $budget->percentage > 100 ? 'text-expense' : ($budget->percentage >= 80 ? 'text-budget-warn' : 'text-income') }}">
                                            {{ $budget->percentage }}%
                                        </span>
                                        <span class="text-[10px]">
                                            @if ($budget->percentage > 100)
                                                Over limit
                                            @else
                                                Sisa {{ max(0, 100 - $budget->percentage) }}%
                                            @endif
                                        </span>
                                    </div>
                                    <div class="w-full bg-page-bg border border-border rounded-full h-2 overflow-hidden">
                                        <div class="{{ $budget->percentage > 100 ? 'bg-expense' : ($budget->percentage >= 80 ? 'bg-budget-warn' : 'bg-income') }} h-full rounded-full transition-all duration-300"
                                             style="width: {{ min(100, $budget->percentage) }}%"></div>
                                    </div>
                                </td>

                                <td class="py-3 px-3 text-center whitespace-nowrap">
                                    @if ($budget->status === 'safe')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-income/15 text-income border border-income/30">
                                            &#10003; Aman
                                        </span>
                                    @elseif ($budget->status === 'warning')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-budget-warn/15 text-budget-warn border border-budget-warn/30">
                                            &#9888; Hampir Habis
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-expense/15 text-expense border border-expense/30">
                                            &#10007; Melebihi
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3 px-3 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('budgets.show', $budget->id) }}"
                                           class="text-accent hover:underline font-medium text-xs">
                                            Detail
                                        </a>

                                        <span class="text-border">|</span>

                                        <a href="{{ route('budgets.edit', $budget->id) }}"
                                           class="text-blue-400 hover:underline font-medium text-xs">
                                            Edit
                                        </a>

                                        <span class="text-border">|</span>

                                        <form action="{{ route('budgets.destroy', $budget->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Apakah kamu yakin ingin menghapus anggaran kategori ini?')">
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
                                    Belum ada anggaran yang diatur untuk <strong>{{ $selectedMonthName }} {{ $selectedYear }}</strong>.<br>
                                    <a href="{{ route('budgets.create') }}" class="text-accent hover:underline font-semibold mt-2 inline-block">
                                        + Buat Anggaran Baru
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
