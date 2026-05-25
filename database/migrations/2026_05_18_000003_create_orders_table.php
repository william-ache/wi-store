<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id')->index();
            $table->foreign('shop_id', 'orders_shop_id_fk')->references('id')->on('shops')->onDelete('cascade');
            
            $table->unsignedBigInteger('client_id')->nullable()->index();
            $table->foreign('client_id', 'orders_client_id_fk')->references('id')->on('clients')->onDelete('set null');
            
            $table->string('order_number');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending'); // pending, collected, preparing, ready, delivered, cancelled
            $table->string('payment_method')->default('efectivo'); // cash, pagomovil, card, etc.
            $table->string('payment_status')->default('pending'); // pending, paid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
