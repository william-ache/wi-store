<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->string('logo_webp_path')->nullable()->after('logo_path');
            $table->string('cover_webp_path')->nullable()->after('cover_path');
            $table->unsignedSmallInteger('logo_width')->nullable()->after('logo_webp_path');
            $table->unsignedSmallInteger('logo_height')->nullable()->after('logo_width');
            $table->unsignedSmallInteger('cover_width')->nullable()->after('cover_webp_path');
            $table->unsignedSmallInteger('cover_height')->nullable()->after('cover_width');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->string('image_webp_path')->nullable()->after('image_path');
            $table->unsignedSmallInteger('image_width')->nullable()->after('image_webp_path');
            $table->unsignedSmallInteger('image_height')->nullable()->after('image_width');
        });
    }

    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'logo_webp_path',
                'cover_webp_path',
                'logo_width',
                'logo_height',
                'cover_width',
                'cover_height',
            ]);
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['image_webp_path', 'image_width', 'image_height']);
        });
    }
};
