<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Tambah Kategori
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Buat klasifikasi pemasukan atau pengeluaran baru.
                </p>
            </div>
            <a href="{{ route('categories.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto space-y-6">

        <div class="bg-surface border border-border rounded-lg p-6 shadow-xs">
            <div class="mb-5 pb-4 border-b border-border/80">
                <h2 class="text-base font-semibold text-text-primary tracking-tight">
                    Formulir Kategori Baru
                </h2>
                <p class="text-xs text-text-secondary mt-0.5">
                    Pilih tipe kategori yang sesuai dengan transaksi.
                </p>
            </div>

            <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Nama Kategori <span class="text-expense">*</span>
                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           class="w-full bg-nav-bg border border-border text-text-primary placeholder:text-text-secondary/40 focus:border-accent focus:ring-1 focus:ring-accent rounded-lg text-sm px-3.5 py-2.5 transition"
                           placeholder="Contoh: Makanan & Minuman, Gaji, Transportasi"
                           required>

                    @error('name')
                        <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Tipe Kategori <span class="text-expense">*</span>
                    </label>

                    <select id="type"
                            name="type"
                            class="w-full bg-nav-bg border border-border text-text-primary rounded-lg text-sm px-3.5 py-2.5 focus:border-accent focus:ring-1 focus:ring-accent transition cursor-pointer"
                            required>
                        <option value="">-- Pilih Tipe Kategori --</option>
                        <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>
                            Pemasukan (Income)
                        </option>
                        <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>
                            Pengeluaran (Expense)
                        </option>
                    </select>

                    @error('type')
                        <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 border-t border-border/80 flex items-center gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-accent text-page-bg hover:bg-accent/90 px-4 py-2.5 rounded-lg text-xs font-semibold transition cursor-pointer shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Kategori</span>
                    </button>

                    <a href="{{ route('categories.index') }}"
                       class="inline-flex items-center px-4 py-2.5 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>
