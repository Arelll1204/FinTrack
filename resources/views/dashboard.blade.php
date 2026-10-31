<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Dashboard FinTrack
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Pantau arus kas, rencana keuangan, dan anggaran kamu dalam satu tempat.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('transactions.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Catat Transaksi</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 space-y-7 max-w-7xl mx-auto">

        <!-- 1. Ringkasan Keuangan Keseluruhan -->
        <section>
            <div class="mb-3.5 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Ringkasan Keuangan
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Kondisi saldo kumulatif dan perputaran dana keseluruhan.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Saldo -->
                <div class="bg-surface border border-border rounded-lg p-4 transition hover:border-accent/40 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-text-secondary uppercase tracking-wider">Total Saldo</span>
                        <div class="w-8 h-8 rounded-lg bg-accent/15 border border-accent/25 flex items-center justify-center text-accent">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <p class="text-2xl font-bold text-accent tracking-tight">
                            Rp {{ number_format($totalBalance, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-text-secondary mt-1">Saldo aktif seluruh dompet</p>
                    </div>
                </div>

                <!-- Total Pemasukan -->
                <div class="bg-surface border border-border rounded-lg p-4 transition hover:border-income/40 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-text-secondary uppercase tracking-wider">Total Pemasukan</span>
                        <div class="w-8 h-8 rounded-lg bg-income/15 border border-income/25 flex items-center justify-center text-income">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <p class="text-2xl font-bold text-income tracking-tight">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-text-secondary mt-1">Akumulasi uang masuk</p>
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
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-text-secondary mt-1">Akumulasi uang keluar</p>
                    </div>
                </div>

                <!-- Total Budget -->
                <div class="bg-surface border border-border rounded-lg p-4 transition hover:border-border-light flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-text-secondary uppercase tracking-wider">Total Budget</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-500/15 border border-blue-500/25 flex items-center justify-center text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <p class="text-2xl font-bold text-text-primary tracking-tight">
                            Rp {{ number_format($totalBudget, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-text-secondary mt-1">Alokasi anggaran terdaftar</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Ringkasan Bulan Ini -->
        <section>
            <div class="mb-3.5 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Ringkasan Bulan Ini
                        <span class="ml-1 text-xs font-normal text-text-secondary">({{ $currentMonthName }} {{ $currentYear }})</span>
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Performa keuangan bulan berjalan dibandingkan rencana & target anggaran.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Pemasukan Bulan Ini -->
                <div class="bg-surface border border-border rounded-lg p-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-text-secondary">Pemasukan Bulan Ini</span>
                            <span class="w-2 h-2 rounded-full bg-income"></span>
                        </div>
                        <p class="text-xl font-bold text-income tracking-tight mt-2">
                            Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
                        </p>
                    </div>
                    <p class="text-[11px] text-text-secondary mt-3 pt-2.5 border-t border-border/60">
                        Pemasukan terbukukan bulan ini
                    </p>
                </div>

                <!-- Pengeluaran Bulan Ini -->
                <div class="bg-surface border border-border rounded-lg p-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-text-secondary">Pengeluaran Bulan Ini</span>
                            <span class="w-2 h-2 rounded-full bg-expense"></span>
                        </div>
                        <p class="text-xl font-bold text-expense tracking-tight mt-2">
                            Rp {{ number_format($monthlyExpense, 0, ',', '.') }}
                        </p>
                    </div>
                    <p class="text-[11px] text-text-secondary mt-3 pt-2.5 border-t border-border/60">
                        Pengeluaran aktual bulan ini
                    </p>
                </div>

                <!-- Rencana Bulan Ini -->
                <div class="bg-surface border border-border rounded-lg p-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-text-secondary">Rencana Bulan Ini</span>
                            <span class="w-2 h-2 rounded-full bg-accent"></span>
                        </div>
                        <p class="text-xl font-bold text-accent tracking-tight mt-2">
                            Rp {{ number_format($monthlyPlanTotal, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-text-secondary mt-1">
                            {{ $monthlyPlans->count() }} pos perencanaan
                        </p>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-border/60">
                        <a href="{{ route('monthly-plans.index') }}"
                           class="text-accent hover:underline text-xs font-medium inline-flex items-center gap-1">
                            <span>Perencanaan</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Anggaran Bulan Ini (Progress Bar & Status) -->
                <div class="bg-surface border border-border rounded-lg p-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-text-secondary">Anggaran Bulan Ini</span>
                            <span class="text-xs font-semibold {{ $monthlyBudgetPercentage > 100 ? 'text-expense' : ($monthlyBudgetPercentage >= 80 ? 'text-budget-warn' : 'text-income') }}">
                                {{ $monthlyBudgetPercentage }}%
                            </span>
                        </div>
                        <p class="text-xl font-bold text-text-primary tracking-tight mt-2">
                            Rp {{ number_format($monthlyBudgetTotal, 0, ',', '.') }}
                        </p>

                        <!-- Progress Bar -->
                        <div class="w-full bg-page-bg border border-border rounded-full h-1.5 mt-2.5 overflow-hidden">
                            <div class="{{ $monthlyBudgetPercentage > 100 ? 'bg-expense' : ($monthlyBudgetPercentage >= 80 ? 'bg-budget-warn' : 'bg-income') }} h-full rounded-full transition-all duration-300"
                                 style="width: {{ min(100, $monthlyBudgetPercentage) }}%"></div>
                        </div>

                        <!-- Spent & Remaining Details -->
                        <div class="mt-2.5 text-[11px] flex justify-between items-center text-text-secondary">
                            <span>Pakai: <strong class="text-expense font-medium">Rp {{ number_format($monthlyBudgetSpent, 0, ',', '.') }}</strong></span>
                            <span>
                                Sisa:
                                <strong class="font-medium {{ $monthlyBudgetOver > 0 ? 'text-expense' : 'text-income' }}">
                                    {{ $monthlyBudgetOver > 0 ? '-Rp ' . number_format($monthlyBudgetOver, 0, ',', '.') : 'Rp ' . number_format($monthlyBudgetRemaining, 0, ',', '.') }}
                                </strong>
                            </span>
                        </div>
                    </div>

                    <div class="mt-3 pt-2.5 border-t border-border/60">
                        <a href="{{ route('budgets.index') }}"
                           class="text-accent hover:underline text-xs font-medium inline-flex items-center gap-1">
                            <span>Kelola Anggaran</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Grafik Arus Kas & Anggaran -->
        <section class="bg-surface border border-border rounded-lg p-5">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3.5 pb-4 border-b border-border/80">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Grafik Arus Kas & Anggaran
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Komparasi pemasukan, pengeluaran, dan anggaran rencana per bulan pada tahun {{ $selectedYear }}.
                    </p>
                </div>

                <!-- Filter Tahun Dropdown -->
                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <label for="filter-year" class="text-xs font-medium text-text-secondary">
                        Tahun:
                    </label>
                    <select id="filter-year"
                            name="year"
                            onchange="this.form.submit()"
                            class="text-xs bg-nav-bg border border-border text-text-primary rounded-lg focus:border-accent focus:ring-1 focus:ring-accent py-1.5 px-3 cursor-pointer transition">
                        @foreach ($availableYears as $yearOption)
                            <option value="{{ $yearOption }}" {{ $yearOption == $selectedYear ? 'selected' : '' }}>
                                {{ $yearOption }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Chart Canvas Container -->
            <div class="relative w-full mt-4" style="height: 320px;">
                <canvas id="cashflowChart"></canvas>
            </div>
        </section>

        <!-- 4. Transaksi Terbaru -->
        <section class="bg-surface border border-border rounded-lg p-5">
            <div class="flex justify-between items-center pb-3.5 border-b border-border/80">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Transaksi Terbaru
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Daftar catatan transaksi pemasukan dan pengeluaran terkini.
                    </p>
                </div>

                <a href="{{ route('transactions.index') }}"
                   class="text-accent hover:underline text-xs font-semibold inline-flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="overflow-x-auto mt-2">
                <table class="min-w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-border text-text-secondary uppercase tracking-wider text-[11px]">
                            <th scope="col" class="py-3 px-3">Tanggal</th>
                            <th scope="col" class="py-3 px-3">Kategori</th>
                            <th scope="col" class="py-3 px-3">Dompet</th>
                            <th scope="col" class="py-3 px-3">Keterangan</th>
                            <th scope="col" class="py-3 px-3">Tipe</th>
                            <th scope="col" class="py-3 px-3 text-right">Nominal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border/60">
                        @forelse ($recentTransactions as $transaction)
                            <tr class="hover:bg-surface-hover/60 transition-colors">
                                <td class="py-3 px-3 text-text-secondary whitespace-nowrap">
                                    {{ $transaction->transaction_date
                                        ? $transaction->transaction_date->format('d/m/Y')
                                        : '-' }}
                                </td>

                                <td class="py-3 px-3 font-medium text-text-primary">
                                    {{ $transaction->category->name ?? '-' }}
                                </td>

                                <td class="py-3 px-3 text-text-secondary">
                                    {{ $transaction->wallet->name ?? '-' }}
                                </td>

                                <td class="py-3 px-3 text-text-secondary max-w-xs truncate">
                                    {{ $transaction->description ?? '-' }}
                                </td>

                                <td class="py-3 px-3">
                                    @if(strtolower($transaction->type) === 'income')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-income/15 text-income border border-income/30">
                                            Pemasukan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-expense/15 text-expense border border-expense/30">
                                            Pengeluaran
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3 px-3 text-right font-semibold whitespace-nowrap {{ strtolower($transaction->type) === 'income' ? 'text-income' : 'text-expense' }}">
                                    {{ strtolower($transaction->type) === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-text-secondary text-xs">
                                    Belum ada transaksi tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>

    <!-- Chart.js Script with Dark Theme Styling -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function initCashflowChart() {
            const ctx = document.getElementById('cashflowChart');
            if (!ctx) return;

            if (window.cashflowChartInstance) {
                window.cashflowChartInstance.destroy();
            }

            const labels = @json($chartLabels);
            const incomeData = @json($chartIncome);
            const expenseData = @json($chartExpense);
            const planData = @json($chartPlan);

            window.cashflowChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: incomeData,
                            backgroundColor: '#34D399',
                            borderColor: '#34D399',
                            borderWidth: 0,
                            borderRadius: 4,
                            maxBarThickness: 22
                        },
                        {
                            label: 'Pengeluaran',
                            data: expenseData,
                            backgroundColor: '#F87171',
                            borderColor: '#F87171',
                            borderWidth: 0,
                            borderRadius: 4,
                            maxBarThickness: 22
                        },
                        {
                            label: 'Anggaran Rencana',
                            data: planData,
                            backgroundColor: '#2DD4BF',
                            borderColor: '#2DD4BF',
                            borderWidth: 0,
                            borderRadius: 4,
                            maxBarThickness: 22
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 7,
                                boxHeight: 7,
                                padding: 14,
                                color: '#E6EDF7',
                                font: {
                                    size: 12,
                                    family: "'Plus Jakarta Sans', sans-serif",
                                    weight: 500
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0D1526',
                            borderColor: '#1E2A3F',
                            borderWidth: 1,
                            titleColor: '#E6EDF7',
                            bodyColor: '#E6EDF7',
                            padding: 12,
                            cornerRadius: 8,
                            boxPadding: 4,
                            usePointStyle: true,
                            callbacks: {
                                label: function (context) {
                                    const val = context.parsed.y ?? 0;
                                    return ' ' + context.dataset.label + ': Rp ' + Number(val).toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#8A97AD',
                                font: {
                                    size: 11,
                                    family: "'Plus Jakarta Sans', sans-serif"
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#1E2A3F'
                            },
                            ticks: {
                                color: '#8A97AD',
                                font: {
                                    size: 11,
                                    family: "'Plus Jakarta Sans', sans-serif"
                                },
                                callback: function (val) {
                                    if (val >= 1000000) {
                                        return 'Rp ' + (val / 1000000).toLocaleString('id-ID') + ' jt';
                                    } else if (val >= 1000) {
                                        return 'Rp ' + (val / 1000).toLocaleString('id-ID') + ' rb';
                                    }
                                    return 'Rp ' + Number(val).toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCashflowChart);
        } else {
            initCashflowChart();
        }
    </script>
</x-app-layout>
