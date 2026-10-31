<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Kategori Transaksi
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Klasifikasikan transaksi pengeluaran dan pemasukan untuk analisis yang akurat.
                </p>
            </div>
            <a href="{{ route('categories.create') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Kategori</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">

        @if (session('success'))
            <div class="p-3.5 rounded-lg bg-income/10 border border-income/30 text-income text-xs font-medium flex items-center gap-2.5 shadow-xs">
                <svg class="w-4 h-4 shrink-0 text-income" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Quick Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-surface border border-border rounded-lg p-4 shadow-xs">
                <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Total Kategori</span>
                <p class="text-2xl font-bold text-text-primary mt-1">{{ $categories->count() }}</p>
                <p class="text-[11px] text-text-secondary mt-0.5">Seluruh pos pengelompokan</p>
            </div>
            <div class="bg-surface border border-border rounded-lg p-4 shadow-xs">
                <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Kategori Pemasukan</span>
                <p class="text-2xl font-bold text-income mt-1">{{ $categories->where('type', 'income')->count() }}</p>
                <p class="text-[11px] text-text-secondary mt-0.5">Sumber dana masuk</p>
            </div>
            <div class="bg-surface border border-border rounded-lg p-4 shadow-xs">
                <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Kategori Pengeluaran</span>
                <p class="text-2xl font-bold text-expense mt-1">{{ $categories->where('type', 'expense')->count() }}</p>
                <p class="text-[11px] text-text-secondary mt-0.5">Alokasi penggunaan dana</p>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-surface border border-border rounded-lg p-5 shadow-xs">
            <div class="flex justify-between items-center pb-4 mb-2 border-b border-border/80">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Daftar Kategori
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Kelola nama dan tipe klasifikasi transaksi.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-border text-text-secondary uppercase tracking-wider text-[11px]">
                            <th scope="col" class="py-3 px-3.5 w-16">No</th>
                            <th scope="col" class="py-3 px-3.5">Nama Kategori</th>
                            <th scope="col" class="py-3 px-3.5">Tipe</th>
                            <th scope="col" class="py-3 px-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border/60">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-surface-hover/60 transition-colors">
                                <td class="py-3 px-3.5 text-text-secondary font-mono">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="py-3 px-3.5 font-semibold text-text-primary">
                                    {{ $category->name }}
                                </td>

                                <td class="py-3 px-3.5 whitespace-nowrap">
                                    @if(strtolower($category->type) === 'income')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-income/15 text-income border border-income/30">
                                            Pemasukan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-expense/15 text-expense border border-expense/30">
                                            Pengeluaran
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('categories.show', $category) }}"
                                           class="text-accent hover:underline font-medium text-xs">
                                            Detail
                                        </a>

                                        <span class="text-border">|</span>

                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="text-blue-400 hover:underline font-medium text-xs">
                                            Edit
                                        </a>

                                        <span class="text-border">|</span>

                                        <form action="{{ route('categories.destroy', $category) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-expense hover:underline font-medium text-xs cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-text-secondary text-xs">
                                    Belum ada kategori. Silakan klik tombol <strong>+ Tambah Kategori</strong> di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
