<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Compensation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FullCompensationFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_compensation_form_submission_saves_all_data()
    {
        // Prepare comprehensive test data for the full form
        $formData = [
            // Basic Case Information
            'case_number' => 'CASE-001',
            'case_date' => '2024-01-15',
            
            // Applicants Information
            'applicants' => [
                [
                    'name' => 'John Doe',
                    'father_name' => 'Father Doe',
                    'address' => '123 Test Street, Test City',
                    'nid' => '12345678901234567890'
                ]
            ],
            
            // LA Case Information
            'la_case_no' => 'LA-CASE-001',
            'award_serial_no' => 'AWARD-001',
            'plot_no' => 'PLOT-001',
            'award_holder_name' => 'Award Holder',
            'is_applicant_in_award' => true,
            'total_acquired_land' => '5 acres',
            'total_compensation' => '500000',
            'applicant_acquired_land' => '2 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'land_schedule_sa_plot_no' => 'SA-PLOT-001',
            'land_schedule_rs_plot_no' => 'RS-PLOT-001',
            
            // Award Information (SA/RS)
            'acquisition_record_basis' => 'SA',
            'sa_plot_no' => 'SA-PLOT-001',
            'sa_khatian_no' => 'SA-KHATIAN-001',
            'rs_plot_no' => 'RS-PLOT-001',
            'rs_khatian_no' => 'RS-KHATIAN-001',
            
            // SA Owners
            'sa_owners' => [
                ['name' => 'John Doe'],
                ['name' => 'Jane Smith']
            ],
            
            // RS Owners
            'rs_owners' => [
                ['name' => 'Bob Johnson'],
                ['name' => 'Alice Brown']
            ],
            
            // Tax Information
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১',
                'holding_no' => 'HLD-001',
                'paid_land_amount' => '2.5 acres'
            ],
            
            // Additional Documents Information
            'additional_documents_info' => [
                'selected_types' => ['distribution', 'no_claim', 'compromise', 'affidavit'],
                'details' => [
                    'distribution' => 'Test distribution document details',
                    'no_claim' => 'Test no claim document details',
                    'compromise' => 'Test compromise document details',
                    'affidavit' => 'Test affidavit document details',
                    'map' => 'Test map document details'
                ]
            ],
            
            // Ownership Details - SA Info
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-001',
                    'sa_khatian_no' => 'SA-KHATIAN-001',
                    'sa_total_land_in_plot' => '5 acres',
                    'sa_land_in_khatian' => '3 acres'
                ],
                
                // RS Info
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-001',
                    'rs_khatian_no' => 'RS-KHATIAN-001',
                    'rs_total_land_in_plot' => '4 acres',
                    'rs_land_in_khatian' => '2 acres'
                ],
                
                // SA Owners
                'sa_owners' => [
                    ['name' => 'John Doe'],
                    ['name' => 'Jane Smith']
                ],
                
                // RS Owners
                'rs_owners' => [
                    ['name' => 'Bob Johnson'],
                    ['name' => 'Alice Brown']
                ],
                
                // Deed Transfers
                'deed_transfers' => [
                    [
                        'donor_names' => [ ['name' => 'Mohammad Ali'] ],
                        'recipient_names' => [ ['name' => 'Abdul Rahman'] ],
                        'deed_number' => 'DEED-001',
                        'deed_date' => '2024-01-15',
                        'sale_type' => 'Specific Plot',
                        'plot_no' => 'PLOT-001',
                        'sold_land_amount' => '2 acres',
                        'total_sotangsho' => '50%',
                        'total_shotok' => '25%',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'POSS-001',
                        'possession_description' => 'Full possession transferred'
                    ]
                ],
                
                // Inheritance Records
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'Deceased Owner',
                        'death_date' => '2023-12-01',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'Certificate number: HEIR-001'
                    ]
                ],
                
                // RS Records
                'rs_records' => [
                    [
                        'plot_no' => 'RS-PLOT-002',
                        'khatian_no' => 'RS-KHATIAN-002',
                        'land_amount' => '1.5 acres',
                        'owner_name' => 'RS Owner'
                    ]
                ],
                
                // Applicant Info (Kharij Information)
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'kharij_case_no' => 'KHARIJ-001',
                    'kharij_plot_no' => 'KHARIJ-PLOT-001',
                    'kharij_land_amount' => '2 acres',
                    'kharij_date' => '2024-06-01',
                    'kharij_details' => 'Test kharij details for mutation'
                ],
                
                // Transfer Items Summary
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 0],
                    ['type' => 'ওয়ারিশ', 'index' => 0],
                    ['type' => 'আরএস রেকর্ড', 'index' => 0]
                ],
                
                // Flow State
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers'],
                'rs_record_disabled' => true
            ]
        ];

        // Submit the form
        $response = $this->post('/compensation/store', $formData);

        // Assert successful redirect
        $response->assertRedirect('/compensations');

        // Get the saved compensation record
        $compensation = Compensation::latest()->first();

        // Assert the record was created
        $this->assertNotNull($compensation);

        // Verify Tax Information
        $this->assertEquals('2024', $compensation->tax_info['english_year']);
        $this->assertEquals('১৪৩১', $compensation->tax_info['bangla_year']);
        $this->assertEquals('HLD-001', $compensation->tax_info['holding_no']);
        $this->assertEquals('2.5 acres', $compensation->tax_info['paid_land_amount']);

        // Verify Award Information
        $this->assertEquals('SA', $compensation->acquisition_record_basis);
        $this->assertEquals('SA-PLOT-001', $compensation->sa_plot_no);
        $this->assertEquals('SA-KHATIAN-001', $compensation->sa_khatian_no);
        $this->assertEquals('RS-PLOT-001', $compensation->rs_plot_no);
        $this->assertEquals('RS-KHATIAN-001', $compensation->rs_khatian_no);

        // Verify SA Owners (stored in ownership_details)
        $this->assertEquals('John Doe', $compensation->ownership_details['sa_owners'][0]['name']);
        $this->assertEquals('Jane Smith', $compensation->ownership_details['sa_owners'][1]['name']);

        // Verify RS Owners (stored in ownership_details)
        $this->assertEquals('Bob Johnson', $compensation->ownership_details['rs_owners'][0]['name']);
        $this->assertEquals('Alice Brown', $compensation->ownership_details['rs_owners'][1]['name']);

        // Verify Ownership Details Structure
        $ownershipDetails = $compensation->ownership_details;

        // Verify SA Info
        $this->assertEquals('SA-PLOT-001', $ownershipDetails['sa_info']['sa_plot_no']);
        $this->assertEquals('SA-KHATIAN-001', $ownershipDetails['sa_info']['sa_khatian_no']);
        $this->assertEquals('5 acres', $ownershipDetails['sa_info']['sa_total_land_in_plot']);
        $this->assertEquals('3 acres', $ownershipDetails['sa_info']['sa_land_in_khatian']);

        // Verify RS Info
        $this->assertEquals('RS-PLOT-001', $ownershipDetails['rs_info']['rs_plot_no']);
        $this->assertEquals('RS-KHATIAN-001', $ownershipDetails['rs_info']['rs_khatian_no']);
        $this->assertEquals('4 acres', $ownershipDetails['rs_info']['rs_total_land_in_plot']);
        $this->assertEquals('2 acres', $ownershipDetails['rs_info']['rs_land_in_khatian']);

        // Verify SA Owners in ownership_details
        $this->assertEquals('John Doe', $ownershipDetails['sa_owners'][0]['name']);
        $this->assertEquals('Jane Smith', $ownershipDetails['sa_owners'][1]['name']);

        // Verify RS Owners in ownership_details
        $this->assertEquals('Bob Johnson', $ownershipDetails['rs_owners'][0]['name']);
        $this->assertEquals('Alice Brown', $ownershipDetails['rs_owners'][1]['name']);

        // Verify Deed Transfers
        $this->assertEquals('Mohammad Ali', $ownershipDetails['deed_transfers'][0]['donor_names'][0]['name']);
        $this->assertEquals('Abdul Rahman', $ownershipDetails['deed_transfers'][0]['recipient_names'][0]['name']);
        $this->assertEquals('DEED-001', $ownershipDetails['deed_transfers'][0]['deed_number']);
        $this->assertEquals('2024-01-15', $ownershipDetails['deed_transfers'][0]['deed_date']);
        $this->assertEquals('Specific Plot', $ownershipDetails['deed_transfers'][0]['sale_type']);
        $this->assertEquals('PLOT-001', $ownershipDetails['deed_transfers'][0]['plot_no']);
        $this->assertEquals('2 acres', $ownershipDetails['deed_transfers'][0]['sold_land_amount']);
        $this->assertEquals('50%', $ownershipDetails['deed_transfers'][0]['total_sotangsho']);
        $this->assertEquals('25%', $ownershipDetails['deed_transfers'][0]['total_shotok']);
        $this->assertEquals('yes', $ownershipDetails['deed_transfers'][0]['possession_mentioned']);
        $this->assertEquals('POSS-001', $ownershipDetails['deed_transfers'][0]['possession_plot_no']);
        $this->assertEquals('Full possession transferred', $ownershipDetails['deed_transfers'][0]['possession_description']);

        // Verify Inheritance Records
        $this->assertEquals('Deceased Owner', $ownershipDetails['inheritance_records'][0]['previous_owner_name']);
        $this->assertEquals('2023-12-01', $ownershipDetails['inheritance_records'][0]['death_date']);
        $this->assertEquals('yes', $ownershipDetails['inheritance_records'][0]['has_death_cert']);
        $this->assertEquals('Certificate number: HEIR-001', $ownershipDetails['inheritance_records'][0]['heirship_certificate_info']);

        // Verify RS Records
        $this->assertEquals('RS-PLOT-002', $ownershipDetails['rs_records'][0]['plot_no']);
        $this->assertEquals('RS-KHATIAN-002', $ownershipDetails['rs_records'][0]['khatian_no']);
        $this->assertEquals('1.5 acres', $ownershipDetails['rs_records'][0]['land_amount']);
        $this->assertEquals('RS Owner', $ownershipDetails['rs_records'][0]['owner_name']);

        // Verify Applicant Info (Kharij Information)
        $this->assertEquals('Test Applicant', $ownershipDetails['applicant_info']['applicant_name']);
        $this->assertEquals('KHARIJ-001', $ownershipDetails['applicant_info']['kharij_case_no']);
        $this->assertEquals('KHARIJ-PLOT-001', $ownershipDetails['applicant_info']['kharij_plot_no']);
        $this->assertEquals('2 acres', $ownershipDetails['applicant_info']['kharij_land_amount']);
        $this->assertEquals('2024-06-01', $ownershipDetails['applicant_info']['kharij_date']);
        $this->assertEquals('Test kharij details for mutation', $ownershipDetails['applicant_info']['kharij_details']);

        // Verify Transfer Items Summary
        $this->assertEquals('দলিল', $ownershipDetails['transferItems'][0]['type']);
        $this->assertEquals(0, $ownershipDetails['transferItems'][0]['index']);
        $this->assertEquals('ওয়ারিশ', $ownershipDetails['transferItems'][1]['type']);
        $this->assertEquals(0, $ownershipDetails['transferItems'][1]['index']);
        $this->assertEquals('আরএস রেকর্ড', $ownershipDetails['transferItems'][2]['type']);
        $this->assertEquals(0, $ownershipDetails['transferItems'][2]['index']);

        // Verify Flow State
        $this->assertEquals('applicant', $ownershipDetails['currentStep']);
        $this->assertEquals(['info', 'transfers'], $ownershipDetails['completedSteps']);
        $this->assertTrue($ownershipDetails['rs_record_disabled']);
    }

    public function test_full_compensation_form_with_rs_basis_saves_correctly()
    {
        // Prepare test data for RS-based acquisition
        $formData = [
            // Basic Case Information
            'case_number' => 'CASE-002',
            'case_date' => '2024-02-15',
            
            // Applicants Information
            'applicants' => [
                [
                    'name' => 'Jane Smith',
                    'father_name' => 'Father Smith',
                    'address' => '456 Test Street, Test City',
                    'nid' => '09876543210987654321'
                ]
            ],
            
            // LA Case Information
            'la_case_no' => 'LA-CASE-002',
            'award_serial_no' => 'AWARD-002',
            'plot_no' => 'PLOT-002',
            'award_holder_name' => 'RS Award Holder',
            'is_applicant_in_award' => false,
            'total_acquired_land' => '3 acres',
            'total_compensation' => '300000',
            'applicant_acquired_land' => '1.5 acres',
            'mouza_name' => 'RS Test Mouza',
            'jl_no' => 'JL-002',
            'land_schedule_sa_plot_no' => 'RS-SA-PLOT-001',
            'land_schedule_rs_plot_no' => 'RS-RS-PLOT-001',
            
            // Award Information (RS)
            'acquisition_record_basis' => 'RS',
            'sa_plot_no' => 'SA-PLOT-001',
            'sa_khatian_no' => 'SA-KHATIAN-001',
            'rs_plot_no' => 'RS-PLOT-001',
            'rs_khatian_no' => 'RS-KHATIAN-001',
            
            // SA Owners
            'sa_owners' => [
                ['name' => 'John Doe']
            ],
            
            // RS Owners
            'rs_owners' => [
                ['name' => 'Bob Johnson'],
                ['name' => 'Alice Brown']
            ],
            
            // Tax Information
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১',
                'holding_no' => 'RS-HLD-001',
                'paid_land_amount' => '1.5 acres'
            ],
            
            // Additional Documents Information
            'additional_documents_info' => [
                'selected_types' => ['deed'],
                'details' => ['deed' => 'RS Test deed document details']
            ],
            
            // Ownership Details
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-001',
                    'sa_khatian_no' => 'SA-KHATIAN-001',
                    'sa_total_land_in_plot' => '5 acres',
                    'sa_land_in_khatian' => '3 acres'
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-001',
                    'rs_khatian_no' => 'RS-KHATIAN-001',
                    'rs_total_land_in_plot' => '4 acres',
                    'rs_land_in_khatian' => '2 acres'
                ],
                'sa_owners' => [
                    ['name' => 'John Doe']
                ],
                'rs_owners' => [
                    ['name' => 'Bob Johnson'],
                    ['name' => 'Alice Brown']
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [ ['name' => 'RS Original Owner'] ],
                        'recipient_names' => [ ['name' => 'RS New Owner'] ],
                        'deed_number' => 'RS-DEED-001',
                        'deed_date' => '2024-02-15',
                        'sale_type' => 'RS Specific Plot',
                        'plot_no' => 'RS-PLOT-002',
                        'sold_land_amount' => '1.5 acres',
                        'total_sotangsho' => '30%',
                        'total_shotok' => '15%',
                        'possession_mentioned' => 'no',
                        'possession_plot_no' => '',
                        'possession_description' => ''
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'RS Test Applicant',
                    'kharij_case_no' => 'RS-KHARIJ-001',
                    'kharij_plot_no' => 'RS-KHARIJ-PLOT-001',
                    'kharij_land_amount' => '1.5 acres',
                    'kharij_date' => '2024-07-01',
                    'kharij_details' => 'RS Test kharij details'
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 0]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers'],
                'rs_record_disabled' => false
            ]
        ];

        // Submit the form
        $response = $this->post('/compensation/store', $formData);

        // Assert successful redirect
        $response->assertRedirect('/compensations');

        // Get the saved compensation record
        $compensation = Compensation::latest()->first();

        // Assert the record was created
        $this->assertNotNull($compensation);

        // Verify RS-based acquisition
        $this->assertEquals('RS', $compensation->acquisition_record_basis);

        // Verify ownership details structure
        $ownershipDetails = $compensation->ownership_details;

        // Verify deed transfers for RS basis
        $this->assertEquals('RS Original Owner', $ownershipDetails['deed_transfers'][0]['donor_names'][0]['name']);
        $this->assertEquals('RS New Owner', $ownershipDetails['deed_transfers'][0]['recipient_names'][0]['name']);
        $this->assertEquals('RS-DEED-001', $ownershipDetails['deed_transfers'][0]['deed_number']);

        // Verify applicant info for RS basis
        $this->assertEquals('RS Test Applicant', $ownershipDetails['applicant_info']['applicant_name']);
        $this->assertEquals('RS-KHARIJ-001', $ownershipDetails['applicant_info']['kharij_case_no']);

        // Verify empty arrays are saved correctly
        $this->assertEmpty($ownershipDetails['inheritance_records']);
        $this->assertEmpty($ownershipDetails['rs_records']);

        // Verify flow state
        $this->assertEquals('applicant', $ownershipDetails['currentStep']);
        $this->assertFalse($ownershipDetails['rs_record_disabled']);
    }

    public function test_compensation_form_validation_works_correctly()
    {
        // Test with missing required fields
        $response = $this->post('/compensation/store', [
            'tax_info' => [
                'english_year' => '', // Missing required field
                'bangla_year' => '১৪৩১'
            ]
        ]);

        // Assert validation errors for missing required fields
        $response->assertSessionHasErrors(['case_number']);
        $response->assertSessionHasErrors(['case_date']);
        $response->assertSessionHasErrors(['applicants']);
        $response->assertSessionHasErrors(['la_case_no']);
        $response->assertSessionHasErrors(['award_serial_no']);
        $response->assertSessionHasErrors(['plot_no']);
        $response->assertSessionHasErrors(['award_holder_name']);
        $response->assertSessionHasErrors(['is_applicant_in_award']);
        $response->assertSessionHasErrors(['total_acquired_land']);
        $response->assertSessionHasErrors(['total_compensation']);
        $response->assertSessionHasErrors(['applicant_acquired_land']);
        $response->assertSessionHasErrors(['mouza_name']);
        $response->assertSessionHasErrors(['jl_no']);
        $response->assertSessionHasErrors(['land_schedule_sa_plot_no']);
        $response->assertSessionHasErrors(['land_schedule_rs_plot_no']);
        // ownership_details is now optional, so we don't check for it
        $response->assertSessionHasErrors(['additional_documents_info']);
        // kanungo_opinion is now handled separately, so we don't check for it

        // Test with invalid acquisition_record_basis
        $response = $this->post('/compensation/store', [
            'case_number' => 'CASE-001',
            'case_date' => '2024-01-15',
            'applicants' => [
                [
                    'name' => 'John Doe',
                    'father_name' => 'Father Doe',
                    'address' => '123 Test Street',
                    'nid' => '12345678901234567890'
                ]
            ],
            'la_case_no' => 'LA-CASE-001',
            'award_serial_no' => 'AWARD-001',
            'plot_no' => 'PLOT-001',
            'award_holder_name' => 'Award Holder',
            'is_applicant_in_award' => true,
            'total_acquired_land' => '5 acres',
            'total_compensation' => '500000',
            'applicant_acquired_land' => '2 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'land_schedule_sa_plot_no' => 'SA-PLOT-001',
            'land_schedule_rs_plot_no' => 'RS-PLOT-001',
            'acquisition_record_basis' => 'INVALID', // Invalid value
            'sa_plot_no' => 'SA-PLOT-001',
            'sa_khatian_no' => 'SA-KHATIAN-001',
            'rs_plot_no' => 'RS-PLOT-001',
            'rs_khatian_no' => 'RS-KHATIAN-001',
            'sa_owners' => [['name' => 'John Doe']],
            'rs_owners' => [['name' => 'Bob Johnson']],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১',
                'holding_no' => 'HLD-001',
                'paid_land_amount' => '2.5 acres'
            ],
            'additional_documents_info' => [
                'selected_types' => ['deed'],
                'details' => ['deed' => 'Test deed details']
            ],
            'ownership_details' => [
                'sa_info' => ['sa_plot_no' => 'SA-PLOT-001'],
                'rs_info' => ['rs_plot_no' => 'RS-PLOT-001'],
                'sa_owners' => [['name' => 'John Doe']],
                'rs_owners' => [['name' => 'Bob Johnson']],
                'deed_transfers' => [
                    [
                        'donor_names' => [ ['name' => 'Mohammad Ali'] ],
                        'recipient_names' => [ ['name' => 'Abdul Rahman'] ],
                        'deed_number' => 'DEED-001',
                        'deed_date' => '2024-01-15',
                        'sale_type' => 'Specific Plot',
                        'plot_no' => 'PLOT-001',
                        'sold_land_amount' => '2 acres',
                        'total_sotangsho' => '50%',
                        'total_shotok' => '25%',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'POSS-001',
                        'possession_description' => 'Full possession transferred'
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => ['applicant_name' => 'Test Applicant'],
                'transferItems' => [],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers'],
                'rs_record_disabled' => false
            ]
        ]);

        // Assert validation errors for invalid acquisition_record_basis
        $response->assertSessionHasErrors(['acquisition_record_basis']);
    }
} 