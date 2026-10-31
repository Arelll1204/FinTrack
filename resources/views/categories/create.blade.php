
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Kategori
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white p-6 rounded-lg shadow">

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2">
                            Nama Kategori
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded-md"
                               placeholder="Contoh: Makanan">

                        @error('name')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">
                            Tipe Kategori
                        </label>

                        <select name="type"
                                class="w-full border-gray-300 rounded-md">

                            <option value="">Pilih Tipe</option>

                            <option value="income"
                                {{ old('type') == 'income' ? 'selected' : '' }}>
                                Pemasukan
                            </option>

                            <option value="expense"
                                {{ old('type') == 'expense' ? 'selected' : '' }}>
                                Pengeluaran
                            </option>

                        </select>

                        @error('type')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded">
                            Simpan
                        </button>

                        <a href="{{ route('categories.index') }}"
                           class="bg-gray-200 px-4 py-2 rounded">
                            Kembali
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
