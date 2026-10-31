<!-- Mobile Backdrop Overlay -->
<div x-show="sidebarOpen"
     x-transition:enter="transition-opacity ease-linear duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/70 backdrop-blur-xs z-40 md:hidden"
     style="display: none;"></div>

<!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
       class="fixed md:sticky top-0 inset-y-0 left-0 z-50 w-64 bg-nav-bg border-r border-border flex flex-col justify-between transition-transform duration-200 ease-in-out md:h-screen shrink-0">

    <div>
        <!-- Brand / Header -->
        <div class="h-16 px-6 flex items-center justify-between border-b border-border/80">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-lg bg-accent/15 border border-accent/30 flex items-center justify-center text-accent font-bold text-lg group-hover:scale-105 transition-transform">
                    FT
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-text-primary text-lg tracking-tight leading-tight">FinTrack</span>
                    <span class="text-[11px] text-text-secondary tracking-wider uppercase font-medium">Personal Finance</span>
                </div>
            </a>

            <!-- Close button for mobile -->
            <button @click="sidebarOpen = false"
                    type="button"
                    class="md:hidden text-text-secondary hover:text-text-primary p-1.5 rounded-lg hover:bg-surface transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="p-4 space-y-1.5 overflow-y-auto">
            <div class="px-3 pb-2 text-[11px] font-semibold tracking-wider text-text-secondary/70 uppercase">
                Menu Utama
            </div>

            <!-- Dashboard -->
            @php $isDashboard = request()->routeIs('dashboard'); @endphp
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isDashboard ? 'bg-accent/10 text-accent border-l-2 border-accent font-semibold shadow-xs' : 'text-text-secondary hover:text-text-primary hover:bg-surface/70' }}">
                <svg class="w-5 h-5 shrink-0 {{ $isDashboard ? 'text-accent' : 'text-text-secondary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Kategori -->
            @php $isCategories = request()->routeIs('categories.*'); @endphp
            <a href="{{ route('categories.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isCategories ? 'bg-accent/10 text-accent border-l-2 border-accent font-semibold shadow-xs' : 'text-text-secondary hover:text-text-primary hover:bg-surface/70' }}">
                <svg class="w-5 h-5 shrink-0 {{ $isCategories ? 'text-accent' : 'text-text-secondary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span>Kategori</span>
            </a>

            <!-- Dompet -->
            @php $isWallets = request()->routeIs('wallets.*'); @endphp
            <a href="{{ route('wallets.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isWallets ? 'bg-accent/10 text-accent border-l-2 border-accent font-semibold shadow-xs' : 'text-text-secondary hover:text-text-primary hover:bg-surface/70' }}">
                <svg class="w-5 h-5 shrink-0 {{ $isWallets ? 'text-accent' : 'text-text-secondary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span>Dompet</span>
            </a>

            <!-- Transaksi -->
            @php $isTransactions = request()->routeIs('transactions.*'); @endphp
            <a href="{{ route('transactions.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isTransactions ? 'bg-accent/10 text-accent border-l-2 border-accent font-semibold shadow-xs' : 'text-text-secondary hover:text-text-primary hover:bg-surface/70' }}">
                <svg class="w-5 h-5 shrink-0 {{ $isTransactions ? 'text-accent' : 'text-text-secondary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                <span>Transaksi</span>
            </a>

            <!-- Anggaran -->
            @php $isBudgets = request()->routeIs('budgets.*'); @endphp
            <a href="{{ route('budgets.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isBudgets ? 'bg-accent/10 text-accent border-l-2 border-accent font-semibold shadow-xs' : 'text-text-secondary hover:text-text-primary hover:bg-surface/70' }}">
                <svg class="w-5 h-5 shrink-0 {{ $isBudgets ? 'text-accent' : 'text-text-secondary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Anggaran</span>
            </a>

            <!-- Laporan -->
            @php $isReports = request()->routeIs('reports.*'); @endphp
            <a href="{{ route('reports.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isReports ? 'bg-accent/10 text-accent border-l-2 border-accent font-semibold shadow-xs' : 'text-text-secondary hover:text-text-primary hover:bg-surface/70' }}">
                <svg class="w-5 h-5 shrink-0 {{ $isReports ? 'text-accent' : 'text-text-secondary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Laporan</span>
            </a>

            <!-- Perencanaan Bulanan -->
            @php $isMonthlyPlans = request()->routeIs('monthly-plans.*'); @endphp
            <a href="{{ route('monthly-plans.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isMonthlyPlans ? 'bg-accent/10 text-accent border-l-2 border-accent font-semibold shadow-xs' : 'text-text-secondary hover:text-text-primary hover:bg-surface/70' }}">
                <svg class="w-5 h-5 shrink-0 {{ $isMonthlyPlans ? 'text-accent' : 'text-text-secondary' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Perencanaan Bulanan</span>
            </a>
        </nav>
    </div>

    <!-- Bottom User Section -->
    <div class="p-4 border-t border-border/80">
        <div class="flex items-center justify-between p-2 rounded-lg bg-surface/50 border border-border">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-accent/20 border border-accent/40 text-accent font-semibold text-xs flex items-center justify-center shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-text-primary truncate">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-[11px] text-text-secondary truncate">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-1 shrink-0">
                <!-- Profile Link -->
                <a href="{{ route('profile.edit') }}"
                   title="Profil Akun"
                   class="p-1.5 text-text-secondary hover:text-text-primary hover:bg-surface rounded-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </a>

                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            title="Keluar"
                            class="p-1.5 text-text-secondary hover:text-expense hover:bg-expense/10 rounded-md transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
