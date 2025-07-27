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
        // Update existing tax_info records to use new structure
        $compensations = DB::table('compensations')->whereNotNull('tax_info')->get();
        
        foreach ($compensations as $compensation) {
            $taxInfo = json_decode($compensation->tax_info, true);
            
            if (isset($taxInfo['paid_until'])) {
                // Convert old structure to new structure
                $newTaxInfo = [
                    'english_year' => $taxInfo['paid_until'] ?? '',
                    'bangla_year' => $taxInfo['paid_until'] ?? ''
                ];
                
                DB::table('compensations')
                    ->where('id', $compensation->id)
                    ->update(['tax_info' => json_encode($newTaxInfo)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert to old structure if needed
        $compensations = DB::table('compensations')->whereNotNull('tax_info')->get();
        
        foreach ($compensations as $compensation) {
            $taxInfo = json_decode($compensation->tax_info, true);
            
            if (isset($taxInfo['english_year']) || isset($taxInfo['bangla_year'])) {
                // Convert new structure back to old structure
                $oldTaxInfo = [
                    'paid_until' => $taxInfo['english_year'] ?? $taxInfo['bangla_year'] ?? ''
                ];
                
                DB::table('compensations')
                    ->where('id', $compensation->id)
                    ->update(['tax_info' => json_encode($oldTaxInfo)]);
            }
        }
    }
};
