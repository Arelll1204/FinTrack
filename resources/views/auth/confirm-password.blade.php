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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h1 class="text-xl font-bold text-text-primary tracking-tight">
                Confirm your password
            </h1>
            <p class="text-xs text-text-secondary mt-1.5 leading-relaxed">
                Ini adalah area dengan keamanan tingkat tinggi. Silakan konfirmasi password akun FinTrack Anda sebelum melanjutkan.
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <!-- Password with Show/Hide Toggle -->
            <div x-data="{ show: false }">
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative">
                    <input id="password"
                           :type="show ? 'text' : 'password'"
                           name="password"
                           required
                           autofocus
                           autocomplete="current-password"
                           placeholder="Masukkan password Anda"
                           class="w-full bg-nav-bg border border-border text-text-primary placeholder:text-text-secondary/40 focus:border-accent focus:ring-1 focus:ring-accent rounded-lg text-sm pl-10 pr-10 py-2.5 transition shadow-xs" />
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-text-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <button type="button"
                            @click="show = !show"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-text-secondary hover:text-text-primary focus:outline-none transition"
                            aria-label="Toggle password visibility">
                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>

            <div class="pt-2">
                <x-primary-button>
                    <span>Konfirmasi Password</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-primary-button>
            </div>
        </form>

    </div>
</x-guest-layout>
