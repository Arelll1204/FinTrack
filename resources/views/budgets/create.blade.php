<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Anggaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">

                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold text-gray-800">
                        Form Tambah Anggaran
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Tentukan batas maksimal pengeluaran bulanan untuk kategori pilihan kamu.
                    </p>
                </div>

                <form action="{{ route('budgets.store') }}" method="POST">
                    @csrf

                    <!-- Kategori Pengeluaran -->
                    <div class="mb-4">
                        <label for="category_id" class="block font-medium text-gray-700 mb-2">
                            Kategori Pengeluaran <span class="text-red-500">*</span>
                        </label>

                        <select id="category_id"
                                name="category_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                            <option value="">-- Pilih Kategori Pengeluaran --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nominal Anggaran -->
                    <div class="mb-4">
                        <label for="amount" class="block font-medium text-gray-700 mb-2">
                            Batas Anggaran (Rp) <span class="text-red-500">*</span>
                        </label>

                        <input type="number"
                               id="amount"
                               name="amount"
                               value="{{ old('amount') }}"
                               min="0.01"
                               step="0.01"
                               placeholder="Contoh: 500000"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               required>

                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bulan & Tahun -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="month" class="block font-medium text-gray-700 mb-2">
                                Bulan <span class="text-red-500">*</span>
                            </label>

                            <select id="month"
                                    name="month"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                @foreach ($monthNames as $num => $name)
                                    <option value="{{ $num }}" {{ old('month', $currentMonth) == $num ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('month')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="year" class="block font-medium text-gray-700 mb-2">
                                Tahun <span class="text-red-500">*</span>
                            </label>

                            <input type="number"
                                   id="year"
                                   name="year"
                                   value="{{ old('year', $currentYear) }}"
                                   min="2020"
                                   max="2100"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   required>

                            @error('year')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center gap-3">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-lg shadow transition">
                            Simpan Anggaran
                        </button>

                        <a href="{{ route('budgets.index') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-lg transition">
                            Batal
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>

