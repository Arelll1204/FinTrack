<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Detail Rencana Bulanan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white p-6 shadow rounded-lg">

                <h3 class="text-lg font-semibold mb-6">
                    {{ $monthlyPlan->name }}
                </h3>

                <div class="space-y-4">

                    <div>
                        <p class="text-gray-500">Kategori</p>
                        <p>{{ $monthlyPlan->category->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Nominal Rencana</p>
                        <p class="font-semibold">
                            Rp {{ number_format($monthlyPlan->amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Bulan</p>
                        <p>
                            {{ DateTime::createFromFormat('!m', $monthlyPlan->month)->format('F') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Tahun</p>
                        <p>{{ $monthlyPlan->year }}</p>
                    </div>

                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('monthly-plans.edit', $monthlyPlan) }}"
                       class="px-4 py-2 bg-indigo-600 text-white rounded">
                        Edit
                    </a>

                    <a href="{{ route('monthly-plans.index') }}"
                       class="px-4 py-2 bg-gray-200 rounded">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>