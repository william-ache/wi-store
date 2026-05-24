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
            $table->boolean('stripe_enabled')->default(false)->after('payment_methods');
            $table->text('stripe_publishable_key')->nullable()->after('stripe_enabled');
            $table->text('stripe_secret_key')->nullable()->after('stripe_publishable_key');
            
            $table->boolean('binance_enabled')->default(false)->after('stripe_secret_key');
            $table->text('binance_api_key')->nullable()->after('binance_enabled');
            $table->text('binance_secret_key')->nullable()->after('binance_api_key');
            
            $table->boolean('pagomovil_enabled')->default(false)->after('binance_secret_key');
            $table->string('pagomovil_bank')->nullable()->after('pagomovil_enabled');
            $table->string('pagomovil_phone')->nullable()->after('pagomovil_bank');
            $table->string('pagomovil_id')->nullable()->after('pagomovil_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_enabled',
                'stripe_publishable_key',
                'stripe_secret_key',
                'binance_enabled',
                'binance_api_key',
                'binance_secret_key',
                'pagomovil_enabled',
                'pagomovil_bank',
                'pagomovil_phone',
                'pagomovil_id',
            ]);
        });
    }
};
