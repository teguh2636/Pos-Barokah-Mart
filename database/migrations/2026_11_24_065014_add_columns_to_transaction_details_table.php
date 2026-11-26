<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 
public function up(): void
{
    Schema::table('transaction_details', function (Blueprint $table) {
        $table->foreignId('transaction_id')
            ->constrained('transactions')
            ->cascadeOnDelete();

        $table->foreignId('product_id')
            ->constrained('products')
            ->cascadeOnDelete();

        $table->unsignedInteger('qty');
        $table->unsignedBigInteger('price');
        $table->unsignedBigInteger('subtotal');
    });
}

public function down(): void
{
    Schema::table('transaction_details', function (Blueprint $table) {
        $table->dropForeign(['transaction_id']);
        $table->dropForeign(['product_id']);

        $table->dropColumn([
            'transaction_id',
            'product_id',
            'qty',
            'price',
            'subtotal',
        ]);
    });
}

};
