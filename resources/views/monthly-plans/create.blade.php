<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Rencana Bulanan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white p-6 shadow rounded-lg">

                <form action="{{ route('monthly-plans.store') }}"
                      method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2">Nama Rencana</label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded"
                               placeholder="Contoh: Budget Makan Bulanan">

                        @error('name')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Kategori</label>

                        <select name="category_id"
                                class="w-full border-gray-300 rounded">
                            <option value="">Pilih kategori</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Nominal Rencana</label>

                        <input type="number"
                               name="amount"
                               min="0.01"
                               step="0.01"
                               value="{{ old('amount') }}"
                               class="w-full border-gray-300 rounded"
                               placeholder="Contoh: 1500000">

                        @error('amount')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Bulan</label>

                        <select name="month"
                                class="w-full border-gray-300 rounded">
                            <option value="">Pilih bulan</option>

                            @foreach(range(1, 12) as $month)
                                <option value="{{ $month }}"
                                    {{ old('month') == $month ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                </option>
                            @endforeach
                        </select>

                        @error('month')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2">Tahun</label>

                        <input type="number"
                               name="year"
                               min="2020"
                               max="2100"
                               value="{{ old('year', date('Y')) }}"
                               class="w-full border-gray-300 rounded">

                        @error('year')
                            <p class="text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded">
                            Simpan
                        </button>

                        <a href="{{ route('monthly-plans.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded">
                            Kembali
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>