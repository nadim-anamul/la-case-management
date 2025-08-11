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
        // Update existing award_type values to new structure
        $compensations = DB::table('compensations')->get();
        
        foreach ($compensations as $compensation) {
            $awardType = json_decode($compensation->award_type, true);
            
            if (is_array($awardType) && !empty($awardType)) {
                $updatedAwardType = [];
                
                foreach ($awardType as $type) {
                    if ($type === 'জমি ও গাছপালা') {
                        // Split into separate types
                        $updatedAwardType[] = 'জমি';
                        $updatedAwardType[] = 'গাছপালা/ফসল';
                    } else {
                        $updatedAwardType[] = $type;
                    }
                }
                
                // Remove duplicates and update
                $updatedAwardType = array_unique($updatedAwardType);
                DB::table('compensations')->where('id', $compensation->id)
                    ->update(['award_type' => json_encode($updatedAwardType)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original structure
        $compensations = DB::table('compensations')->get();
        
        foreach ($compensations as $compensation) {
            $awardType = json_decode($compensation->award_type, true);
            
            if (is_array($awardType) && !empty($awardType)) {
                $revertedAwardType = [];
                
                foreach ($awardType as $type) {
                    if ($type === 'গাছপালা/ফসল') {
                        // Combine with land if both exist
                        if (in_array('জমি', $awardType)) {
                            $revertedAwardType = ['জমি ও গাছপালা'];
                            break;
                        }
                    } else {
                        $revertedAwardType[] = $type;
                    }
                }
                
                DB::table('compensations')->where('id', $compensation->id)
                    ->update(['award_type' => json_encode($revertedAwardType)]);
            }
        }
    }
};
