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
    Schema::table('transactions', function (Blueprint $table) {
        $table->string('invoice_number')->unique();
        $table->foreignId('user_id')
            ->after('id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->unsignedBigInteger('total');
        $table->unsignedBigInteger('pay');
        $table->unsignedBigInteger('change');
    });
}

public function down(): void
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropUnique(['invoice_number']);
        $table->dropColumn([
            'invoice_number',
            'user_id',
            'total',
            'pay',
            'change',
        ]);
    });
}

};
