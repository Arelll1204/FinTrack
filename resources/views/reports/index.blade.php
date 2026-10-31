<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Keuangan Bulanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Card Filter & Export -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">
                            Laporan Periode {{ $selectedMonthName }} {{ $selectedYear }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Ringkasan performa finansial, arus kas, dan analisis pengeluaran per kategori.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Filter Bulan & Tahun -->
                        <form method="GET" action="{{ route('reports.index') }}" class="flex items-center gap-2">
                            <select name="month"
                                    onchange="this.form.submit()"
                                    class="text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1.5 px-3 bg-gray-50">
                                @foreach ($monthNames as $num => $name)
                                    <option value="{{ $num }}" {{ $num == $selectedMonth ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="year"
                                    onchange="this.form.submit()"
                                    class="text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1.5 px-3 bg-gray-50">
                                @foreach ($availableYears as $y)
                                    <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <!-- Tombol Ekspor Excel -->
                        <a href="{{ route('reports.export', ['month' => $selectedMonth, 'year' => $selectedYear]) }}"
                           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm whitespace-nowrap text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Ekspor Excel
                        </a>

                        <!-- Tombol Export PDF / Cetak -->
                        <a href="{{ route('reports.print', ['month' => $selectedMonth, 'year' => $selectedYear]) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm whitespace-nowrap text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak / Ekspor PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- 4 Kartu Metrik Utama -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $incomeCount }} transaksi pemasukan
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-red-600 mt-2">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $expenseCount }} transaksi pengeluaran
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 {{ $netCashflow >= 0 ? 'border-indigo-500' : 'border-red-600' }}">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Selisih (Arus Kas Bersih)</p>
                    <p class="text-2xl font-bold mt-2 {{ $netCashflow >= 0 ? 'text-indigo-600' : 'text-red-600' }}">
                        {{ $netCashflow >= 0 ? '+' : '' }} Rp {{ number_format($netCashflow, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $netCashflow >= 0 ? 'Surplus (Pemasukan > Pengeluaran)' : 'Defisit (Pengeluaran > Pemasukan)' }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-gray-400">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">
                        {{ $totalTransactionsCount }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Selama {{ $selectedMonthName }} {{ $selectedYear }}
                    </p>
                </div>

            </div>

            <!-- 2 Grafik Laporan -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Grafik Perbandingan Pemasukan & Pengeluaran -->
                <div class="bg-white p-6 rounded-lg shadow flex flex-col justify-between">
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">
                            Perbandingan Pemasukan & Pengeluaran
                        </h4>
                        <p class="text-xs text-gray-500 mt-1">
                            Perbandingan total nominal arus kas masuk dan keluar.
                        </p>
                    </div>

                    <div class="relative w-full mt-4" style="height: 280px;">
                        <canvas id="cashflowComparisonChart"></canvas>
                    </div>
                </div>

                <!-- Grafik Pengeluaran Berdasarkan Kategori -->
                <div class="bg-white p-6 rounded-lg shadow flex flex-col justify-between">
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">
                            Komposisi Pengeluaran per Kategori
                        </h4>
                        <p class="text-xs text-gray-500 mt-1">
                            Distribusi alokasi dana pengeluaran bulan ini.
                        </p>
                    </div>

                    <div class="relative w-full mt-4 flex items-center justify-center" style="height: 280px;">
                        @if ($categoryExpenses->isEmpty())
                            <p class="text-gray-400 text-sm">Belum ada transaksi pengeluaran pada periode ini.</p>
                        @else
                            <canvas id="categoryExpenseChart"></canvas>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Tabel Analisis Pengeluaran Berdasarkan Kategori -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="mb-4">
                    <h4 class="text-lg font-bold text-gray-800">
                        Rincian Pengeluaran Berdasarkan Kategori
                    </h4>
                    <p class="text-sm text-gray-500 mt-1">
                        Alokasi pengeluaran dari yang terbesar hingga terkecil.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border">Kategori</th>
                                <th class="p-3 text-center text-sm font-semibold text-gray-600 border">Jumlah Transaksi</th>
                                <th class="p-3 text-right text-sm font-semibold text-gray-600 border">Total Pengeluaran</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border" style="width: 250px;">Proporsi (%)</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse ($categoryExpenses as $cat)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-sm font-semibold text-gray-800 border">
                                        {{ $cat->category_name }}
                                    </td>

                                    <td class="p-3 text-sm text-center text-gray-600 border">
                                        {{ $cat->count }} kali
                                    </td>

                                    <td class="p-3 text-sm text-right font-bold text-red-600 border whitespace-nowrap">
                                        Rp {{ number_format($cat->total_amount, 0, ',', '.') }}
                                    </td>

                                    <td class="p-3 border">
                                        <div class="flex items-center justify-between text-xs font-semibold text-gray-600 mb-1">
                                            <span>{{ $cat->percentage }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                            <div class="bg-red-500 h-2.5 rounded-full"
                                                 style="width: {{ min(100, $cat->percentage) }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-gray-500 text-sm">
                                        Belum ada pengeluaran yang tercatat pada periode {{ $selectedMonthName }} {{ $selectedYear }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Daftar Seluruh Transaksi Periode Terpilih -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">
                            Daftar Transaksi Periode Ini
                        </h4>
                        <p class="text-sm text-gray-500 mt-1">
                            Seluruh mutasi pemasukan dan pengeluaran selama {{ $selectedMonthName }} {{ $selectedYear }}.
                        </p>
                    </div>

                    <span class="text-xs font-semibold bg-gray-100 text-gray-700 px-3 py-1 rounded-full border">
                        {{ $transactions->count() }} Data
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border">Tanggal</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border">Deskripsi</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border">Kategori</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border">Dompet</th>
                                <th class="p-3 text-center text-sm font-semibold text-gray-600 border">Tipe</th>
                                <th class="p-3 text-right text-sm font-semibold text-gray-600 border">Nominal</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse ($transactions as $t)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 text-sm text-gray-700 border whitespace-nowrap">
                                        {{ $t->transaction_date ? $t->transaction_date->format('d/m/Y') : '-' }}
                                    </td>

                                    <td class="p-3 text-sm text-gray-800 font-medium border">
                                        {{ $t->description }}
                                    </td>

                                    <td class="p-3 text-sm text-gray-600 border">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $t->category->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="p-3 text-sm text-gray-600 border">
                                        {{ $t->wallet->name ?? '-' }}
                                    </td>

                                    <td class="p-3 text-center border whitespace-nowrap">
                                        @if ($t->type === 'income')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                Pemasukan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                Pengeluaran
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-3 text-right font-bold border whitespace-nowrap {{ $t->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $t->type === 'income' ? '+' : '-' }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-500 text-sm">
                                        Tidak ada transaksi yang tercatat pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Script -->
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
                                'rgba(22, 163, 74, 0.85)', // Pemasukan (Hijau)
                                'rgba(220, 38, 38, 0.85)'  // Pengeluaran (Merah)
                            ],
                            borderColor: [
                                'rgb(22, 163, 74)',
                                'rgb(220, 38, 38)'
                            ],
                            borderWidth: 1,
                            borderRadius: 8,
                            maxBarThickness: 60
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
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
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
                                '#ef4444', '#f59e0b', '#3b82f6', '#8b5cf6',
                                '#10b981', '#ec4899', '#06b6d4', '#6366f1',
                                '#84cc16', '#14b8a6', '#64748b'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 12,
                                    padding: 12,
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            tooltip: {
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

