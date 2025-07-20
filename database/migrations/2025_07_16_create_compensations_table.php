<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compensations', function (Blueprint $table) {
            $table->id();
            $table->json('applicants');
            $table->string('la_case_no');
            $table->json('award_type')->nullable();
            $table->string('award_serial_no');
            $table->string('acquisition_record_basis');
            $table->string('plot_no');
            $table->string('award_holder_name');
            $table->text('objector_details')->nullable();
            $table->boolean('is_applicant_in_award');
            $table->string('total_acquired_land');
            $table->string('total_compensation');
            $table->string('applicant_acquired_land');
            $table->string('mouza_name');
            $table->string('jl_no');
            $table->string('sa_khatian_no');
            $table->string('former_plot_no');
            $table->string('rs_khatian_no');
            $table->string('current_plot_no');
            $table->boolean('is_applicant_sa_owner');
            $table->json('ownership_details');
            $table->json('mutation_info');
            $table->json('tax_info');
            $table->json('additional_documents_info');
            $table->json('kanungo_opinion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compensations');
    }
};