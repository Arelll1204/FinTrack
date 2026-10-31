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
                        <span>Free & Secure Registration</span>
                    </div>

                    <h2 class="text-2xl font-bold text-text-primary tracking-tight leading-snug">
                        Mulai langkah cerdas mengelola keuangan Anda.
                    </h2>

                    <p class="text-xs text-text-secondary leading-relaxed">
                        Bangun kebiasaan finansial yang sehat dengan mencatat setiap pemasukan dan menjaga pengeluaran dalam batas anggaran.
                    </p>
                </div>

                <!-- Feature Highlights -->
                <div class="mt-8 space-y-3.5">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-accent/10 border border-accent/25 flex items-center justify-center text-accent shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-text-primary">Multi Dompet & Rekening</h4>
                            <p class="text-[11px] text-text-secondary mt-0.5">Kelola kas tunai, rekening bank, dan e-wallet dalam satu tempat.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-income/10 border border-income/25 flex items-center justify-center text-income shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-text-primary">Visualisasi Grafik Interaktif</h4>
                            <p class="text-[11px] text-text-secondary mt-0.5">Lihat tren arus kas bulanan secara intuitif dan transparan.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-blue-500/10 border border-blue-500/25 flex items-center justify-center text-blue-400 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-text-primary">Ekspor Laporan Fleksibel</h4>
                            <p class="text-[11px] text-text-secondary mt-0.5">Unduh riwayat transaksi dan ringkasan bulanan dalam file Excel & PDF.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Note -->
            <div class="mt-8 pt-6 border-t border-border/70 flex items-center gap-2.5 text-text-secondary text-[11px]">
                <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Privasi Anda adalah prioritas. Kami tidak membagikan data Anda.</span>
            </div>
        </div>

        <!-- Right Column: Registration Form -->
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

            <div class="mb-5">
                <h1 class="text-2xl font-bold text-text-primary tracking-tight">
                    Create your FinTrack account
                </h1>
                <p class="text-xs text-text-secondary mt-1">
                    Isi formulir di bawah ini untuk memulai pencatatan keuangan pribadi Anda.
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />
                    <div class="relative">
                        <x-text-input id="name"
                                      type="text"
                                      name="name"
                                      :value="old('name')"
                                      required
                                      autofocus
                                      autocomplete="name"
                                      placeholder="Nama lengkap Anda"
                                      class="pl-10" />
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-text-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <div class="relative">
                        <x-text-input id="email"
                                      type="email"
                                      name="email"
                                      :value="old('email')"
                                      required
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
                    <x-input-label for="password" :value="__('Password')" />
                    <div class="relative">
                        <input id="password"
                               :type="show ? 'text' : 'password'"
                               name="password"
                               required
                               autocomplete="new-password"
                               placeholder="Minimal 8 karakter"
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

                <!-- Confirm Password with Toggle Show/Hide -->
                <div x-data="{ show: false }">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <div class="relative">
                        <input id="password_confirmation"
                               :type="show ? 'text' : 'password'"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               placeholder="Ulangi password"
                               class="w-full bg-nav-bg border border-border text-text-primary placeholder:text-text-secondary/40 focus:border-accent focus:ring-1 focus:ring-accent rounded-lg text-sm pl-10 pr-10 py-2.5 transition shadow-xs" />
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-text-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <button type="button"
                                @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-text-secondary hover:text-text-primary focus:outline-none transition"
                                aria-label="Toggle confirm password visibility">
                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
                </div>

                <!-- Submit Button -->
                <div class="pt-3">
                    <x-primary-button>
                        <span>Buat Akun FinTrack</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </x-primary-button>
                </div>

                <!-- Back to Login Link -->
                <div class="text-center pt-2 text-xs text-text-secondary">
                    <span>Sudah memiliki akun FinTrack?</span>
                    <a href="{{ route('login') }}" class="text-accent hover:underline font-semibold ml-1 inline-flex items-center gap-0.5">
                        <span>Masuk di sini</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-guest-layout>
