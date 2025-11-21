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
        if (!Schema::hasColumn('withdraw_requests', 'sender_note')) {
            Schema::table('withdraw_requests', function (Blueprint $table) {
                $table->text('sender_note')->nullable()->after('transaction_note');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('withdraw_requests', 'sender_note')) {
            Schema::table('withdraw_requests', function (Blueprint $table) {
                $table->dropColumn('sender_note');
            });
        }
    }
};
