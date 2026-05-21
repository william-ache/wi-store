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
            $table->string('facebook')->nullable()->after('google_maps_link');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('tiktok')->nullable()->after('instagram');
            $table->string('x_twitter')->nullable()->after('tiktok');
            $table->string('contact_phone')->nullable()->after('x_twitter');
            $table->string('contact_sms')->nullable()->after('contact_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['facebook', 'instagram', 'tiktok', 'x_twitter', 'contact_phone', 'contact_sms']);
        });
    }
};
