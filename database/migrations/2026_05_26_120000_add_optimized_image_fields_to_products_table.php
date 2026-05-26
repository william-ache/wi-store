<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image_webp_path')->nullable()->after('image_path');
            $table->unsignedSmallInteger('image_width')->nullable()->after('image_webp_path');
            $table->unsignedSmallInteger('image_height')->nullable()->after('image_width');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image_webp_path', 'image_width', 'image_height']);
        });
    }
};
