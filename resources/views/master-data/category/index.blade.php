<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data Kategori
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white p-6 shadow-sm rounded-lg">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">
                    Daftar Kategori
                </h3>

                <a href="{{ route('categories.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">
                    + Tambah Kategori
                </a>
            </div>

            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3">No</th>
                        <th class="border p-3">Nama Kategori</th>
                        <th class="border p-3">Deskripsi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="border p-3">
                                {{ $categories->firstItem() + $loop->index }}
                            </td>
                            <td class="border p-3">
                                {{ $category->name }}
                            </td>
                            <td class="border p-3">
                                {{ $category->description ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border p-4 text-center">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>

        </div>
    </div>
</x-app-layout>