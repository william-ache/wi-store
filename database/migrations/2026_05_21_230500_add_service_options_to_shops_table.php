<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->boolean('has_dine_in')->default(true);
            $table->boolean('has_pickup')->default(true);
            $table->boolean('has_delivery')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['has_dine_in', 'has_pickup', 'has_delivery']);
        });
    }
};
