<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Perencanaan Bulanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold">
                                Rencana Keuangan
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Atur rencana pengeluaran bulanan kamu.
                            </p>
                        </div>
                        <a href="{{ route('monthly-plans.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                            + Tambah Rencana
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($plans->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500">
                                Belum ada rencana keuangan.
                            </p>
                            <p class="text-sm text-gray-400 mt-2">
                                Klik tombol Tambah Rencana untuk mulai membuat perencanaan bulanan.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">
                                            Nama Rencana
                                        </th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">
                                            Kategori
                                        </th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">
                                            Bulan
                                        </th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">
                                            Tahun
                                        </th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">
                                            Anggaran
                                        </th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-500">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($plans as $plan)
                                        <tr>
                                            <td class="px-4 py-3">
                                                {{ $plan->name }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $plan->category->name ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ \Carbon\Carbon::create()->month($plan->month)->translatedFormat('F') }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $plan->year }}
                                            </td>
                                            <td class="px-4 py-3">
                                                Rp {{ number_format($plan->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('monthly-plans.show', $plan->id) }}" class="text-blue-600 hover:underline">
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('monthly-plans.edit', $plan->id) }}" class="text-yellow-600 hover:underline">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('monthly-plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rencana ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:underline">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

