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
            // Remove fields that are no longer used in the form
            $table->dropColumn([
                'award_serial_no',           // Replaced by conditional serial numbers
                'infrastructure_source_tax_percentage', // Not used in form
                'former_plot_no',            // Not used in current form structure
                'current_plot_no',           // Not used in current form structure
                'applicant_acquired_land',   // Not used in form
                'is_applicant_sa_owner',     // Not used in form
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {
            $table->string('award_serial_no')->nullable();
            $table->string('infrastructure_source_tax_percentage')->nullable();
            $table->string('former_plot_no')->nullable();
            $table->string('current_plot_no')->nullable();
            $table->string('applicant_acquired_land')->nullable();
            $table->boolean('is_applicant_sa_owner')->default(false);
        });
    }
};
