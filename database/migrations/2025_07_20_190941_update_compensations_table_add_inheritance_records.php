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
        // Since ownership_details is already JSON, we don't need to add new columns
        // But we can add an index to improve query performance for inheritance-related searches
        Schema::table('compensations', function (Blueprint $table) {
            // Add an index on ownership_details for better performance when querying inheritance data
            $table->index('ownership_details', 'idx_ownership_details');
        });

        // Migrate existing inheritance data to new structure if needed
        $this->migrateExistingInheritanceData();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compensations', function (Blueprint $table) {
            $table->dropIndex('idx_ownership_details');
        });
    }

    /**
     * Migrate existing inheritance data to new structure
     */
    private function migrateExistingInheritanceData(): void
    {
        $compensations = DB::table('compensations')->get();
        
        foreach ($compensations as $compensation) {
            $ownershipDetails = json_decode($compensation->ownership_details, true);
            
            // Check if old inheritance structure exists
            if (isset($ownershipDetails['inheritance']) && !isset($ownershipDetails['inheritance_records'])) {
                // Convert old inheritance structure to new inheritance_records array
                $oldInheritance = $ownershipDetails['inheritance'];
                
                $inheritanceRecord = [
                    'is_heir_applicant' => $oldInheritance['is_heir_applicant'] ?? 'yes',
                    'has_death_cert' => $oldInheritance['has_death_cert'] ?? 'yes',
                    'heirship_certificate_info' => $oldInheritance['heirship_certificate_info'] ?? '',
                    'previous_owner_name' => $oldInheritance['previous_owner_name'] ?? '',
                    'death_date' => $oldInheritance['death_date'] ?? '',
                    'inheritance_type' => $oldInheritance['inheritance_type'] ?? 'direct'
                ];
                
                // Add to new inheritance_records array
                $ownershipDetails['inheritance_records'] = [$inheritanceRecord];
                
                // Remove old inheritance structure
                unset($ownershipDetails['inheritance']);
                
                // Update the record
                DB::table('compensations')
                    ->where('id', $compensation->id)
                    ->update(['ownership_details' => json_encode($ownershipDetails)]);
            }
        }
    }
};
