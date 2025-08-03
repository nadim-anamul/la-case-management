<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compensations', function (Blueprint $table) {
            // First, create a new JSON column
            $table->json('award_holder_names')->nullable()->after('award_holder_name');
        });

        // Migrate existing data
        DB::statement('UPDATE compensations SET award_holder_names = JSON_ARRAY(award_holder_name) WHERE award_holder_name IS NOT NULL');

        // Drop the old column
        Schema::table('compensations', function (Blueprint $table) {
            $table->dropColumn('award_holder_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compensations', function (Blueprint $table) {
            // Recreate the old column
            $table->string('award_holder_name')->after('plot_no');
        });

        // Migrate data back (take first name from array)
        DB::statement('UPDATE compensations SET award_holder_name = JSON_UNQUOTE(JSON_EXTRACT(award_holder_names, "$[0]")) WHERE award_holder_names IS NOT NULL');

        // Drop the new column
        Schema::table('compensations', function (Blueprint $table) {
            $table->dropColumn('award_holder_names');
        });
    }
};
