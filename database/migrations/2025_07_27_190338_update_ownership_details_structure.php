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
        // Update existing ownership_details records to use new structure
        $compensations = DB::table('compensations')->whereNotNull('ownership_details')->get();
        
        foreach ($compensations as $compensation) {
            $ownershipDetails = json_decode($compensation->ownership_details, true);
            
            // Convert to new structure
            $newOwnershipDetails = [
                'sa_info' => [
                    'sa_owners' => $ownershipDetails['sa_owners'] ?? [],
                    'sa_plot_no' => $ownershipDetails['sa_plot_no'] ?? '',
                    'previous_owner_name' => $ownershipDetails['previous_owner_name'] ?? '',
                    'sa_khatian_no' => $ownershipDetails['sa_khatian_no'] ?? '',
                    'sa_total_land_in_plot' => $ownershipDetails['sa_total_land_in_plot'] ?? '',
                    'sa_land_in_khatian' => $ownershipDetails['sa_land_in_khatian'] ?? '',
                ],
                'rs_info' => [
                    'rs_owners' => $ownershipDetails['rs_owners'] ?? [],
                    'rs_plot_no' => $ownershipDetails['rs_plot_no'] ?? '',
                    'rs_previous_owner_name' => $ownershipDetails['rs_previous_owner_name'] ?? '',
                    'rs_khatian_no' => $ownershipDetails['rs_khatian_no'] ?? '',
                    'rs_total_land_in_plot' => $ownershipDetails['rs_total_land_in_plot'] ?? '',
                    'rs_land_in_khatian' => $ownershipDetails['rs_land_in_khatian'] ?? '',
                ],
                'transfer_info' => [
                    'ownership_type' => $ownershipDetails['ownership_type'] ?? '',
                    'deed_transfers' => $ownershipDetails['deed_transfers'] ?? [],
                    'inheritance_records' => $ownershipDetails['inheritance_records'] ?? [],
                ],
                'mutation_info' => [
                    'mutation_case_no' => '',
                    'mutation_plot_no' => '',
                    'mutation_land_amount' => '',
                    'mutation_date' => '',
                    'mutation_details' => '',
                ],
                'flow_state' => 'initial', // initial, transfer, rs_record, applicant_owner
                'rs_record_disabled' => false,
            ];
            
            DB::table('compensations')
                ->where('id', $compensation->id)
                ->update(['ownership_details' => json_encode($newOwnershipDetails)]);
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
        $compensations = DB::table('compensations')->whereNotNull('ownership_details')->get();
        
        foreach ($compensations as $compensation) {
            $ownershipDetails = json_decode($compensation->ownership_details, true);
            
            // Convert back to old structure
            $oldOwnershipDetails = [
                'is_applicant_sa_owner' => 'no',
                'sa_owners' => $ownershipDetails['sa_info']['sa_owners'] ?? [],
                'sa_plot_no' => $ownershipDetails['sa_info']['sa_plot_no'] ?? '',
                'previous_owner_name' => $ownershipDetails['sa_info']['previous_owner_name'] ?? '',
                'sa_khatian_no' => $ownershipDetails['sa_info']['sa_khatian_no'] ?? '',
                'sa_total_land_in_plot' => $ownershipDetails['sa_info']['sa_total_land_in_plot'] ?? '',
                'sa_land_in_khatian' => $ownershipDetails['sa_info']['sa_land_in_khatian'] ?? '',
                'rs_owners' => $ownershipDetails['rs_info']['rs_owners'] ?? [],
                'rs_plot_no' => $ownershipDetails['rs_info']['rs_plot_no'] ?? '',
                'rs_previous_owner_name' => $ownershipDetails['rs_info']['rs_previous_owner_name'] ?? '',
                'rs_khatian_no' => $ownershipDetails['rs_info']['rs_khatian_no'] ?? '',
                'rs_total_land_in_plot' => $ownershipDetails['rs_info']['rs_total_land_in_plot'] ?? '',
                'rs_land_in_khatian' => $ownershipDetails['rs_info']['rs_land_in_khatian'] ?? '',
                'ownership_type' => $ownershipDetails['transfer_info']['ownership_type'] ?? '',
                'deed_transfers' => $ownershipDetails['transfer_info']['deed_transfers'] ?? [],
                'inheritance_records' => $ownershipDetails['transfer_info']['inheritance_records'] ?? [],
            ];
            
            DB::table('compensations')
                ->where('id', $compensation->id)
                ->update(['ownership_details' => json_encode($oldOwnershipDetails)]);
        }
    }
};
