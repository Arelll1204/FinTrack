<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Dompet
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Daftar Dompet</h3>

                    <a href="{{ route('wallets.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded">
                        + Tambah Dompet
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 border">No</th>
                            <th class="p-3 border">Nama Dompet</th>
                            <th class="p-3 border">Saldo</th>
                            <th class="p-3 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($wallets as $wallet)
                            <tr>
                                <td class="p-3 border">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="p-3 border">
                                    {{ $wallet->name }}
                                </td>

                                <td class="p-3 border">
                                    Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                                </td>

                                <td class="p-3 border">
                                    <a href="{{ route('wallets.show', $wallet->id) }}"
                                       class="text-blue-600">
                                        Detail
                                    </a>

                                    |

                                    <a href="{{ route('wallets.edit', $wallet->id) }}"
                                       class="text-yellow-600">
                                        Edit
                                    </a>

                                    |

                                    <form action="{{ route('wallets.destroy', $wallet->id) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus dompet ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center">
                                    Belum ada dompet.
                                    Silakan tambah dompet baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
