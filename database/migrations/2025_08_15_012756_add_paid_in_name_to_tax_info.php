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
        // Update existing tax_info JSON data to include the new 'paid_in_name' field
        $compensations = DB::table('compensations')->whereNotNull('tax_info')->get();
        
        foreach ($compensations as $compensation) {
            $taxInfo = json_decode($compensation->tax_info, true);
            
            if (is_array($taxInfo) && !isset($taxInfo['paid_in_name'])) {
                $taxInfo['paid_in_name'] = '';
                
                DB::table('compensations')
                    ->where('id', $compensation->id)
                    ->update(['tax_info' => json_encode($taxInfo)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the 'paid_in_name' field from existing tax_info JSON data
        $compensations = DB::table('compensations')->whereNotNull('tax_info')->get();
        
        foreach ($compensations as $compensation) {
            $taxInfo = json_decode($compensation->tax_info, true);
            
            if (is_array($taxInfo) && isset($taxInfo['paid_in_name'])) {
                unset($taxInfo['paid_in_name']);
                
                DB::table('compensations')
                    ->where('id', $compensation->id)
                    ->update(['tax_info' => json_encode($taxInfo)]);
            }
        }
    }
};
