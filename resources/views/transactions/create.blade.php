<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Tambah Transaksi
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Catat mutasi arus kas pemasukan atau pengeluaran baru ke dalam dompet.
                </p>
            </div>
            <a href="{{ route('transactions.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto space-y-6">

        <div class="bg-surface border border-border rounded-lg p-6 shadow-xs">
            <div class="mb-5 pb-4 border-b border-border/80">
                <h2 class="text-base font-semibold text-text-primary tracking-tight">
                    Formulir Transaksi Baru
                </h2>
                <p class="text-xs text-text-secondary mt-0.5">
                    Pastikan nominal dan kategori yang dipilih sudah tepat.
                </p>
            </div>

            <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Tipe Transaksi -->
                <div>
                    <label class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-2">
                        Tipe Transaksi <span class="text-expense">*</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center p-3 rounded-lg border border-border bg-nav-bg/60 hover:border-income/40 cursor-pointer transition select-none">
                            <input type="radio"
                                   name="type"
                                   value="income"
                                   id="type-income"
                                   {{ old('type') === 'income' ? 'checked' : '' }}
                                   class="text-income focus:ring-income h-4 w-4 bg-nav-bg border-border"
                                   onchange="filterCategories()">
                            <span class="ms-2.5 text-xs font-semibold text-income flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                                <span>Pemasukan (Income)</span>
                            </span>
                        </label>

                        <label class="flex items-center p-3 rounded-lg border border-border bg-nav-bg/60 hover:border-expense/40 cursor-pointer transition select-none">
                            <input type="radio"
                                   name="type"
                                   value="expense"
                                   id="type-expense"
                                   {{ old('type', 'expense') === 'expense' ? 'checked' : '' }}
                                   class="text-expense focus:ring-expense h-4 w-4 bg-nav-bg border-border"
                                   onchange="filterCategories()">
                            <span class="ms-2.5 text-xs font-semibold text-expense flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                <span>Pengeluaran (Expense)</span>
                            </span>
                        </label>
                    </div>

                    @error('type')
                        <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nominal Transaksi -->
                <div>
                    <label for="amount" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Nominal (Rp) <span class="text-expense">*</span>
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-text-secondary text-xs font-semibold pointer-events-none">
                            Rp
                        </span>
                        <input type="number"
                               id="amount"
                               name="amount"
                               value="{{ old('amount') }}"
                               min="0.01"
                               step="0.01"
                               placeholder="50000"
                               class="w-full bg-nav-bg border border-border text-text-primary placeholder:text-text-secondary/40 focus:border-accent focus:ring-1 focus:ring-accent rounded-lg text-sm pl-10 pr-3.5 py-2.5 transition"
                               required>
                    </div>

                    @error('amount')
                        <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Transaksi -->
                <div>
                    <label for="transaction_date" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Tanggal Transaksi <span class="text-expense">*</span>
                    </label>

                    <input type="date"
                           id="transaction_date"
                           name="transaction_date"
                           value="{{ old('transaction_date', date('Y-m-d')) }}"
                           class="w-full bg-nav-bg border border-border text-text-primary rounded-lg text-sm px-3.5 py-2.5 focus:border-accent focus:ring-1 focus:ring-accent transition cursor-pointer"
                           required>

                    @error('transaction_date')
                        <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Kategori <span class="text-expense">*</span>
                    </label>

                    <select id="category_id"
                            name="category_id"
                            class="w-full bg-nav-bg border border-border text-text-primary rounded-lg text-sm px-3.5 py-2.5 focus:border-accent focus:ring-1 focus:ring-accent transition cursor-pointer"
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
                        <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dompet / Wallet -->
                <div>
                    <label for="wallet_id" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Dompet / Rekening <span class="text-expense">*</span>
                    </label>

                    <select id="wallet_id"
                            name="wallet_id"
                            class="w-full bg-nav-bg border border-border text-text-primary rounded-lg text-sm px-3.5 py-2.5 focus:border-accent focus:ring-1 focus:ring-accent transition cursor-pointer"
                            required>
                        <option value="">-- Pilih Dompet --</option>
                        @foreach ($wallets as $wallet)
                            <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                                {{ $wallet->name }} (Saldo: Rp {{ number_format($wallet->balance, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>

                    @error('wallet_id')
                        <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi / Keterangan -->
                <div>
                    <label for="description" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Deskripsi / Keterangan <span class="text-expense">*</span>
                    </label>

                    <input type="text"
                           id="description"
                           name="description"
                           value="{{ old('description') }}"
                           placeholder="Contoh: Makan siang, Gaji bulanan, Kopi"
                           class="w-full bg-nav-bg border border-border text-text-primary placeholder:text-text-secondary/40 focus:border-accent focus:ring-1 focus:ring-accent rounded-lg text-sm px-3.5 py-2.5 transition"
                           required>

                    @error('description')
                        <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="pt-4 border-t border-border/80 flex items-center gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-accent text-page-bg hover:bg-accent/90 px-4 py-2.5 rounded-lg text-xs font-semibold transition cursor-pointer shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Transaksi</span>
                    </button>

                    <a href="{{ route('transactions.index') }}"
                       class="inline-flex items-center px-4 py-2.5 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>

    <script>
        function filterCategories() {
            const isIncome = document.getElementById('type-income').checked;
            const targetType = isIncome ? 'income' : 'expense';
            const categorySelect = document.getElementById('category_id');
            const options = categorySelect.querySelectorAll('option');

            options.forEach(option => {
                if (!option.value) return;
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
