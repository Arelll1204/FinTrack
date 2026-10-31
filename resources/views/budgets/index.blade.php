<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Anggaran FinTrack
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow mb-8">

                <!-- Header & Filter -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 pb-4 border-b">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">
                            Monitoring Anggaran ({{ $selectedMonthName }} {{ $selectedYear }})
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Pantau batas pengeluaran per kategori agar keuangan tetap terkontrol.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Filter Bulan & Tahun -->
                        <form method="GET" action="{{ route('budgets.index') }}" class="flex items-center gap-2">
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

                        <a href="{{ route('budgets.create') }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm whitespace-nowrap">
                            + Tambah Anggaran
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Ringkasan Periode Ini -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="p-4 bg-gray-50 rounded-lg border">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Total Anggaran</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">
                            Rp {{ number_format($totalBudget, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">{{ $budgets->count() }} kategori anggaran</p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Total Pengeluaran</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">
                            Rp {{ number_format($totalSpent, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Pada kategori yang dianggarkan</p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Sisa Anggaran</p>
                        <p class="text-2xl font-bold {{ $totalOver > 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                            @if ($totalOver > 0)
                                - Rp {{ number_format($totalOver, 0, ',', '.') }}
                            @else
                                Rp {{ number_format($totalRemaining, 0, ',', '.') }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $totalOver > 0 ? 'Kelebihan pengeluaran' : 'Tersisa untuk digunakan' }}
                        </p>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border">
                        <p class="text-xs font-semibold text-gray-500 uppercase">Pemakaian Keseluruhan</p>
                        <p class="text-2xl font-bold {{ $totalPercentage > 100 ? 'text-red-600' : ($totalPercentage >= 80 ? 'text-yellow-600' : 'text-indigo-600') }} mt-1">
                            {{ $totalPercentage }}%
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="{{ $totalPercentage > 100 ? 'bg-red-600' : ($totalPercentage >= 80 ? 'bg-yellow-500' : 'bg-indigo-600') }} h-2 rounded-full"
                                 style="width: {{ min(100, $totalPercentage) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Detail Anggaran -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border">Kategori</th>
                                <th class="p-3 text-right text-sm font-semibold text-gray-600 border">Batas Anggaran</th>
                                <th class="p-3 text-right text-sm font-semibold text-gray-600 border">Pengeluaran Aktual</th>
                                <th class="p-3 text-right text-sm font-semibold text-gray-600 border">Sisa / Kelebihan</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border" style="width: 220px;">Progress Pemakaian</th>
                                <th class="p-3 text-center text-sm font-semibold text-gray-600 border">Status</th>
                                <th class="p-3 text-center text-sm font-semibold text-gray-600 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse ($budgets as $budget)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 text-sm font-semibold text-gray-800 border">
                                        {{ $budget->category->name ?? '-' }}
                                    </td>

                                    <td class="p-3 text-sm text-right font-medium text-gray-700 border whitespace-nowrap">
                                        Rp {{ number_format($budget->amount, 0, ',', '.') }}
                                    </td>

                                    <td class="p-3 text-sm text-right font-medium text-red-600 border whitespace-nowrap">
                                        Rp {{ number_format($budget->calculated_spent, 0, ',', '.') }}
                                    </td>

                                    <td class="p-3 text-sm text-right font-semibold border whitespace-nowrap {{ $budget->remaining < 0 ? 'text-red-600' : 'text-green-600' }}">
                                        @if ($budget->remaining < 0)
                                            - Rp {{ number_format(abs($budget->remaining), 0, ',', '.') }}
                                            <span class="block text-xs font-normal text-red-500">
                                                (Lebih Rp {{ number_format($budget->over_budget, 0, ',', '.') }})
                                            </span>
                                        @else
                                            Rp {{ number_format($budget->remaining, 0, ',', '.') }}
                                        @endif
                                    </td>

                                    <td class="p-3 border">
                                        <div class="flex items-center justify-between text-xs font-medium text-gray-600 mb-1">
                                            <span>{{ $budget->percentage }}%</span>
                                            <span>
                                                @if ($budget->percentage > 100)
                                                    Melebihi
                                                @else
                                                    Tersisa {{ max(0, 100 - $budget->percentage) }}%
                                                @endif
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                            <div class="{{ $budget->progress_color }} h-2.5 rounded-full transition-all duration-300"
                                                 style="width: {{ min(100, $budget->percentage) }}%"></div>
                                        </div>
                                    </td>

                                    <td class="p-3 text-center border whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $budget->status_badge }}">
                                            @if ($budget->status === 'safe')
                                                &#10003; Aman
                                            @elseif ($budget->status === 'warning')
                                                &#9888; Hampir Habis
                                            @else
                                                &#10007; Melebihi Budget
                                            @endif
                                        </span>
                                    </td>

                                    <td class="p-3 text-center border whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('budgets.show', $budget->id) }}"
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Detail
                                            </a>

                                            <span class="text-gray-300">|</span>

                                            <a href="{{ route('budgets.edit', $budget->id) }}"
                                               class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                                Edit
                                            </a>

                                            <span class="text-gray-300">|</span>

                                            <form action="{{ route('budgets.destroy', $budget->id) }}"
                                                  method="POST"
                                                  class="inline"
                                                  onsubmit="return confirm('Apakah kamu yakin ingin menghapus anggaran kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-500">
                                        Belum ada anggaran yang diatur untuk <strong>{{ $selectedMonthName }} {{ $selectedYear }}</strong>.<br>
                                        <a href="{{ route('budgets.create') }}" class="text-indigo-600 hover:underline font-medium mt-2 inline-block">
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
    </div>
</x-app-layout>

