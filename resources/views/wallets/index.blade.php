<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-text-primary tracking-tight">
                    Dompet & Rekening
                </h1>
                <p class="text-xs text-text-secondary mt-0.5">
                    Kelola saldo kas tunai, rekening perbankan, dan e-wallet kamu.
                </p>
            </div>
            <a href="{{ route('wallets.create') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-accent text-page-bg hover:bg-accent/90 transition shadow-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Dompet</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">

        @if(session('success'))
            <div class="p-3.5 rounded-lg bg-income/10 border border-income/30 text-income text-xs font-medium flex items-center gap-2.5 shadow-xs">
                <svg class="w-4 h-4 shrink-0 text-income" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Total Saldo Banner -->
        <div class="bg-surface border border-border rounded-lg p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-medium text-text-secondary uppercase tracking-wider">Total Akumulasi Saldo</span>
                <p class="text-3xl font-extrabold text-accent tracking-tight mt-1">
                    Rp {{ number_format($wallets->sum('balance'), 0, ',', '.') }}
                </p>
            </div>
            <div class="text-xs text-text-secondary">
                Terdistribusi pada <strong class="text-text-primary font-semibold">{{ $wallets->count() }}</strong> akun dompet aktif.
            </div>
        </div>

        <!-- Wallet Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($wallets as $wallet)
                @php
                    $lowerName = strtolower($wallet->name);
                    $isBank = str_contains($lowerName, 'bca') || str_contains($lowerName, 'mandiri') || str_contains($lowerName, 'bni') || str_contains($lowerName, 'bri') || str_contains($lowerName, 'bank') || str_contains($lowerName, 'jago');
                    $isEwallet = str_contains($lowerName, 'gopay') || str_contains($lowerName, 'ovo') || str_contains($lowerName, 'dana') || str_contains($lowerName, 'shopee') || str_contains($lowerName, 'wallet') || str_contains($lowerName, 'linkaja');
                @endphp
                <div class="bg-surface border border-border rounded-lg p-5 shadow-xs transition hover:border-accent/40 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg {{ $isBank ? 'bg-blue-500/15 border-blue-500/30 text-blue-400' : ($isEwallet ? 'bg-purple-500/15 border-purple-500/30 text-purple-400' : 'bg-accent/15 border-accent/30 text-accent') }} border flex items-center justify-center shrink-0">
                                    @if($isBank)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    @elseif($isEwallet)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-text-primary">
                                        {{ $wallet->name }}
                                    </h3>
                                    <span class="text-[10px] text-text-secondary uppercase tracking-wider font-medium">
                                        {{ $isBank ? 'Rekening Bank' : ($isEwallet ? 'E-Wallet' : 'Kas Tunai') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-border/60">
                            <span class="text-[11px] text-text-secondary">Saldo Tersedia</span>
                            <p class="text-xl font-extrabold text-accent tracking-tight mt-0.5">
                                Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-border/80 flex items-center justify-between text-xs">
                        <a href="{{ route('wallets.show', $wallet->id) }}"
                           class="text-accent hover:underline font-medium">
                            Detail
                        </a>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('wallets.edit', $wallet->id) }}"
                               class="text-blue-400 hover:underline font-medium">
                                Edit
                            </a>
                            <span class="text-border">|</span>
                            <form action="{{ route('wallets.destroy', $wallet->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus dompet {{ $wallet->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-expense hover:underline font-medium cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-surface border border-border rounded-lg p-10 text-center text-text-secondary text-xs">
                    Belum ada dompet tercatat. Silakan klik tombol <strong>+ Tambah Dompet</strong> untuk memulai.
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
