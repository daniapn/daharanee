<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status_pesanan')->default('Menunggu Pembayaran');
            $table->string('metode_pembayaran')->nullable();
            $table->timestamp('tanggal_konfirmasi_pembayaran')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['status_pesanan', 'metode_pembayaran', 'tanggal_konfirmasi_pembayaran', 'tanggal_selesai']);
        });
    }
};

