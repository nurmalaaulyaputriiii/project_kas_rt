<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('warga_id');

            $table->unsignedBigInteger('kas_bulanan_id');

            $table->date('tanggal_bayar');

            $table->decimal('jumlah', 12, 2);

            $table->string('status')->default('Lunas');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->foreign('warga_id')
                ->references('id')
                ->on('warga')
                ->onDelete('cascade');

            $table->foreign('kas_bulanan_id')
                ->references('id')
                ->on('kas_bulanans')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};