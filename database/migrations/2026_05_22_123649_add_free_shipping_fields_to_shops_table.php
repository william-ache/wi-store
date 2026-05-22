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
            $table->boolean('enable_free_shipping')->default(false)->after('has_delivery');
            $table->decimal('free_shipping_min_amount', 8, 2)->default(0.00)->after('enable_free_shipping');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['enable_free_shipping', 'free_shipping_min_amount']);
        });
    }
};
