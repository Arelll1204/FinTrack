<x-guest-layout>
    <div class="max-w-md w-full mx-auto bg-surface border border-border rounded-2xl p-8 sm:p-10 shadow-2xl">

        <!-- Logo FinTrack -->
        <div class="flex justify-center mb-6">
            <a href="/" class="inline-flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-accent/15 border border-accent/30 flex items-center justify-center text-accent font-bold text-lg shadow-xs group-hover:scale-105 transition-transform">
                    FT
                </div>
                <div class="flex flex-col text-left">
                    <span class="font-bold text-text-primary text-xl tracking-tight leading-none">FinTrack</span>
                    <span class="text-[10px] text-text-secondary tracking-widest uppercase font-semibold mt-1">Personal Finance</span>
                </div>
            </a>
        </div>

        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-accent/10 border border-accent/25 text-accent mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h1 class="text-xl font-bold text-text-primary tracking-tight">
                Verify your email
            </h1>
            <p class="text-xs text-text-secondary mt-1.5 leading-relaxed">
                Terima kasih telah bergabung dengan FinTrack! Sebelum mulai mencatat keuangan, silakan verifikasi alamat email Anda melalui tautan yang baru saja kami kirimkan.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-5 p-3.5 rounded-lg bg-income/10 border border-income/30 text-income text-xs font-medium flex items-center gap-2.5 shadow-xs">
                <svg class="w-4 h-4 shrink-0 text-income" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Tautan verifikasi baru telah berhasil dikirimkan ke alamat email Anda.</span>
            </div>
        @endif

        <div class="space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>
                    <span>Kirim Ulang Email Verifikasi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center pt-2 border-t border-border/70">
                @csrf
                <button type="submit" class="text-xs text-text-secondary hover:text-expense transition inline-flex items-center gap-1.5 font-medium cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar dari Akun (Log Out)</span>
                </button>
            </form>
        </div>

    </div>
</x-guest-layout>
