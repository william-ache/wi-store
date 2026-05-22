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
            $table->date('plan_expires_at')->nullable()->after('plan');
            $table->date('last_payment_date')->nullable()->after('plan_expires_at');
            $table->decimal('last_payment_amount', 8, 2)->nullable()->after('last_payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['plan_expires_at', 'last_payment_date', 'last_payment_amount']);
        });
    }
};
