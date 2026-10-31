<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Perencanaan Bulanan
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Proyeksikan target dan alokasi rencana dana belanja sebelum bulan dimulai.
                </p>
            </div>
            <a href="{{ route('monthly-plans.create') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Rencana</span>
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

        <!-- Quick Summary Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-surface border border-border rounded-lg p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Total Rencana Dana</span>
                    <p class="text-3xl font-extrabold text-accent tracking-tight mt-1">
                        Rp {{ number_format($plans->sum('amount'), 0, ',', '.') }}
                    </p>
                    <p class="text-[11px] text-text-secondary mt-0.5">Akumulasi seluruh pos rencana aktif</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-accent/15 border border-accent/30 text-accent flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <div class="bg-surface border border-border rounded-lg p-5 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Jumlah Pos Terencana</span>
                    <p class="text-3xl font-extrabold text-text-primary tracking-tight mt-1">
                        {{ $plans->count() }} <span class="text-base font-normal text-text-secondary">Pos</span>
                    </p>
                    <p class="text-[11px] text-text-secondary mt-0.5">Pos perencanaan keuangan tercatat</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-500/15 border border-blue-500/30 text-blue-400 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-surface border border-border rounded-lg p-5 shadow-xs">
            <div class="flex justify-between items-center pb-4 mb-2 border-b border-border/80">
                <div>
                    <h2 class="text-base font-semibold text-text-primary tracking-tight">
                        Daftar Perencanaan Bulanan
                    </h2>
                    <p class="text-xs text-text-secondary mt-0.5">
                        Alokasi pos dana terencana untuk setiap bulan.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-border text-text-secondary uppercase tracking-wider text-[11px]">
                            <th scope="col" class="py-3 px-3">Nama Rencana</th>
                            <th scope="col" class="py-3 px-3">Kategori</th>
                            <th scope="col" class="py-3 px-3">Periode</th>
                            <th scope="col" class="py-3 px-3 text-right">Nominal Rencana</th>
                            <th scope="col" class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-border/60">
                        @forelse ($plans as $plan)
                            <tr class="hover:bg-surface-hover/60 transition-colors">
                                <td class="py-3 px-3 font-semibold text-text-primary">
                                    {{ $plan->name }}
                                </td>

                                <td class="py-3 px-3 text-text-secondary">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-nav-bg border border-border text-text-primary">
                                        {{ $plan->category->name ?? '-' }}
                                    </span>
                                </td>

                                <td class="py-3 px-3 text-text-secondary whitespace-nowrap">
                                    {{ \Carbon\Carbon::create()->month($plan->month)->translatedFormat('F') }} {{ $plan->year }}
                                </td>

                                <td class="py-3 px-3 text-right font-bold text-accent whitespace-nowrap">
                                    Rp {{ number_format($plan->amount, 0, ',', '.') }}
                                </td>

                                <td class="py-3 px-3 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('monthly-plans.show', $plan->id) }}"
                                           class="text-accent hover:underline font-medium text-xs">
                                            Detail
                                        </a>

                                        <span class="text-border">|</span>

                                        <a href="{{ route('monthly-plans.edit', $plan->id) }}"
                                           class="text-blue-400 hover:underline font-medium text-xs">
                                            Edit
                                        </a>

                                        <span class="text-border">|</span>

                                        <form action="{{ route('monthly-plans.destroy', $plan->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Apakah kamu yakin ingin menghapus rencana {{ $plan->name }}?')">
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
                                <td colspan="5" class="py-10 text-center text-text-secondary text-xs">
                                    Belum ada rencana keuangan. Silakan klik tombol <strong>+ Tambah Rencana</strong> di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
