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
        // Fix award_type values to use single values instead of combined values
        $compensations = DB::table('compensations')->get();
        
        foreach ($compensations as $compensation) {
            $awardType = json_decode($compensation->award_type, true);
            
            if (is_array($awardType) && !empty($awardType)) {
                $firstValue = $awardType[0];
                
                if (str_contains($firstValue, 'জমি/অবকাঠামো')) {
                    DB::table('compensations')->where('id', $compensation->id)
                        ->update(['award_type' => json_encode(['জমি'])]);
                } elseif (str_contains($firstValue, 'জমি/গাছপালা')) {
                    DB::table('compensations')->where('id', $compensation->id)
                        ->update(['award_type' => json_encode(['জমি ও গাছপালা'])]);
                } elseif (str_contains($firstValue, 'অবকাঠামো') && !str_contains($firstValue, 'জমি')) {
                    DB::table('compensations')->where('id', $compensation->id)
                        ->update(['award_type' => json_encode(['অবকাঠামো'])]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original combined values
        $compensations = DB::table('compensations')->get();
        
        foreach ($compensations as $compensation) {
            $awardType = json_decode($compensation->award_type, true);
            
            if (is_array($awardType) && !empty($awardType)) {
                $firstValue = $awardType[0];
                
                if ($firstValue === 'জমি') {
                    DB::table('compensations')->where('id', $compensation->id)
                        ->update(['award_type' => json_encode(['জমি/অবকাঠামো'])]);
                } elseif ($firstValue === 'জমি ও গাছপালা') {
                    DB::table('compensations')->where('id', $compensation->id)
                        ->update(['award_type' => json_encode(['জমি/গাছপালা'])]);
                } elseif ($firstValue === 'অবকাঠামো') {
                    DB::table('compensations')->where('id', $compensation->id)
                        ->update(['award_type' => json_encode(['অবকাঠামো'])]);
                }
            }
        }
    }
};
