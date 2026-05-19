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
        Schema::table('shops', function (Blueprint $table) {
            $table->decimal('delivery_rate_per_km', 8, 2)->default(0)->after('exchange_updated_at');
            $table->string('latitude')->nullable()->after('delivery_rate_per_km');
            $table->string('longitude')->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['delivery_rate_per_km', 'latitude', 'longitude']);
        });
    }
};
