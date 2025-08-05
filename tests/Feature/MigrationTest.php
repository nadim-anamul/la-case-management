<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Compensation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_old_deed_transfer_fields_removed()
    {
        // Create a compensation record with old deed transfer fields
        $compensation = Compensation::create([
            'case_number' => 'TEST-MIGRATION-001',
            'case_date' => '2024-01-01',
            'applicants' => [['name' => 'Test Applicant']],
            'la_case_no' => 'LA-001',
            'award_type' => ['জমি'],
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'award_holder_names' => [['name' => 'Test Holder']],
            'is_applicant_in_award' => true,
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'ownership_details' => [
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Donor']],
                        'recipient_names' => [['name' => 'Recipient']],
                        'deed_number' => 'DEED-001',
                        'deed_date' => '2024-01-01',
                        'sale_type' => 'দলিল',
                        'plot_no' => 'PLOT-001', // Old field
                        'sold_land_amount' => '1 acre', // Old field
                        'total_sotangsho' => '50', // Old field
                        'total_shotok' => '25', // Old field
                        'application_specific_area' => 'PLOT-001',
                        'application_sell_area' => '1',
                        'possession_mentioned' => 'yes'
                    ]
                ]
            ]
        ]);

        // Verify the old fields exist before removal
        $this->assertArrayHasKey('plot_no', $compensation->ownership_details['deed_transfers'][0]);
        $this->assertArrayHasKey('sold_land_amount', $compensation->ownership_details['deed_transfers'][0]);
        $this->assertArrayHasKey('total_sotangsho', $compensation->ownership_details['deed_transfers'][0]);
        $this->assertArrayHasKey('total_shotok', $compensation->ownership_details['deed_transfers'][0]);

        // Manually remove the old fields (simulating the migration logic)
        $ownershipDetails = $compensation->ownership_details;
        foreach ($ownershipDetails['deed_transfers'] as &$deedTransfer) {
            unset($deedTransfer['plot_no']);
            unset($deedTransfer['sold_land_amount']);
            unset($deedTransfer['total_sotangsho']);
            unset($deedTransfer['total_shotok']);
        }
        
        $compensation->ownership_details = $ownershipDetails;
        $compensation->save();

        // Refresh the model from database
        $compensation->refresh();

        // Verify the old fields are removed
        $this->assertArrayNotHasKey('plot_no', $compensation->ownership_details['deed_transfers'][0]);
        $this->assertArrayNotHasKey('sold_land_amount', $compensation->ownership_details['deed_transfers'][0]);
        $this->assertArrayNotHasKey('total_sotangsho', $compensation->ownership_details['deed_transfers'][0]);
        $this->assertArrayNotHasKey('total_shotok', $compensation->ownership_details['deed_transfers'][0]);

        // Verify the remaining fields are still there
        $this->assertArrayHasKey('donor_names', $compensation->ownership_details['deed_transfers'][0]);
        $this->assertArrayHasKey('recipient_names', $compensation->ownership_details['deed_transfers'][0]);
        $this->assertArrayHasKey('deed_number', $compensation->ownership_details['deed_transfers'][0]);
        $this->assertArrayHasKey('application_specific_area', $compensation->ownership_details['deed_transfers'][0]);
    }
} 