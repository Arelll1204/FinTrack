<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Dompet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">

                <form action="{{ route('wallets.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Nama Dompet
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded"
                               placeholder="Contoh: BCA, Cash, GoPay">

                        @error('name')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-2">
                            Saldo Awal
                        </label>

                        <input type="number"
                               name="balance"
                               value="{{ old('balance', 0) }}"
                               min="0"
                               step="0.01"
                               class="w-full border-gray-300 rounded">

                        @error('balance')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded">
                            Simpan
                        </button>

                        <a href="{{ route('wallets.index') }}"
                           class="bg-gray-300 px-4 py-2 rounded">
                            Kembali
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
