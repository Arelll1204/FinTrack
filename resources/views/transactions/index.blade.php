<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi FinTrack
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 pb-4 border-b">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">
                            Daftar Transaksi
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Kelola seluruh transaksi pemasukan dan pengeluaran kamu.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('transactions.export', request()->query()) }}"
                           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm text-sm whitespace-nowrap">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Ekspor Excel
                        </a>

                        <a href="{{ route('transactions.create') }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm text-sm whitespace-nowrap">
                            + Tambah Transaksi
                        </a>
                    </div>
                </div>

                <!-- Filter Periode & Tipe -->
                <form method="GET" action="{{ route('transactions.index') }}" class="bg-gray-50 p-4 rounded-lg border mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <div>
                            <label for="start_date" class="block text-xs font-semibold text-gray-600 uppercase mb-1">Tanggal Mulai</label>
                            <input type="date"
                                   id="start_date"
                                   name="start_date"
                                   value="{{ $startDate }}"
                                   class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1.5 px-3">
                        </div>

                        <div>
                            <label for="end_date" class="block text-xs font-semibold text-gray-600 uppercase mb-1">Tanggal Akhir</label>
                            <input type="date"
                                   id="end_date"
                                   name="end_date"
                                   value="{{ $endDate }}"
                                   class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1.5 px-3">
                        </div>

                        <div>
                            <label for="type" class="block text-xs font-semibold text-gray-600 uppercase mb-1">Tipe</label>
                            <select id="type"
                                    name="type"
                                    class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-1.5 px-3">
                                <option value="">Semua Tipe</option>
                                <option value="income" {{ $type === 'income' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="expense" {{ $type === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm flex-1">
                                Filter
                            </button>

                            @if ($startDate || $endDate || $type)
                                <a href="{{ route('transactions.index') }}"
                                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm font-medium transition text-center">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border">Tanggal</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border">Keterangan / Deskripsi</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border">Kategori</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-600 border">Dompet</th>
                                <th class="p-3 text-center text-sm font-semibold text-gray-600 border">Tipe</th>
                                <th class="p-3 text-right text-sm font-semibold text-gray-600 border">Nominal</th>
                                <th class="p-3 text-center text-sm font-semibold text-gray-600 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse ($transactions as $transaction)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 text-sm text-gray-700 border whitespace-nowrap">
                                        {{ $transaction->transaction_date ? $transaction->transaction_date->format('d/m/Y') : '-' }}
                                    </td>

                                    <td class="p-3 text-sm text-gray-800 font-medium border">
                                        {{ $transaction->description }}
                                    </td>

                                    <td class="p-3 text-sm text-gray-600 border">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $transaction->category->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="p-3 text-sm text-gray-600 border">
                                        {{ $transaction->wallet->name ?? '-' }}
                                    </td>

                                    <td class="p-3 text-center border whitespace-nowrap">
                                        @if ($transaction->type === 'income')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                Pemasukan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                Pengeluaran
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-3 text-right font-semibold border whitespace-nowrap {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>

                                    <td class="p-3 text-center border whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('transactions.show', $transaction->id) }}"
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Detail
                                            </a>

                                            <span class="text-gray-300">|</span>

                                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                               class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                                Edit
                                            </a>

                                            <span class="text-gray-300">|</span>

                                            <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                                  method="POST"
                                                  class="inline"
                                                  onsubmit="return confirm('Apakah kamu yakin ingin menghapus transaksi ini? Saldo dompet akan disesuaikan kembali.')">
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
                                        Belum ada data transaksi. Silakan klik tombol <strong>+ Tambah Transaksi</strong> di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($transactions->hasPages())
                    <div class="mt-6">
                        {{ $transactions->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>

