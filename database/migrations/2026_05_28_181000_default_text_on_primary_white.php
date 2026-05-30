<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('shops')
            ->whereNull('text_on_primary')
            ->orWhere('text_on_primary', 'auto')
            ->update(['text_on_primary' => 'white']);

        Schema::table('shops', function (Blueprint $table) {
            $table->string('text_on_primary', 10)->default('white')->change();
        });
    }

    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->string('text_on_primary', 10)->default('auto')->change();
        });
    }
};
