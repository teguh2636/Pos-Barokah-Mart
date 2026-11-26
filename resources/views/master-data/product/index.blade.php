<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data Produk
        </h2>
    </x-slot>

    @php
        $batasStok = config('toko.batas_stok_menipis', 10);
    @endphp

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-sm rounded-lg">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">Daftar Produk</h3>

                <a href="{{ route('products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">
                    + Tambah Produk
                </a>
            </div>

            {{-- Form Pencarian dan Filter --}}
            <form method="GET" action="{{ route('products.index') }}" class="flex gap-3 mb-4">

                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau kode produk..." class="flex-1 rounded-md border-gray-300 shadow-sm">

                <select name="category_id" class="rounded-md border-gray-300">
                    <option value="">Semua Kategori</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="stock_status" class="rounded-md border-gray-300">
                    <option value="">Semua Stok</option>

                    <option value="menipis" @selected(request('stock_status') == 'menipis')>
                        Menipis
                    </option>

                    <option value="habis" @selected(request('stock_status') == 'habis')>
                        Habis
                    </option>
                </select>

                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">
                    Cari
                </button>

                <a href="{{ route('products.index') }}" class="px-4 py-2 text-gray-500">
                    Reset
                </a>
            </form>

            {{-- Tabel Produk --}}
            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3">No</th>
                        <th class="border p-3">Kode</th>
                        <th class="border p-3">Nama Produk</th>
                        <th class="border p-3">Kategori</th>
                        <th class="border p-3">Harga</th>
                        <th class="border p-3">Stok</th>
                        <th class="border p-3">Nilai Persediaan</th>
                        <th class="border p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                                        <tr class="
                                                @if ($product->stock == 0)
                                                    bg-red-50
                                                @elseif ($product->stock <= $batasStok)
                                                    bg-yellow-50
                                                @endif
                                            ">
                                            <td class="border p-3">
                                                {{ $products->firstItem() + $loop->index }}
                                            </td>

                                            <td class="border p-3">
                                                {{ $product->code }}
                                            </td>

                                            <td class="border p-3">
                                                {{ $product->name }}
                                            </td>

                                            <td class="border p-3">
                                                {{ $product->category->name }}
                                            </td>

                                            <td class="border p-3">
                                                {{ $product->harga_rupiah }}
                                            </td>

                                            <td class="border p-3 text-center">
                                                {{ $product->stock }}

                                                @if ($product->stock == 0)
                                                    <span class="text-red-600 text-xs block">
                                                        Habis
                                                    </span>
                                                @elseif ($product->stock <= $batasStok)
                                                    <span class="text-yellow-600 text-xs block">
                                                        Menipis
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="border p-3 text-right">
                                                Rp{{ number_format(
                            $product->price * $product->stock,
                            0,
                            ',',
                            '.'
                        ) }}
                                            </td>

                                            {{-- Tombol Aksi --}}
                                            <td class="border p-3 text-center">
                                                <div class="flex justify-center gap-3">

                                                    <a href="{{ route('products.show', $product) }}" class="text-gray-600 font-semibold">
                                                        Detail
                                                    </a>

                                                    <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 font-semibold">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="text-red-600 font-semibold">
                                                            Hapus
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border p-4 text-center">
                                Belum ada produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>