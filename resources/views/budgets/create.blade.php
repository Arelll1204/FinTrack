<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Tambah Anggaran
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Tentukan batas maksimal pengeluaran bulanan per kategori.
                </p>
            </div>
            <a href="{{ route('budgets.index') }}"
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
                    Formulir Anggaran Kategori
                </h2>
                <p class="text-xs text-text-secondary mt-0.5">
                    Pilih kategori pengeluaran serta tentukan batas nominal untuk periode terkait.
                </p>
            </div>

            <form action="{{ route('budgets.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Kategori Pengeluaran -->
                <div>
                    <label for="category_id" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Kategori Pengeluaran <span class="text-expense">*</span>
                    </label>

                    <select id="category_id"
                            name="category_id"
                            class="w-full bg-nav-bg border border-border text-text-primary rounded-lg text-sm px-3.5 py-2.5 focus:border-accent focus:ring-1 focus:ring-accent transition cursor-pointer"
                            required>
                        <option value="">-- Pilih Kategori Pengeluaran --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nominal Anggaran -->
                <div>
                    <label for="amount" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                        Batas Anggaran (Rp) <span class="text-expense">*</span>
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
                               placeholder="500000"
                               class="w-full bg-nav-bg border border-border text-text-primary placeholder:text-text-secondary/40 focus:border-accent focus:ring-1 focus:ring-accent rounded-lg text-sm pl-10 pr-3.5 py-2.5 transition"
                               required>
                    </div>

                    @error('amount')
                        <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bulan & Tahun -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="month" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                            Bulan <span class="text-expense">*</span>
                        </label>

                        <select id="month"
                                name="month"
                                class="w-full bg-nav-bg border border-border text-text-primary rounded-lg text-sm px-3.5 py-2.5 focus:border-accent focus:ring-1 focus:ring-accent transition cursor-pointer"
                                required>
                            @foreach ($monthNames as $num => $name)
                                <option value="{{ $num }}" {{ old('month', $currentMonth) == $num ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>

                        @error('month')
                            <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="year" class="block font-semibold text-xs text-text-secondary uppercase tracking-wider mb-1.5">
                            Tahun <span class="text-expense">*</span>
                        </label>

                        <input type="number"
                               id="year"
                               name="year"
                               value="{{ old('year', $currentYear) }}"
                               min="2020"
                               max="2100"
                               class="w-full bg-nav-bg border border-border text-text-primary rounded-lg text-sm px-3.5 py-2.5 focus:border-accent focus:ring-1 focus:ring-accent transition"
                               required>

                        @error('year')
                            <p class="text-expense text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 border-t border-border/80 flex items-center gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-accent text-page-bg hover:bg-accent/90 px-4 py-2.5 rounded-lg text-xs font-semibold transition cursor-pointer shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Anggaran</span>
                    </button>

                    <a href="{{ route('budgets.index') }}"
                       class="inline-flex items-center px-4 py-2.5 rounded-lg text-xs font-semibold bg-surface border border-border text-text-secondary hover:text-text-primary hover:bg-surface-hover transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>
