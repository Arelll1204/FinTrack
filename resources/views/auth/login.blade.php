<x-guest-layout>
    <div class="max-w-4xl w-full mx-auto bg-surface border border-border rounded-2xl overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-12">

        <!-- Left Column: Branding & Value Props (Visible on large screens) -->
        <div class="lg:col-span-5 bg-nav-bg/90 border-b lg:border-b-0 lg:border-r border-border p-8 lg:p-10 flex flex-col justify-between">
            <div>
                <!-- Brand Logo -->
                <a href="/" class="inline-flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-accent/15 border border-accent/30 flex items-center justify-center text-accent font-bold text-lg shadow-xs group-hover:scale-105 transition-transform">
                        FT
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="font-bold text-text-primary text-xl tracking-tight leading-none">FinTrack</span>
                        <span class="text-[10px] text-text-secondary tracking-widest uppercase font-semibold mt-1">Personal Finance</span>
                    </div>
                </a>

                <!-- Value Proposition -->
                <div class="mt-10 space-y-4">
                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-accent/10 border border-accent/25 text-accent text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent animate-pulse"></span>
                        <span>Smart Money Management</span>
                    </div>

                    <h2 class="text-2xl font-bold text-text-primary tracking-tight leading-snug">
                        Kendalikan arus kas dengan presisi dan tenang.
                    </h2>

                    <p class="text-xs text-text-secondary leading-relaxed">
                        Pantau pemasukan, pengeluaran dompet, alokasi anggaran, dan rencana bulanan dalam satu dashboard modern.
                    </p>
                </div>

                <!-- Feature Highlights -->
                <div class="mt-8 space-y-3.5">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-income/10 border border-income/25 flex items-center justify-center text-income shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-text-primary">Pelacakan Arus Kas Real-time</h4>
                            <p class="text-[11px] text-text-secondary mt-0.5">Catat transaksi lintas dompet secara akurat.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-accent/10 border border-accent/25 flex items-center justify-center text-accent shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-text-primary">Batas Anggaran Kategori</h4>
                            <p class="text-[11px] text-text-secondary mt-0.5">Cegah kebocoran dana dengan batas pemakaian.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-blue-500/10 border border-blue-500/25 flex items-center justify-center text-blue-400 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-text-primary">Perencanaan Bulanan</h4>
                            <p class="text-[11px] text-text-secondary mt-0.5">Alokasikan pos rencana sebelum bulan berjalan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Note -->
            <div class="mt-8 pt-6 border-t border-border/70 flex items-center gap-2.5 text-text-secondary text-[11px]">
                <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span>Autentikasi terenkripsi & data terisolasi secara privat.</span>
            </div>
        </div>

        <!-- Right Column: Login Form -->
        <div class="lg:col-span-7 p-8 sm:p-10 flex flex-col justify-center">

            <!-- Mobile Brand Header -->
            <div class="lg:hidden mb-6 flex justify-center">
                <a href="/" class="inline-flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-accent/15 border border-accent/30 flex items-center justify-center text-accent font-bold text-base shadow-xs">
                        FT
                    </div>
                    <span class="font-bold text-text-primary text-lg tracking-tight">FinTrack</span>
                </a>
            </div>

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-text-primary tracking-tight">
                    Welcome back to FinTrack
                </h1>
                <p class="text-xs text-text-secondary mt-1.5">
                    Masuk ke akun Anda untuk mulai mengelola keuangan dan memantau anggaran hari ini.
                </p>
            </div>

            <!-- Session Status Alert -->
            <x-auth-session-status class="mb-5" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
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
                                      autocomplete="username"
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

                <!-- Password with Toggle Show/Hide -->
                <div x-data="{ show: false }">
                    <div class="flex items-center justify-between mb-2">
                        <x-input-label for="password" :value="__('Password')" class="mb-0" />
                    </div>
                    <div class="relative">
                        <input id="password"
                               :type="show ? 'text' : 'password'"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
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

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                        <input id="remember_me"
                               type="checkbox"
                               name="remember"
                               class="rounded bg-nav-bg border-border text-accent focus:ring-accent focus:ring-offset-surface focus:ring-offset-1 w-4 h-4 cursor-pointer transition">
                        <span class="ms-2 text-xs text-text-secondary hover:text-text-primary transition">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-xs text-accent hover:underline font-medium transition">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <x-primary-button>
                        <span>Masuk ke FinTrack</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </x-primary-button>
                </div>

                <!-- Register Link -->
                <div class="text-center pt-3 text-xs text-text-secondary">
                    <span>Belum memiliki akun FinTrack?</span>
                    <a href="{{ route('register') }}" class="text-accent hover:underline font-semibold ml-1 inline-flex items-center gap-0.5">
                        <span>Daftar sekarang</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-guest-layout>
