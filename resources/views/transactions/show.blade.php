<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">

                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            Informasi Transaksi
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Rincian data transaksi yang telah dicatat.
                        </p>
                    </div>

                    @if ($transaction->type === 'income')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            + Pemasukan
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                            - Pengeluaran
                        </span>
                    @endif
                </div>

                <div class="space-y-4 mb-8">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nominal</p>
                        <p class="text-3xl font-extrabold mt-1 {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="border p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal Transaksi</p>
                            <p class="text-base font-semibold text-gray-800 mt-1">
                                {{ $transaction->transaction_date ? $transaction->transaction_date->format('d F Y') : '-' }}
                            </p>
                        </div>

                        <div class="border p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</p>
                            <p class="text-base font-semibold text-gray-800 mt-1">
                                {{ $transaction->category->name ?? '-' }}
                            </p>
                        </div>

                        <div class="border p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dompet / Akun</p>
                            <p class="text-base font-semibold text-gray-800 mt-1">
                                {{ $transaction->wallet->name ?? '-' }}
                            </p>
                        </div>

                        <div class="border p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Waktu Pencatatan</p>
                            <p class="text-base font-semibold text-gray-800 mt-1">
                                {{ $transaction->created_at ? $transaction->created_at->format('d/m/Y H:i') : '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="border p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Deskripsi / Keterangan</p>
                        <p class="text-base text-gray-800 mt-1 whitespace-pre-line">
                            {{ $transaction->description }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t">
                    <a href="{{ route('transactions.edit', $transaction->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-lg transition">
                        Edit Transaksi
                    </a>

                    <form action="{{ route('transactions.destroy', $transaction->id) }}"
                          method="POST"
                          class="inline"
                          onsubmit="return confirm('Apakah kamu yakin ingin menghapus transaksi ini? Saldo dompet akan disesuaikan kembali.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition">
                            Hapus
                        </button>
                    </form>

                    <a href="{{ route('transactions.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-lg transition ms-auto">
                        Kembali ke Daftar
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

