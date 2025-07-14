<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('district');
            $table->string('case_type');
            $table->string('case_number');
            $table->date('order_date');
            $table->text('applicant_name');
            $table->text('applicant_details');
            $table->text('roedad_review');
            $table->text('miss_case_details');
            $table->text('sa_record_details');
            $table->text('sa_owner_heir_details');
            $table->text('sa_heir_heir_details');
            $table->text('sa_heir_transfer_details_1');
            $table->text('sa_heir_transfer_details_2');
            $table->text('rs_khatian_details');
            $table->text('rs_owner_heir_details');
            $table->text('tax_review');
            $table->text('no_claim_review');
            $table->text('investigation_review');
            $table->text('applicant_claim');
            $table->text('overall_review');
            $table->text('final_order_summary');
            $table->text('final_payment_order');
            $table->text('compensation_details');
            $table->string('total_compensation_words');
            $table->string('lao_name');
            $table->string('adc_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_sheets');
    }
};