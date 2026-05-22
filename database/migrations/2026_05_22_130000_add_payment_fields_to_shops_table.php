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
            $table->string('pending_plan')->nullable()->after('active_session_id');
            $table->string('pending_billing_cycle')->nullable()->after('pending_plan');
            $table->string('payment_status')->default('none')->after('pending_billing_cycle');
            $table->string('payment_reference')->nullable()->after('payment_status');
            $table->string('payment_receipt_path')->nullable()->after('payment_reference');
            $table->timestamp('payment_submitted_at')->nullable()->after('payment_receipt_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'pending_plan',
                'pending_billing_cycle',
                'payment_status',
                'payment_reference',
                'payment_receipt_path',
                'payment_submitted_at'
            ]);
        });
    }
};
