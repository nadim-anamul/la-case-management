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
            $table->string('order_signature_date')->nullable();
            $table->string('signing_officer_name')->nullable();
            $table->string('land_schedule_sa_plot_no')->nullable(); // SA দাগ নং (land schedule)
            $table->string('land_schedule_rs_plot_no')->nullable(); // RS দাগ নং (land schedule)
            $table->enum('status', ['pending', 'done'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {
            $table->dropColumn(['order_signature_date', 'signing_officer_name', 'status']);
        });
    }
};
