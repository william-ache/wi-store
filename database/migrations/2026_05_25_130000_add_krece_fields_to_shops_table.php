<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->boolean('krece_enabled')->default(false)->after('cashea_link_url');
            $table->string('krece_qr_path')->nullable()->after('krece_enabled');
            $table->boolean('krece_link_enabled')->default(false)->after('krece_qr_path');
            $table->string('krece_link_url', 500)->nullable()->after('krece_link_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'krece_enabled',
                'krece_qr_path',
                'krece_link_enabled',
                'krece_link_url',
            ]);
        });
    }
};
