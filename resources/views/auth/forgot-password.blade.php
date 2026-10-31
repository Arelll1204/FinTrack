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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h1 class="text-xl font-bold text-text-primary tracking-tight">
                Forgot your password?
            </h1>
            <p class="text-xs text-text-secondary mt-1.5 leading-relaxed">
                Tidak masalah. Masukkan email yang terdaftar dan kami akan mengirimkan tautan untuk mengatur ulang password akun Anda.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-5" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <div class="relative">
                    <x-text-input id="email"
                                  type="email"
                                  name="email"
                                  :value="old('email')"
                                  required
                                  autofocus
                                  placeholder="nama@email.com"
                                  class="pl-10" />
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-text-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
            </div>

            <div class="pt-2">
                <x-primary-button>
                    <span>Kirim Link Reset Password</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </x-primary-button>
            </div>

            <!-- Back to Login Link -->
            <div class="text-center pt-3 border-t border-border/70 mt-6">
                <a href="{{ route('login') }}" class="text-xs text-text-secondary hover:text-text-primary transition inline-flex items-center gap-1.5 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Halaman Login</span>
                </a>
            </div>
        </form>

    </div>
</x-guest-layout>
