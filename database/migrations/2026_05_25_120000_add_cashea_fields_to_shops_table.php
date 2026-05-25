<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->boolean('cashea_enabled')->default(false)->after('pagomovil_id');
            $table->string('cashea_qr_path')->nullable()->after('cashea_enabled');
            $table->boolean('cashea_link_enabled')->default(false)->after('cashea_qr_path');
            $table->string('cashea_link_url', 500)->nullable()->after('cashea_link_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'cashea_enabled',
                'cashea_qr_path',
                'cashea_link_enabled',
                'cashea_link_url',
            ]);
        });
    }
};
