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
        Schema::create('short_links', function (Blueprint $table) {
            $table->id();
            
            // Relación con shops con nombre de constraint explícito y único
            $table->unsignedBigInteger('shop_id')->index();
            $table->foreign('shop_id', 'short_links_shop_id_fk')->references('id')->on('shops')->onDelete('cascade');
            
            // Código único del acortador (ej: 'ys', 'ys-maracay')
            $table->string('code')->unique()->index();
            
            // URL de destino completa
            $table->text('destination_url');
            
            // Contador de clics/visitas para analíticas
            $table->integer('clicks_count')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_links');
    }
};
