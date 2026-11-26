<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Jumlah Produk per Kategori
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-sm rounded-lg">

            <h3 class="text-lg font-semibold mb-4">
                Daftar Kategori
            </h3>
            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3">No</th>
                        <th class="border p-3">Nama Kategori</th>
                        <th class="border p-3">Deskripsi</th>
                        <th class="border p-3">Jumlah Produk</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="border p-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border p-3">
                                {{ $category->name }}
                            </td>

                            <td class="border p-3">
                                {{ $category->description ?? '-' }}
                            </td>

                            <td class="border p-3 text-center font-semibold">
                                {{ $category->products_count }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border p-4 text-center">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>