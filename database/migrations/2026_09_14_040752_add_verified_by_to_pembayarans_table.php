<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('verified_by_role')->nullable()->after('status');
            $table->string('verified_by_name')->nullable()->after('verified_by_role');
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn([
                'verified_by_role',
                'verified_by_name',
            ]);
        });
    }
};