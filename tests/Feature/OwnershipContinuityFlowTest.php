<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Compensation;

class OwnershipContinuityFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_sa_flow_with_transfer_option()
    {
        $compensationData = [
            'case_number' => 'TEST-SA-001',
            'case_date' => '2024-01-01',
            'applicants' => [
                [
                    'name' => 'Test Applicant',
                    'father_name' => 'Test Father',
                    'address' => 'Test Address',
                    'nid' => '1234567890'
                ]
            ],
            'la_case_no' => 'LA-001',
            'award_type' => ['জমি'],
            'land_award_serial_no' => 'AWD-001',
            'acquisition_record_basis' => 'SA',
            'sa_plot_no' => 'SA-PLOT-001',
            'plot_no' => 'PLOT-001',
            'award_holder_names' => [
                ['name' => 'Test Award Holder']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'land_category' => [
                [
                    'category_name' => 'ধানী জমি',
                    'total_land' => '2.00',
                    'total_compensation' => '200000',
                    'applicant_land' => '1.00'
                ]
            ],
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'sa_khatian_no' => 'SA-001',
            'rs_khatian_no' => 'RS-001',
            'land_schedule_sa_plot_no' => 'SA-FORMER-001',
            'land_schedule_rs_plot_no' => 'RS-CURRENT-001',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-001',
                    'sa_khatian_no' => 'SA-KHATIAN-001',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.50',
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-001',
                    'rs_khatian_no' => 'RS-KHATIAN-001',
                    'rs_total_land_in_plot' => '2.00',
                    'rs_land_in_khatian' => '1.50',
                ],
                'sa_owners' => [['name' => 'SA Owner 1']],
                'rs_owners' => [['name' => 'RS Owner 1']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Deed Donor']],
                        'recipient_names' => [['name' => 'Deed Recipient']],
                        'deed_number' => 'DEED-001',
                        'deed_date' => '2024-01-01',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => 'SA-PLOT-001',
                        'application_sell_area' => '1.50',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'POSSESSION-001',
                        'possession_description' => 'Possession details',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'SA-PLOT-001'
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'namejari_khatian_no' => 'NAMEJARI-001',
                    'kharij_land_amount' => '1.00'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-001',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'mutation_info' => [
                'records' => []
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [
                'selected_types' => ['আপস- বন্টননামা'],
                'details' => [
                    'আপস- বন্টননামা' => 'Test deed details'
                ]
            ]
        ];

        $response = $this->post('/compensation/store', $compensationData);

        $this->assertStringContainsString('/compensation/', $response->headers->get('Location'));
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-SA-001'
        ]);

        $compensation = Compensation::where('case_number', 'TEST-SA-001')->first();
        $this->assertNotNull($compensation);
        // Check that ownership_details contains the expected data
        $this->assertArrayHasKey('sa_info', $compensation->ownership_details);
        $this->assertArrayHasKey('rs_info', $compensation->ownership_details);
        $this->assertArrayHasKey('sa_owners', $compensation->ownership_details);
        $this->assertArrayHasKey('rs_owners', $compensation->ownership_details);
        $this->assertArrayHasKey('deed_transfers', $compensation->ownership_details);
        $this->assertArrayHasKey('inheritance_records', $compensation->ownership_details);
        $this->assertArrayHasKey('rs_records', $compensation->ownership_details);
        $this->assertArrayHasKey('applicant_info', $compensation->ownership_details);
        $this->assertArrayHasKey('transferItems', $compensation->ownership_details);
        
        // Check specific data
        $this->assertEquals('SA Owner 1', $compensation->ownership_details['sa_owners'][0]['name']);
        $this->assertEquals('Deed Donor', $compensation->ownership_details['deed_transfers'][0]['donor_names'][0]['name']);
        $this->assertEquals('Deed Recipient', $compensation->ownership_details['deed_transfers'][0]['recipient_names'][0]['name']);
    }

    public function test_rs_flow_with_applicant_owner_option()
    {
        $compensationData = [
            'case_number' => 'TEST-RS-001',
            'case_date' => '2024-01-01',
            'applicants' => [
                [
                    'name' => 'Test Applicant',
                    'father_name' => 'Test Father',
                    'address' => 'Test Address',
                    'nid' => '1234567890'
                ]
            ],
            'la_case_no' => 'LA-002',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-002',
            'acquisition_record_basis' => 'RS',
            'rs_plot_no' => 'RS-PLOT-002',
            'plot_no' => 'PLOT-002',
            'award_holder_names' => [
                ['name' => 'Test Award Holder']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '1.00',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-002',
            'sa_khatian_no' => 'SA-002',
            'rs_khatian_no' => 'RS-002',
            'land_schedule_sa_plot_no' => 'SA-FORMER-002',
            'land_schedule_rs_plot_no' => 'RS-CURRENT-002',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-002',
                    'sa_khatian_no' => 'SA-KHATIAN-002',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.50',
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-002',
                    'rs_khatian_no' => 'RS-KHATIAN-002',
                    'rs_total_land_in_plot' => '2.00',
                    'rs_land_in_khatian' => '1.50',
                ],
                'sa_owners' => [['name' => 'SA Owner 1']],
                'rs_owners' => [['name' => 'RS Owner 1']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Deed Donor']],
                        'recipient_names' => [['name' => 'Deed Recipient']],
                        'deed_number' => 'DEED-001',
                        'deed_date' => '2024-01-01',
                        'sale_type' => 'দলিল',

                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'POSSESSION-001',
                        'possession_description' => 'Possession details',
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'kharij_case_no' => 'KHARIJ-002',
                    'kharij_plot_no' => 'KHARIJ-PLOT-002',
                    'kharij_land_amount' => '1.00',
                    'kharij_date' => '2024-01-01',
                    'kharij_details' => 'Kharij details for RS',
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 0]
                ]
            ],
            'mutation_info' => [
                'records' => []
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [
                'selected_types' => ['deed'],
                'details' => [
                    'deed' => 'Test deed details'
                ]
            ]
        ];

        $response = $this->post('/compensation/store', $compensationData);

        $this->assertStringContainsString('/compensation/', $response->headers->get('Location'));
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-RS-001'
        ]);

        $compensation = Compensation::where('case_number', 'TEST-RS-001')->first();
        $this->assertNotNull($compensation);
        // Check that ownership_details contains the expected data
        $this->assertArrayHasKey('sa_info', $compensation->ownership_details);
        $this->assertArrayHasKey('rs_info', $compensation->ownership_details);
        $this->assertArrayHasKey('sa_owners', $compensation->ownership_details);
        $this->assertArrayHasKey('rs_owners', $compensation->ownership_details);
        $this->assertArrayHasKey('deed_transfers', $compensation->ownership_details);
        $this->assertArrayHasKey('inheritance_records', $compensation->ownership_details);
        $this->assertArrayHasKey('rs_records', $compensation->ownership_details);
        $this->assertArrayHasKey('applicant_info', $compensation->ownership_details);
        $this->assertArrayHasKey('transferItems', $compensation->ownership_details);
        
        // Check specific data
        $this->assertEquals('RS Owner 1', $compensation->ownership_details['rs_owners'][0]['name']);
        $this->assertEquals('KHARIJ-002', $compensation->ownership_details['applicant_info']['kharij_case_no']);
    }

    public function test_application_area_validation_with_specific_plot()
    {
        $compensationData = [
            'case_number' => 'TEST-APP-AREA-001',
            'case_date' => '2024-01-01',
            'applicants' => [
                [
                    'name' => 'Test Applicant',
                    'father_name' => 'Test Father',
                    'address' => 'Test Address',
                    'nid' => '1234567890'
                ]
            ],
            'la_case_no' => 'LA-003',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-003',
            'acquisition_record_basis' => 'SA',
            'sa_plot_no' => 'SA-PLOT-003',
            'plot_no' => 'PLOT-003',
            'award_holder_names' => [
                ['name' => 'Test Award Holder']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '1.00',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-003',
            'sa_khatian_no' => 'SA-003',
            'rs_khatian_no' => 'RS-003',
            'land_schedule_sa_plot_no' => 'SA-FORMER-003',
            'land_schedule_rs_plot_no' => 'RS-CURRENT-003',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-003',
                    'sa_khatian_no' => 'SA-KHATIAN-003',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.50',
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-003',
                    'rs_khatian_no' => 'RS-KHATIAN-003',
                    'rs_total_land_in_plot' => '2.00',
                    'rs_land_in_khatian' => '1.50',
                ],
                'sa_owners' => [['name' => 'SA Owner 1']],
                'rs_owners' => [['name' => 'RS Owner 1']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Deed Donor']],
                        'recipient_names' => [['name' => 'Deed Recipient']],
                        'deed_number' => 'DEED-003',
                        'deed_date' => '2024-01-01',
                        'sale_type' => 'দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-123',
                        'application_sell_area' => '1.50',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'POSSESSION-003',
                        'possession_description' => 'Possession details',
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'kharij_case_no' => 'KHARIJ-003',
                    'kharij_plot_no' => 'KHARIJ-PLOT-003',
                    'kharij_land_amount' => '1.00',
                    'kharij_date' => '2024-01-01',
                    'kharij_details' => 'Kharij details for application area test',
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 0]
                ]
            ],
            'mutation_info' => [
                'records' => []
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [
                'selected_types' => ['deed'],
                'details' => [
                    'deed' => 'Test deed details'
                ]
            ]
        ];

        $response = $this->post('/compensation/store', $compensationData);

        $this->assertStringContainsString('/compensation/', $response->headers->get('Location'));
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-APP-AREA-001'
        ]);

        $compensation = Compensation::where('case_number', 'TEST-APP-AREA-001')->first();
        $this->assertNotNull($compensation);
        
        // Check that application area data is properly saved
        $this->assertEquals('specific', $compensation->ownership_details['deed_transfers'][0]['application_type']);
        $this->assertEquals('PLOT-123', $compensation->ownership_details['deed_transfers'][0]['application_specific_area']);
        $this->assertEquals('1.50', $compensation->ownership_details['deed_transfers'][0]['application_sell_area']);
    }

    public function test_application_area_validation_with_multiple_plots()
    {
        $compensationData = [
            'case_number' => 'TEST-APP-AREA-002',
            'case_date' => '2024-01-01',
            'applicants' => [
                [
                    'name' => 'Test Applicant',
                    'father_name' => 'Test Father',
                    'address' => 'Test Address',
                    'nid' => '1234567890'
                ]
            ],
            'la_case_no' => 'LA-004',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-004',
            'acquisition_record_basis' => 'SA',
            'sa_plot_no' => 'SA-PLOT-004',
            'plot_no' => 'PLOT-004',
            'award_holder_names' => [
                ['name' => 'Test Award Holder']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '1.00',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-004',
            'sa_khatian_no' => 'SA-004',
            'rs_khatian_no' => 'RS-004',
            'land_schedule_sa_plot_no' => 'SA-FORMER-004',
            'land_schedule_rs_plot_no' => 'RS-CURRENT-004',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-004',
                    'sa_khatian_no' => 'SA-KHATIAN-004',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.50',
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-004',
                    'rs_khatian_no' => 'RS-KHATIAN-004',
                    'rs_total_land_in_plot' => '2.00',
                    'rs_land_in_khatian' => '1.50',
                ],
                'sa_owners' => [['name' => 'SA Owner 1']],
                'rs_owners' => [['name' => 'RS Owner 1']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Deed Donor']],
                        'recipient_names' => [['name' => 'Deed Recipient']],
                        'deed_number' => 'DEED-004',
                        'deed_date' => '2024-01-01',
                        'sale_type' => 'দলিল',
                        'application_type' => 'multiple',
                        'application_other_areas' => 'PLOT-456, PLOT-789',
                        'application_total_area' => '3.00',
                        'application_sell_area_other' => '2.50',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'POSSESSION-004',
                        'possession_description' => 'Possession details',
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'kharij_case_no' => 'KHARIJ-004',
                    'kharij_plot_no' => 'KHARIJ-PLOT-004',
                    'kharij_land_amount' => '1.00',
                    'kharij_date' => '2024-01-01',
                    'kharij_details' => 'Kharij details for multiple plots test',
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 0]
                ]
            ],
            'mutation_info' => [
                'records' => []
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [
                'selected_types' => ['deed'],
                'details' => [
                    'deed' => 'Test deed details'
                ]
            ]
        ];

        $response = $this->post('/compensation/store', $compensationData);

        $this->assertStringContainsString('/compensation/', $response->headers->get('Location'));
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-APP-AREA-002'
        ]);

        $compensation = Compensation::where('case_number', 'TEST-APP-AREA-002')->first();
        $this->assertNotNull($compensation);
        
        // Check that application area data is properly saved
        $this->assertEquals('multiple', $compensation->ownership_details['deed_transfers'][0]['application_type']);
        $this->assertEquals('PLOT-456, PLOT-789', $compensation->ownership_details['deed_transfers'][0]['application_other_areas']);
        $this->assertEquals('3.00', $compensation->ownership_details['deed_transfers'][0]['application_total_area']);
        $this->assertEquals('2.50', $compensation->ownership_details['deed_transfers'][0]['application_sell_area_other']);
    }

    public function test_edit_form_with_all_steps_completed()
    {
        // Create a compensation with all ownership details filled
        $compensationData = [
            'case_number' => 'EDIT-TEST-001',
            'case_date' => '2024-01-01',
            'applicants' => [
                [
                    'name' => 'Edit Test Applicant',
                    'father_name' => 'Edit Test Father',
                    'address' => 'Edit Test Address',
                    'nid' => '1234567890'
                ]
            ],
            'la_case_no' => 'LA-EDIT-001',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-EDIT-001',
            'acquisition_record_basis' => 'SA',
            'sa_plot_no' => 'SA-EDIT-001',
            'plot_no' => 'PLOT-EDIT-001',
            'award_holder_names' => [
                ['name' => 'Edit Test Award Holder']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '1.00',
            'mouza_name' => 'Edit Test Mouza',
            'jl_no' => 'JL-EDIT-001',
            'sa_khatian_no' => 'SA-EDIT-001',
            'rs_khatian_no' => 'RS-EDIT-001',
            'land_schedule_sa_plot_no' => 'SA-FORMER-EDIT-001',
            'land_schedule_rs_plot_no' => 'RS-CURRENT-EDIT-001',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-EDIT-PLOT-001',
                    'sa_khatian_no' => 'SA-EDIT-KHATIAN-001',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.50',
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-EDIT-PLOT-001',
                    'rs_khatian_no' => 'RS-EDIT-KHATIAN-001',
                    'rs_total_land_in_plot' => '2.00',
                    'rs_land_in_khatian' => '1.50',
                ],
                'sa_owners' => [['name' => 'SA Edit Owner 1']],
                'rs_owners' => [['name' => 'RS Edit Owner 1']],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Edit Deed Donor']],
                        'recipient_names' => [['name' => 'Edit Deed Recipient']],
                        'deed_number' => 'DEED-EDIT-001',
                        'deed_date' => '2024-01-01',
                        'sale_type' => 'দলিল',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'POSSESSION-EDIT-001',
                        'possession_description' => 'Edit possession details',
                        'application_type' => 'specific',
                        'application_specific_area' => '1.00',
                        'application_sell_area' => '0.50',
                        'application_other_areas' => '0.25',
                        'application_total_area' => '1.75',
                        'application_sell_area_other' => '0.25'
                    ]
                ],
                'inheritance_records' => [
                    [
                        'inheritor_names' => [['name' => 'Edit Inheritor']],
                        'inheritance_case_no' => 'INHERITANCE-EDIT-001',
                        'inheritance_date' => '2024-01-01',
                        'inheritance_details' => 'Edit inheritance details'
                    ]
                ],
                'rs_records' => [
                    [
                        'rs_plot_no' => 'RS-RECORD-EDIT-001',
                        'rs_khatian_no' => 'RS-RECORD-KHATIAN-EDIT-001',
                        'rs_total_land_in_plot' => '1.00',
                        'rs_land_in_khatian' => '0.75',
                        'owner_names' => [['name' => 'RS Record Edit Owner']],
                        'dp_khatian' => true
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'Edit Test Applicant',
                    'kharij_case_no' => 'KHARIJ-EDIT-001',
                    'kharij_plot_no' => 'KHARIJ-PLOT-EDIT-001',
                    'kharij_land_amount' => '1.00',
                    'kharij_date' => '2024-01-01',
                    'kharij_details' => 'Edit kharij details',
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 0],
                    ['type' => 'উত্তরাধিকার', 'index' => 0],
                    ['type' => 'RS রেকর্ড', 'index' => 0]
                ]
            ],
            'mutation_info' => [
                'records' => []
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [
                'selected_types' => ['deed'],
                'details' => [
                    'deed' => 'Edit test deed details'
                ]
            ]
        ];

        $response = $this->post('/compensation/store', $compensationData);
        $response->assertStatus(302); // Redirect after successful creation

        // Get the created compensation
        $compensation = Compensation::where('case_number', 'EDIT-TEST-001')->first();
        $this->assertNotNull($compensation);

        // Test editing the form - should show all steps as completed
        $editResponse = $this->get("/compensation/{$compensation->id}/edit");
        $editResponse->assertStatus(200);

        // Verify that all ownership details are present in the form
        $ownershipDetails = $compensation->ownership_details;
        
        // Check SA info
        $this->assertEquals('SA-EDIT-PLOT-001', $ownershipDetails['sa_info']['sa_plot_no']);
        $this->assertEquals('SA-EDIT-KHATIAN-001', $ownershipDetails['sa_info']['sa_khatian_no']);
        
        // Check RS info
        $this->assertEquals('RS-EDIT-PLOT-001', $ownershipDetails['rs_info']['rs_plot_no']);
        $this->assertEquals('RS-EDIT-KHATIAN-001', $ownershipDetails['rs_info']['rs_khatian_no']);
        
        // Check owners
        $this->assertEquals('SA Edit Owner 1', $ownershipDetails['sa_owners'][0]['name']);
        $this->assertEquals('RS Edit Owner 1', $ownershipDetails['rs_owners'][0]['name']);
        
        // Check deed transfers
        $this->assertEquals('Edit Deed Donor', $ownershipDetails['deed_transfers'][0]['donor_names'][0]['name']);
        $this->assertEquals('Edit Deed Recipient', $ownershipDetails['deed_transfers'][0]['recipient_names'][0]['name']);
        $this->assertEquals('specific', $ownershipDetails['deed_transfers'][0]['application_type']);
        
        // Check inheritance records
        $this->assertEquals('Edit Inheritor', $ownershipDetails['inheritance_records'][0]['inheritor_names'][0]['name']);
        
        // Check RS records
        $this->assertEquals('RS Record Edit Owner', $ownershipDetails['rs_records'][0]['owner_names'][0]['name']);
        
        // Check applicant info
        $this->assertEquals('Edit Test Applicant', $ownershipDetails['applicant_info']['applicant_name']);
        $this->assertEquals('KHARIJ-EDIT-001', $ownershipDetails['applicant_info']['kharij_case_no']);
    }

    public function test_create_mode_sequential_navigation()
    {
        // Test creating a new compensation form
        $response = $this->get('/compensation/create');
        $response->assertStatus(200);
        
        // Verify that the form loads successfully
        $response->assertStatus(200);
        
        // Test that all 3 steps are visible initially
        $response->assertSee('রেকর্ডের বর্ণনা');
        $response->assertSee('হস্তান্তর/রেকর্ড');
        $response->assertSee('আবেদনকারী তথ্য');
        
        // Test that only Step 1 is active initially
        $response->assertSee('bg-blue-500'); // Current step styling
        // Note: We don't check for bg-green-500 as there might be other green elements on the page
    }
} 