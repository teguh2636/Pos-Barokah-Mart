<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Http\Requests\StorePosRequest;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    // Menampilkan halaman kasir
    public function index()
    {
        $products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get([
                'id',
                'code',
                'name',
                'price',
                'stock',
                'unit'
            ]);

        return view('pos.index', compact('products'));
    }

    // Menyimpan transaksi penjualan
    public function store(StorePosRequest $request)
    {
        try {
            $transaction = DB::transaction(function () use ($request) {
                $total = 0;
                $details = [];

                foreach ($request->items as $item) {
                    // Mengunci data produk selama transaksi
                    $product = Product::lockForUpdate()
                        ->findOrFail($item['product_id']);

                    // Memeriksa ketersediaan stok
                    if ($product->stock < $item['qty']) {
                        throw new \Exception(
                            "Stok {$product->name} tidak mencukupi."
                        );
                    }

                    // Menghitung subtotal
                    $subtotal = $product->price * $item['qty'];
                    $total += $subtotal;

                    // Menyiapkan detail transaksi
                    $details[] = [
                        'product_id' => $product->id,
                        'qty' => $item['qty'],
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ];

                    // Mengurangi stok produk
                    $product->decrement('stock', $item['qty']);
                }

                // Memeriksa pembayaran
                if ($request->pay < $total) {
                    throw new \Exception(
                        'Nominal bayar kurang dari total belanja.'
                    );
                }

                // Membuat nomor invoice
                $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' .
                    str_pad(
                        Transaction::whereDate('created_at', now())->count() + 1,
                        4,
                        '0',
                        STR_PAD_LEFT
                    );

                // Menyimpan transaksi utama
                $trx = Transaction::create([
                    'invoice_number' => $invoiceNumber,
                    'user_id' => auth()->id(),
                    'total' => $total,
                    'pay' => $request->pay,
                    'change' => $request->pay - $total,
                ]);

                // Menyimpan detail transaksi
                $trx->details()->createMany($details);

                return $trx;
            });

            // Mengarahkan ke halaman struk
            return redirect()
                ->route('pos.struk', $transaction)
                ->with('success', 'Transaksi berhasil disimpan.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // Menampilkan struk transaksi
    public function struk(Transaction $transaction)
    {
        $transaction->load('details.product', 'user');

        return view('pos.struk', compact('transaction'));
    }

    // Menampilkan riwayat transaksi pengguna
    public function myTransactions()
    {
        $transactions = Transaction::where(
            'user_id',
            auth()->id()
        )->latest()->get();

        return view('pos.my-transactions', compact('transactions'));
    }
}
