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
        // Menggunakan Schema::table, bukan Route::table ya pak (kemarin ada salah ketik sedikit)
        Schema::table('users', function (Blueprint $table) {
            // Menambah kolom saldo dengan nilai default 500.000 rupiah tepat di bawah kolom email
            $table->decimal('balance', 12, 2)->default(500000.00)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kembali kolom saldo jika migrasi dibatalkan
            $table->dropColumn('balance');
        });
    }
};