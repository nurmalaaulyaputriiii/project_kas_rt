<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {

            if (!Schema::hasColumn('pembayarans', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')
                    ->nullable()
                    ->after('jumlah');
            }

            if (!Schema::hasColumn('pembayarans', 'jenis_pembayaran')) {
                $table->string('jenis_pembayaran')
                    ->nullable()
                    ->after('metode_pembayaran');
            }

            if (!Schema::hasColumn('pembayarans', 'keterangan')) {
                $table->text('keterangan')
                    ->nullable()
                    ->after('jenis_pembayaran');
            }

            if (!Schema::hasColumn('pembayarans', 'status')) {
                $table->string('status')
                    ->default('Menunggu Verifikasi')
                    ->after('keterangan');
            }

        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {

            if (Schema::hasColumn('pembayarans', 'metode_pembayaran')) {
                $table->dropColumn('metode_pembayaran');
            }

            if (Schema::hasColumn('pembayarans', 'jenis_pembayaran')) {
                $table->dropColumn('jenis_pembayaran');
            }

            if (Schema::hasColumn('pembayarans', 'keterangan')) {
                $table->dropColumn('keterangan');
            }

            if (Schema::hasColumn('pembayarans', 'status')) {
                $table->dropColumn('status');
            }

        });
    }
};