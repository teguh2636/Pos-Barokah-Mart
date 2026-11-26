<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Riwayat Transaksi Saya
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">
        <x-card>
            <h3 class="text-lg font-semibold mb-4">
                Daftar Transaksi
            </h3>

            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-3">No. Invoice</th>
                        <th class="border p-3">Total</th>
                        <th class="border p-3">Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td class="border p-3">
                                {{ $transaction->invoice_number }}
                            </td>
                            <td class="border p-3">
                                Rp {{ number_format($transaction->total, 0, ',', '.') }}
                            </td>
                            <td class="border p-3">
                                {{ $transaction->created_at->format('d-m-Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border p-3 text-center">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-card>
    </div>
</x-app-layout>