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
        Schema::table('compensations', function (Blueprint $table) {
            $table->json('tax_info')->nullable()->change();
            $table->json('additional_documents_info')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {
            $table->json('tax_info')->nullable(false)->change();
            $table->json('additional_documents_info')->nullable(false)->change();
        });
    }
};
