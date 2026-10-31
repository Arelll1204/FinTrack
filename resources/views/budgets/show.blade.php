<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Anggaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow mb-8">

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 border-b pb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">
                            Anggaran: {{ $budget->category->name ?? '-' }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Periode: {{ $monthName }} {{ $budget->year }}
                        </p>
                    </div>

                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold border {{ $budget->status_badge }}">
                        @if ($budget->percentage > 100)
                            &#10007; {{ $budget->status_label }}
                        @elseif ($budget->percentage >= 80)
                            &#9888; {{ $budget->status_label }}
                        @else
                            &#10003; {{ $budget->status_label }}
                        @endif
                    </span>
                </div>

                <!-- Progress Bar Card -->
                <div class="p-6 bg-gray-50 rounded-lg border mb-6">
                    <div class="flex justify-between items-center text-sm font-semibold text-gray-700 mb-2">
                        <span>Pemakaian: {{ $budget->percentage }}%</span>
                        <span>
                            @if ($budget->remaining < 0)
                                <span class="text-red-600">Melebihi Rp {{ number_format($budget->over_budget, 0, ',', '.') }}</span>
                            @else
                                <span class="text-green-600">Sisa Rp {{ number_format($budget->remaining, 0, ',', '.') }}</span>
                            @endif
                        </span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden mb-4">
                        <div class="{{ $budget->progress_color }} h-4 rounded-full transition-all duration-300"
                             style="width: {{ min(100, $budget->percentage) }}%"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t text-center">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Batas Anggaran</p>
                            <p class="text-xl font-bold text-gray-800 mt-1">
                                Rp {{ number_format($budget->amount, 0, ',', '.') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Total Pengeluaran</p>
                            <p class="text-xl font-bold text-red-600 mt-1">
                                Rp {{ number_format($budget->calculated_spent, 0, ',', '.') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Sisa Anggaran</p>
                            <p class="text-xl font-bold {{ $budget->remaining < 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                                @if ($budget->remaining < 0)
                                    - Rp {{ number_format(abs($budget->remaining), 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($budget->remaining, 0, ',', '.') }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Daftar Transaksi Pengeluaran Terkait -->
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-gray-800 mb-3">
                        Transaksi Pengeluaran Terkait ({{ $transactions->count() }})
                    </h4>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-3 text-left text-xs font-semibold text-gray-600 border">Tanggal</th>
                                    <th class="p-3 text-left text-xs font-semibold text-gray-600 border">Keterangan</th>
                                    <th class="p-3 text-left text-xs font-semibold text-gray-600 border">Dompet</th>
                                    <th class="p-3 text-right text-xs font-semibold text-gray-600 border">Nominal</th>
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
                                            {{ $t->wallet->name ?? '-' }}
                                        </td>
                                        <td class="p-3 text-sm text-right font-semibold text-red-600 border whitespace-nowrap">
                                            - Rp {{ number_format($t->amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-6 text-center text-gray-500 text-sm">
                                            Belum ada transaksi pengeluaran pada kategori ini untuk periode {{ $monthName }} {{ $budget->year }}.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <div class="flex items-center gap-3 pt-4 border-t">
                    <a href="{{ route('budgets.edit', $budget->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-lg transition">
                        Edit Anggaran
                    </a>

                    <form action="{{ route('budgets.destroy', $budget->id) }}"
                          method="POST"
                          class="inline"
                          onsubmit="return confirm('Apakah kamu yakin ingin menghapus anggaran ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition">
                            Hapus
                        </button>
                    </form>

                    <a href="{{ route('budgets.index', ['month' => $budget->month, 'year' => $budget->year]) }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-lg transition ms-auto">
                        Kembali ke Daftar
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

