<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->string('whatsapp_number');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->text('payment_methods')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('cover_path')->nullable();
            $table->string('color_primary')->default('#E60067');
            $table->string('color_secondary')->default('#C6A100');
            $table->string('color_background')->default('#FFF0F8');
            $table->string('exchange_rate')->default('Bs. 515.18');
            $table->string('exchange_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
