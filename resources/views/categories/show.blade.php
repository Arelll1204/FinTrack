
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Detail Kategori
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white p-6 rounded-lg shadow">

                <div class="mb-4">
                    <p class="text-gray-500">Nama Kategori</p>
                    <p class="text-lg font-semibold">
                        {{ $category->name }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-gray-500">Tipe</p>
                    <p class="text-lg font-semibold">
                        {{ ucfirst($category->type) }}
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-gray-500">Dibuat</p>
                    <p>
                        {{ $category->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('categories.edit', $category) }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded">
                        Edit
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="bg-gray-200 px-4 py-2 rounded">
                        Kembali
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
