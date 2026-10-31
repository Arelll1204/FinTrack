
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard FinTrack
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800">
                    Ringkasan Keuangan
                </h3>

                <p class="text-sm text-gray-500">
                    Pantau kondisi keuangan kamu secara keseluruhan.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Saldo</h3>

                    <p class="text-2xl font-bold mt-2">
                        Rp {{ number_format($totalBalance, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Pemasukan</h3>

                    <p class="text-2xl font-bold text-green-600 mt-2">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Pengeluaran</h3>

                    <p class="text-2xl font-bold text-red-600 mt-2">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Budget</h3>

                    <p class="text-2xl font-bold mt-2">
                        Rp {{ number_format($totalBudget, 0, ',', '.') }}
                    </p>
                </div>

            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Ringkasan Bulan Ini ({{ $currentMonthName }} {{ $currentYear }})
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-gray-500 text-sm">Pemasukan Bulan Ini</h3>

                        <p class="text-xl font-bold text-green-600 mt-2">
                            Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-gray-500 text-sm">Pengeluaran Bulan Ini</h3>

                        <p class="text-xl font-bold text-red-600 mt-2">
                            Rp {{ number_format($monthlyExpense, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-gray-500 text-sm">Rencana Bulan Ini</h3>

                        <p class="text-xl font-bold mt-2">
                            Rp {{ number_format($monthlyPlanTotal, 0, ',', '.') }}
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $monthlyPlans->count() }} rencana ({{ $currentMonthName }})
                        </p>

                        <a href="{{ route('monthly-plans.index') }}"
                           class="text-indigo-600 text-sm hover:underline mt-3 inline-block">
                            Lihat Semua Perencanaan
                        </a>
                    </div>

                    <!-- Anggaran Bulan Ini -->
                    <div class="bg-white p-6 rounded-lg shadow flex flex-col justify-between">
                        <div>
                            <h3 class="text-gray-500 text-sm">Anggaran Bulan Ini</h3>

                            <p class="text-xl font-bold mt-2 text-gray-800">
                                Rp {{ number_format($monthlyBudgetTotal, 0, ',', '.') }}
                            </p>

                            <div class="mt-2 text-xs text-gray-600 space-y-1">
                                <div class="flex justify-between">
                                    <span>Terpakai:</span>
                                    <span class="font-semibold text-red-600">Rp {{ number_format($monthlyBudgetSpent, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Sisa:</span>
                                    <span class="font-semibold {{ $monthlyBudgetOver > 0 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $monthlyBudgetOver > 0 ? '-Rp ' . number_format($monthlyBudgetOver, 0, ',', '.') : 'Rp ' . number_format($monthlyBudgetRemaining, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="{{ $monthlyBudgetPercentage > 100 ? 'bg-red-600' : ($monthlyBudgetPercentage >= 80 ? 'bg-yellow-500' : 'bg-green-600') }} h-2 rounded-full"
                                     style="width: {{ min(100, $monthlyBudgetPercentage) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 text-right">
                                Pemakaian {{ $monthlyBudgetPercentage }}%
                            </p>
                        </div>

                        <a href="{{ route('budgets.index') }}"
                           class="text-indigo-600 text-sm hover:underline mt-3 inline-block">
                            Lihat Anggaran &rarr;
                        </a>
                    </div>

                </div>
            </div>

            <!-- Grafik Pemasukan, Pengeluaran & Anggaran Rencana 12 Bulan -->
            <div class="bg-white mt-8 p-6 rounded-lg shadow">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">
                            Grafik Arus Kas & Anggaran ({{ $selectedYear }})
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Perbandingan pemasukan, pengeluaran, dan anggaran rencana per bulan pada tahun {{ $selectedYear }}.
                        </p>
                    </div>

                    <!-- Filter Tahun -->
                    <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <label for="filter-year" class="text-sm font-medium text-gray-600">
                            Pilih Tahun:
                        </label>
                        <select id="filter-year"
                                name="year"
                                onchange="this.form.submit()"
                                class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1.5 px-3 bg-gray-50 hover:bg-white cursor-pointer transition">
                            @foreach ($availableYears as $yearOption)
                                <option value="{{ $yearOption }}" {{ $yearOption == $selectedYear ? 'selected' : '' }}>
                                    {{ $yearOption }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="relative w-full" style="height: 340px;">
                    <canvas id="cashflowChart"></canvas>
                </div>
            </div>

            <div class="bg-white mt-8 p-6 rounded-lg shadow">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">
                        Transaksi Terbaru
                    </h3>

                    <a href="{{ route('transactions.index') }}" class="text-indigo-600 hover:underline text-sm font-medium">
                        Lihat Semua Transaksi &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3">Tanggal</th>
                                <th class="text-left py-3">Kategori</th>
                                <th class="text-left py-3">Dompet</th>
                                <th class="text-left py-3">Keterangan</th>
                                <th class="text-left py-3">Tipe</th>
                                <th class="text-right py-3">Nominal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($recentTransactions as $transaction)
                                <tr class="border-b">
                                    <td class="py-3">
                                        {{ $transaction->transaction_date
                                            ? $transaction->transaction_date->format('d/m/Y')
                                            : '-' }}
                                    </td>

                                    <td class="py-3">
                                        {{ $transaction->category->name ?? '-' }}
                                    </td>

                                    <td class="py-3">
                                        {{ $transaction->wallet->name ?? '-' }}
                                    </td>

                                    <td class="py-3">
                                        {{ $transaction->description ?? '-' }}
                                    </td>

                                    <td class="py-3">
                                        {{ ucfirst($transaction->type) }}
                                    </td>

                                    <td class="py-3 text-right">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-gray-500">
                                        Belum ada transaksi.
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
                            backgroundColor: 'rgba(22, 163, 74, 0.85)',
                            borderColor: 'rgb(22, 163, 74)',
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 24
                        },
                        {
                            label: 'Pengeluaran',
                            data: expenseData,
                            backgroundColor: 'rgba(220, 38, 38, 0.85)',
                            borderColor: 'rgb(220, 38, 38)',
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 24
                        },
                        {
                            label: 'Anggaran Rencana',
                            data: planData,
                            backgroundColor: 'rgba(79, 70, 229, 0.85)',
                            borderColor: 'rgb(79, 70, 229)',
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 24
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
                                boxWidth: 8,
                                boxHeight: 8,
                                padding: 16,
                                font: {
                                    size: 13,
                                    family: "'Figtree', sans-serif"
                                }
                            }
                        },
                        tooltip: {
                            padding: 12,
                            cornerRadius: 8,
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
                                font: {
                                    size: 12,
                                    family: "'Figtree', sans-serif"
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12,
                                    family: "'Figtree', sans-serif"
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
