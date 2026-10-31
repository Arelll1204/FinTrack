<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Laporan Keuangan
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Analisis komprehensif performa arus kas dan rincian pengeluaran bulanan.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Filter Bulan & Tahun Form -->
                <form method="GET" action="{{ route('reports.index') }}" class="flex items-center gap-1.5">
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

                <!-- Tombol Ekspor Excel -->
                <a href="{{ route('reports.export', ['month' => $selectedMonth, 'year' => $selectedYear]) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface border border-border text-text-primary hover:bg-surface-hover hover:border-border-light transition shadow-xs">
                    <svg class="w-3.5 h-3.5 text-income" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span>Ekspor Excel</span>
                </a>

                <!-- Tombol Cetak / PDF -->
                <a href="{{ route('reports.print', ['month' => $selectedMonth, 'year' => $selectedYear]) }}"
                   target="_blank"
                   class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak PDF</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">

        <!-- 4 Kartu Metrik Utama -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
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
                    <p class="text-[11px] text-text-secondary mt-1">{{ $incomeCount }} transaksi masuk</p>
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
                    <p class="text-[11px] text-text-secondary mt-1">{{ $expenseCount }} transaksi keluar</p>
                </div>
            </div>

            <!-- Selisih Arus Kas Bersih -->
            <div class="bg-surface border border-border rounded-lg p-4 transition hover:border-accent/40 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-text-secondary uppercase tracking-wider">Arus Kas Bersih</span>
                    <div class="w-8 h-8 rounded-lg {{ $netCashflow >= 0 ? 'bg-accent/15 border-accent/25 text-accent' : 'bg-expense/15 border-expense/25 text-expense' }} border flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2.5">
                    <p class="text-2xl font-bold tracking-tight {{ $netCashflow >= 0 ? 'text-accent' : 'text-expense' }}">
                        {{ $netCashflow >= 0 ? '+' : '' }} Rp {{ number_format($netCashflow, 0, ',', '.') }}
                    </p>
                    <p class="text-[11px] text-text-secondary mt-1">
                        {{ $netCashflow >= 0 ? 'Surplus finansial' : 'Defisit (Pengeluaran > Pemasukan)' }}
                    </p>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="bg-surface border border-border rounded-lg p-4 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-text-secondary uppercase tracking-wider">Total Transaksi</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-500/15 border border-blue-500/25 flex items-center justify-center text-blue-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2.5">
                    <p class="text-2xl font-bold text-text-primary tracking-tight">
                        {{ $totalTransactionsCount }}
                    </p>
                    <p class="text-[11px] text-text-secondary mt-1">Periode {{ $selectedMonthName }} {{ $selectedYear }}</p>
                </div>
            </div>
        </div>

        <!-- 2 Grafik Laporan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Grafik Perbandingan Arus Kas -->
            <div class="bg-surface border border-border rounded-lg p-5 shadow-xs flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Perbandingan Arus Kas
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Komparasi total dana masuk vs dana keluar pada periode {{ $selectedMonthName }} {{ $selectedYear }}.
                    </p>
                </div>

                <div class="relative w-full mt-4" style="height: 260px;">
                    <canvas id="cashflowComparisonChart"></canvas>
                </div>
            </div>

            <!-- Grafik Komposisi Pengeluaran per Kategori -->
            <div class="bg-surface border border-border rounded-lg p-5 shadow-xs flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Komposisi Pengeluaran
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Distribusi proporsi belanja menurut kategori pengeluaran.
                    </p>
                </div>

                <div class="relative w-full mt-4 flex items-center justify-center" style="height: 260px;">
                    @if ($categoryExpenses->isEmpty())
                        <p class="text-text-secondary text-xs text-center py-10">
                            Belum ada transaksi pengeluaran pada periode {{ $selectedMonthName }} {{ $selectedYear }}.
                        </p>
                    @else
                        <canvas id="categoryExpenseChart"></canvas>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabel Analisis Pengeluaran Berdasarkan Kategori -->
        <div class="bg-surface border border-border rounded-lg p-5 shadow-xs">
            <div class="pb-3 mb-3 border-b border-border/80">
                <h2 class="text-base font-semibold text-text-primary tracking-tight">
                    Rincian Alokasi per Kategori
                </h2>
                <p class="text-xs text-text-secondary mt-0.5">
                    Peringkat kategori pengeluaran dari nominal terbesar ke terkecil.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-border text-text-secondary uppercase tracking-wider text-[11px]">
                            <th scope="col" class="py-3 px-3">Kategori</th>
                            <th scope="col" class="py-3 px-3 text-center">Jumlah Transaksi</th>
                            <th scope="col" class="py-3 px-3 text-right">Total Pengeluaran</th>
                            <th scope="col" class="py-3 px-3" style="width: 260px;">Proporsi (%)</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border/60">
                        @forelse ($categoryExpenses as $cat)
                            <tr class="hover:bg-surface-hover/60 transition-colors">
                                <td class="py-3 px-3 font-semibold text-text-primary">
                                    {{ $cat->category_name }}
                                </td>

                                <td class="py-3 px-3 text-center text-text-secondary">
                                    {{ $cat->count }} kali
                                </td>

                                <td class="py-3 px-3 text-right font-bold text-expense whitespace-nowrap">
                                    Rp {{ number_format($cat->total_amount, 0, ',', '.') }}
                                </td>

                                <td class="py-3 px-3">
                                    <div class="flex items-center justify-between text-[11px] font-semibold text-text-secondary mb-1">
                                        <span class="text-expense">{{ $cat->percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-page-bg border border-border rounded-full h-2 overflow-hidden">
                                        <div class="bg-expense h-full rounded-full transition-all duration-300"
                                             style="width: {{ min(100, $cat->percentage) }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-text-secondary text-xs">
                                    Belum ada transaksi pengeluaran pada periode {{ $selectedMonthName }} {{ $selectedYear }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Transaksi Periode Terpilih -->
        <div class="bg-surface border border-border rounded-lg p-5 shadow-xs">
            <div class="flex justify-between items-center pb-3 mb-3 border-b border-border/80">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Daftar Mutasi Transaksi Periode Ini
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Rekap seluruh catatan transaksi pemasukan dan pengeluaran pada {{ $selectedMonthName }} {{ $selectedYear }}.
                    </p>
                </div>

                <span class="text-xs font-semibold bg-nav-bg border border-border text-text-secondary px-3 py-1 rounded-full">
                    {{ $transactions->count() }} Transaksi
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-border text-text-secondary uppercase tracking-wider text-[11px]">
                            <th scope="col" class="py-3 px-3">Tanggal</th>
                            <th scope="col" class="py-3 px-3">Deskripsi</th>
                            <th scope="col" class="py-3 px-3">Kategori</th>
                            <th scope="col" class="py-3 px-3">Dompet</th>
                            <th scope="col" class="py-3 px-3 text-center">Tipe</th>
                            <th scope="col" class="py-3 px-3 text-right">Nominal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border/60">
                        @forelse ($transactions as $t)
                            <tr class="hover:bg-surface-hover/60 transition-colors">
                                <td class="py-3 px-3 text-text-secondary whitespace-nowrap">
                                    {{ $t->transaction_date ? $t->transaction_date->format('d/m/Y') : '-' }}
                                </td>

                                <td class="py-3 px-3 font-medium text-text-primary max-w-xs truncate">
                                    {{ $t->description }}
                                </td>

                                <td class="py-3 px-3 text-text-secondary">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-nav-bg border border-border text-text-primary">
                                        {{ $t->category->name ?? '-' }}
                                    </span>
                                </td>

                                <td class="py-3 px-3 text-text-secondary whitespace-nowrap">
                                    {{ $t->wallet->name ?? '-' }}
                                </td>

                                <td class="py-3 px-3 text-center whitespace-nowrap">
                                    @if ($t->type === 'income')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-income/15 text-income border border-income/30">
                                            Pemasukan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-expense/15 text-expense border border-expense/30">
                                            Pengeluaran
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3 px-3 text-right font-bold whitespace-nowrap {{ $t->type === 'income' ? 'text-income' : 'text-expense' }}">
                                    {{ $t->type === 'income' ? '+' : '-' }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-text-secondary text-xs">
                                    Tidak ada transaksi yang tercatat pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Chart.js Dark Styling Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Grafik Perbandingan Arus Kas
            const ctxComparison = document.getElementById('cashflowComparisonChart');
            if (ctxComparison) {
                new Chart(ctxComparison, {
                    type: 'bar',
                    data: {
                        labels: @json($chartComparisonLabels),
                        datasets: [{
                            label: 'Total Arus Kas',
                            data: @json($chartComparisonData),
                            backgroundColor: [
                                '#34D399', // Pemasukan (Hijau)
                                '#F87171'  // Pengeluaran (Merah)
                            ],
                            borderColor: [
                                '#34D399',
                                '#F87171'
                            ],
                            borderWidth: 0,
                            borderRadius: 6,
                            maxBarThickness: 56
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0D1526',
                                borderColor: '#1E2A3F',
                                borderWidth: 1,
                                titleColor: '#E6EDF7',
                                bodyColor: '#E6EDF7',
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function (context) {
                                        return ' ' + context.label + ': Rp ' + Number(context.parsed.y || 0).toLocaleString('id-ID');
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
                                        if (val >= 1000000) return 'Rp ' + (val / 1000000).toLocaleString('id-ID') + ' jt';
                                        if (val >= 1000) return 'Rp ' + (val / 1000).toLocaleString('id-ID') + ' rb';
                                        return 'Rp ' + Number(val).toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // 2. Grafik Komposisi Pengeluaran Berdasarkan Kategori
            const ctxCategory = document.getElementById('categoryExpenseChart');
            const catLabels = @json($chartCategoryLabels);
            const catData = @json($chartCategoryData);

            if (ctxCategory && catLabels.length > 0) {
                new Chart(ctxCategory, {
                    type: 'doughnut',
                    data: {
                        labels: catLabels,
                        datasets: [{
                            data: catData,
                            backgroundColor: [
                                '#F87171', '#FBBF24', '#2DD4BF', '#34D399',
                                '#60A5FA', '#A78BFA', '#F472B6', '#38BDF8',
                                '#FB923C', '#4ADE80', '#94A3B8'
                            ],
                            borderWidth: 2,
                            borderColor: '#111A2B'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 10,
                                    padding: 12,
                                    color: '#E6EDF7',
                                    font: {
                                        size: 11,
                                        family: "'Plus Jakarta Sans', sans-serif"
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
                                callbacks: {
                                    label: function (context) {
                                        const label = context.label || '';
                                        const val = context.parsed || 0;
                                        return ' ' + label + ': Rp ' + Number(val).toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
