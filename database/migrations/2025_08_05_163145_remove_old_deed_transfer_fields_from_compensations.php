<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all compensation records
        $compensations = DB::table('compensations')->get();
        
        foreach ($compensations as $compensation) {
            $ownershipDetails = json_decode($compensation->ownership_details, true);
            
            if (isset($ownershipDetails['deed_transfers']) && is_array($ownershipDetails['deed_transfers'])) {
                foreach ($ownershipDetails['deed_transfers'] as &$deedTransfer) {
                    // Remove the old fields that are no longer needed
                    unset($deedTransfer['plot_no']);
                    unset($deedTransfer['sold_land_amount']);
                    unset($deedTransfer['total_sotangsho']);
                    unset($deedTransfer['total_shotok']);
                }
                
                // Update the record with cleaned data
                DB::table('compensations')
                    ->where('id', $compensation->id)
                    ->update([
                        'ownership_details' => json_encode($ownershipDetails)
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: We cannot restore the removed fields as we don't have the original data
        // This migration is irreversible by design
    }
};
