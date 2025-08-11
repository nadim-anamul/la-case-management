<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, convert any NULL values to empty JSON objects
        DB::table('compensations')
            ->whereNull('ownership_details')
            ->orWhere('ownership_details', '')
            ->update(['ownership_details' => '{}']);

        Schema::table('compensations', function (Blueprint $table) {
            // Change ownership_details from TEXT to JSON (nullable)
            $table->json('ownership_details')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {
            // Revert ownership_details back to TEXT
            $table->text('ownership_details')->change();
        });
    }
};
