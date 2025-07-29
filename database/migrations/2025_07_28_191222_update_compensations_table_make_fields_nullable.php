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
            $table->string('rs_khatian_no')->nullable()->change();
            $table->string('sa_khatian_no')->nullable()->change();
            $table->string('award_type')->nullable()->change();
            $table->text('objector_details')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {
            $table->string('rs_khatian_no')->nullable(false)->change();
            $table->string('sa_khatian_no')->nullable(false)->change();
            $table->string('award_type')->nullable(false)->change();
            $table->text('objector_details')->nullable(false)->change();
        });
    }
};
