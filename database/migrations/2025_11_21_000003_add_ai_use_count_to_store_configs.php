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
        if (!Schema::hasColumn('store_configs', 'section_wise_ai_use_count')) {
            Schema::table('store_configs', function (Blueprint $table) {
                $table->integer('section_wise_ai_use_count')->default(0);
            });
        }
        
        if (!Schema::hasColumn('store_configs', 'image_wise_ai_use_count')) {
            Schema::table('store_configs', function (Blueprint $table) {
                $table->integer('image_wise_ai_use_count')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('store_configs', 'section_wise_ai_use_count')) {
            Schema::table('store_configs', function (Blueprint $table) {
                $table->dropColumn('section_wise_ai_use_count');
            });
        }
        
        if (Schema::hasColumn('store_configs', 'image_wise_ai_use_count')) {
            Schema::table('store_configs', function (Blueprint $table) {
                $table->dropColumn('image_wise_ai_use_count');
            });
        }
    }
};
