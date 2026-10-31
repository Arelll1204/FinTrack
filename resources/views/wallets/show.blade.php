<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Detail Dompet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">

                <h3 class="text-lg font-bold mb-4">
                    Informasi Dompet
                </h3>

                <div class="mb-4">
                    <p class="text-gray-500">Nama Dompet</p>
                    <p class="font-semibold">{{ $wallet->name }}</p>
                </div>

                <div class="mb-6">
                    <p class="text-gray-500">Saldo</p>

                    <p class="text-2xl font-bold text-green-600">
                        Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('wallets.edit', $wallet->id) }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded">
                        Edit
                    </a>

                    <a href="{{ route('wallets.index') }}"
                       class="bg-gray-300 px-4 py-2 rounded">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
