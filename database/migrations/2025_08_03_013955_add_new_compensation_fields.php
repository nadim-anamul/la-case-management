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
            $table->string('source_tax_percentage')->nullable()->after('total_compensation');
            $table->string('tree_compensation')->nullable()->after('source_tax_percentage');
            $table->string('infrastructure_compensation')->nullable()->after('tree_compensation');
            $table->string('infrastructure_source_tax_percentage')->nullable()->after('infrastructure_compensation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {
            $table->dropColumn([
                'source_tax_percentage',
                'tree_compensation',
                'infrastructure_compensation',
                'infrastructure_source_tax_percentage'
            ]);
        });
    }
};
