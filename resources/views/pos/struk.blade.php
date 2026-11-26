<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Struk Transaksi
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <x-card>

                {{-- Nama Toko --}}
                <p class="text-center font-semibold">
                    POS Barokah Mart
                </p>

                {{-- Nomor Invoice --}}
                <p class="text-center text-xs text-gray-500 mb-3">
                    {{ $transaction->invoice_number }}
                </p>

                {{-- Informasi Transaksi --}}
                <p class="text-xs text-gray-500 mb-3">
                    {{ $transaction->created_at->format('d M Y H:i') }}
                    &middot;
                    Kasir: {{ $transaction->user->name }}
                </p>

                <hr class="mb-3">

                {{-- Daftar Produk --}}
                @foreach ($transaction->details as $detail)
                    <div class="flex justify-between text-sm mb-1">
                        <span>
                            {{ $detail->product->name }}
                            x{{ $detail->qty }}
                        </span>

                        <span>
                            Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach

                <hr class="my-3">

                {{-- Total Pembayaran --}}
                <div class="flex justify-between font-semibold">
                    <span>Total</span>

                    <span>
                        Rp{{ number_format($transaction->total, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Uang Dibayarkan --}}
                <div class="flex justify-between text-sm">
                    <span>Bayar</span>

                    <span>
                        Rp{{ number_format($transaction->pay, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Uang Kembalian --}}
                <div class="flex justify-between text-sm">
                    <span>Kembali</span>

                    <span>
                        Rp{{ number_format($transaction->change, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Tombol Cetak --}}
                <button onclick="window.print()" class="no-print w-full mt-4 bg-green-600 text-white py-2 rounded-md">
                    Cetak Struk
                </button>

                {{-- Tombol Transaksi Baru --}}
                <a href="{{ route('pos.index') }}"
                    class="no-print block text-center mt-3 bg-indigo-600 text-white py-2 rounded-md">
                    Transaksi Baru
                </a>

            </x-card>
        </div>
    </div>

    {{-- CSS Khusus Cetak --}}
    <style>
        @media print {

            nav,
            header,
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .shadow-sm,
            .shadow {
                box-shadow: none !important;
            }
        }
    </style>

</x-app-layout>