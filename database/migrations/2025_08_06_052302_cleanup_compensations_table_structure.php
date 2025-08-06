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
            // Add indexes for better performance
            $table->index('status');
            $table->index('case_number');
            $table->index('la_case_no');
            $table->index('mouza_name');
            $table->index('created_at');
            
            // Ensure proper column types and constraints
            $table->string('case_number')->change();
            $table->string('case_date')->change();
            $table->string('la_case_no')->change();
            $table->string('acquisition_record_basis')->change();
            $table->string('plot_no')->change();
            $table->string('mouza_name')->change();
            $table->string('jl_no')->change();
            
            // Ensure JSON columns are properly nullable
            $table->json('applicants')->nullable()->change();
            $table->json('award_type')->nullable()->change();
            $table->json('award_holder_names')->nullable()->change();
            $table->json('land_category')->nullable()->change();
            $table->json('ownership_details')->nullable()->change();
            $table->json('mutation_info')->nullable()->change();
            $table->json('tax_info')->nullable()->change();
            $table->json('additional_documents_info')->nullable()->change();
            $table->json('kanungo_opinion')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {
            // Remove indexes
            $table->dropIndex(['status']);
            $table->dropIndex(['case_number']);
            $table->dropIndex(['la_case_no']);
            $table->dropIndex(['mouza_name']);
            $table->dropIndex(['created_at']);
        });
    }
};
