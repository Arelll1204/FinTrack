
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Kategori FinTrack
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4">

            <div class="bg-white p-6 rounded-lg shadow">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">
                        Daftar Kategori
                    </h3>

                    <a href="{{ route('categories.create') }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded">
                        + Tambah Kategori
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3">No</th>
                                <th class="text-left py-3">Nama</th>
                                <th class="text-left py-3">Tipe</th>
                                <th class="text-left py-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="border-b">
                                    <td class="py-3">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="py-3">
                                        {{ $category->name }}
                                    </td>

                                    <td class="py-3">
                                        {{ ucfirst($category->type) }}
                                    </td>

                                    <td class="py-3">
                                        <div class="flex gap-2">

                                            <a href="{{ route('categories.show', $category) }}"
                                               class="text-blue-600">
                                                Detail
                                            </a>

                                            <a href="{{ route('categories.edit', $category) }}"
                                               class="text-yellow-600">
                                                Edit
                                            </a>

                                            <form action="{{ route('categories.destroy', $category) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="text-red-600">
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="py-6 text-center text-gray-500">
                                        Belum ada kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
