<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">

                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold text-gray-800">
                        Form Tambah Transaksi
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Catat pemasukan atau pengeluaran baru ke dalam dompet kamu.
                    </p>
                </div>

                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    <!-- Tipe Transaksi -->
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700 mb-2">
                            Tipe Transaksi <span class="text-red-500">*</span>
                        </label>

                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio"
                                       name="type"
                                       value="income"
                                       id="type-income"
                                       {{ old('type') === 'income' ? 'checked' : '' }}
                                       class="text-green-600 focus:ring-green-500 h-4 w-4"
                                       onchange="filterCategories()">
                                <span class="ms-2 font-medium text-green-700">
                                    + Pemasukan (Income)
                                </span>
                            </label>

                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio"
                                       name="type"
                                       value="expense"
                                       id="type-expense"
                                       {{ old('type', 'expense') === 'expense' ? 'checked' : '' }}
                                       class="text-red-600 focus:ring-red-500 h-4 w-4"
                                       onchange="filterCategories()">
                                <span class="ms-2 font-medium text-red-700">
                                    - Pengeluaran (Expense)
                                </span>
                            </label>
                        </div>

                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nominal Transaksi -->
                    <div class="mb-4">
                        <label for="amount" class="block font-medium text-gray-700 mb-2">
                            Nominal (Rp) <span class="text-red-500">*</span>
                        </label>

                        <input type="number"
                               id="amount"
                               name="amount"
                               value="{{ old('amount') }}"
                               min="0.01"
                               step="0.01"
                               placeholder="Contoh: 50000"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               required>

                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Transaksi -->
                    <div class="mb-4">
                        <label for="transaction_date" class="block font-medium text-gray-700 mb-2">
                            Tanggal Transaksi <span class="text-red-500">*</span>
                        </label>

                        <input type="date"
                               id="transaction_date"
                               name="transaction_date"
                               value="{{ old('transaction_date', date('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               required>

                        @error('transaction_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label for="category_id" class="block font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>

                        <select id="category_id"
                                name="category_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                        data-type="{{ $category->type }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }})
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dompet / Wallet -->
                    <div class="mb-4">
                        <label for="wallet_id" class="block font-medium text-gray-700 mb-2">
                            Dompet / Akun <span class="text-red-500">*</span>
                        </label>

                        <select id="wallet_id"
                                name="wallet_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                            <option value="">-- Pilih Dompet --</option>
                            @foreach ($wallets as $wallet)
                                <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                                    {{ $wallet->name }} (Saldo: Rp {{ number_format($wallet->balance, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>

                        @error('wallet_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi / Keterangan -->
                    <div class="mb-6">
                        <label for="description" class="block font-medium text-gray-700 mb-2">
                            Deskripsi / Keterangan <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               id="description"
                               name="description"
                               value="{{ old('description') }}"
                               placeholder="Contoh: Makan siang nasi padang, Gaji bulanan"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               required>

                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center gap-3">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-lg shadow transition">
                            Simpan Transaksi
                        </button>

                        <a href="{{ route('transactions.index') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-lg transition">
                            Batal
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <script>
        function filterCategories() {
            const isIncome = document.getElementById('type-income').checked;
            const targetType = isIncome ? 'income' : 'expense';
            const categorySelect = document.getElementById('category_id');
            const options = categorySelect.querySelectorAll('option');

            options.forEach(option => {
                if (!option.value) return; // opsi placeholder tetap ada
                const catType = option.getAttribute('data-type');
                if (catType === targetType) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                    if (option.selected) {
                        categorySelect.value = '';
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', filterCategories);
    </script>
</x-app-layout>

