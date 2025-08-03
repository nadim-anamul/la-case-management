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
            $table->string('land_award_serial_no')->nullable()->after('award_serial_no');
            $table->string('tree_award_serial_no')->nullable()->after('land_award_serial_no');
            $table->string('infrastructure_award_serial_no')->nullable()->after('tree_award_serial_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {
            $table->dropColumn(['land_award_serial_no', 'tree_award_serial_no', 'infrastructure_award_serial_no']);
        });
    }
};
