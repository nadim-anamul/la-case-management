<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Compensation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OwnershipDetailsStructureTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_ownership_details_structure_can_be_saved()
    {
        $data = [
            'case_number' => 'TEST-001',
            'case_date' => '2025-01-15',
            'sa_plot_no' => 'SA-123',
            'rs_plot_no' => 'RS-456',
            'applicants' => [
                ['name' => 'Test Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']
            ],
            'la_case_no' => 'LA-001',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'award_holder_names' => [
                ['name' => 'Test Holder']
            ],
            'objector_details' => 'Test objections',
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '5 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'sa_khatian_no' => 'SA-KH-001',
            'land_schedule_sa_plot_no' => 'SA-FP-001',
            'rs_khatian_no' => 'RS-KH-001',
            'land_schedule_rs_plot_no' => 'RS-CP-001',
            'is_applicant_sa_owner' => false,
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-001',
                    'sa_khatian_no' => 'SA-KH-001',
                    'sa_total_land_in_plot' => '5 acres',
                    'sa_land_in_khatian' => '3 acres'
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-001',
                    'rs_khatian_no' => 'RS-KH-001',
                    'rs_total_land_in_plot' => '3 acres',
                    'rs_land_in_khatian' => '2 acres'
                ],
                'sa_owners' => [
                    ['name' => 'SA Owner 1'],
                    ['name' => 'SA Owner 2']
                ],
                'rs_owners' => [
                    ['name' => 'RS Owner 1']
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Donor 1']],
                        'recipient_names' => [['name' => 'Recipient 1']],
                        'deed_number' => 'DEED-001',
                        'deed_date' => '2024-01-01',
                        'sale_type' => 'দলিল',

                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PP-001',
                        'possession_description' => 'Test possession'
                    ]
                ],
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'Previous Owner',
                        'death_date' => '2023-01-01',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'Test heirship info'
                    ]
                ],
                'rs_records' => [
                    [
                        'plot_no' => 'RS-RECORD-001',
                        'khatian_no' => 'RS-RECORD-KH-001',
                        'land_amount' => '1 acre',
                        'owner_name' => 'RS Record Owner'
                    ]
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 0],
                    ['type' => 'ওয়ারিশ', 'index' => 0],
                    ['type' => 'আরএস রেকর্ড', 'index' => 0]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => true,
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'kharij_case_no' => 'KHARIJ-001',
                    'kharij_plot_no' => 'KHARIJ-PLOT-001',
                    'kharij_land_amount' => '2 acres',
                    'kharij_date' => '2024-06-01',
                    'kharij_details' => 'Test kharij details'
                ]
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [
                'selected_types' => ['type1'],
                'details' => ['type1' => 'Test document details']
            ]
        ];

        $response = $this->post('/compensation/store', $data);

        $this->assertStringContainsString('/compensation/', $response->headers->get('Location'));
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-001',
            'acquisition_record_basis' => 'SA'
        ]);

        $compensation = Compensation::where('case_number', 'TEST-001')->first();
        
        // Verify the new structure is saved correctly
        $this->assertArrayHasKey('sa_info', $compensation->ownership_details);
        $this->assertArrayHasKey('rs_info', $compensation->ownership_details);
        $this->assertArrayHasKey('sa_owners', $compensation->ownership_details);
        $this->assertArrayHasKey('rs_owners', $compensation->ownership_details);
        $this->assertArrayHasKey('deed_transfers', $compensation->ownership_details);
        $this->assertArrayHasKey('inheritance_records', $compensation->ownership_details);
        $this->assertArrayHasKey('rs_records', $compensation->ownership_details);
        $this->assertArrayHasKey('transferItems', $compensation->ownership_details);
        $this->assertArrayHasKey('currentStep', $compensation->ownership_details);
        $this->assertArrayHasKey('completedSteps', $compensation->ownership_details);
        $this->assertArrayHasKey('rs_record_disabled', $compensation->ownership_details);
        $this->assertArrayHasKey('applicant_info', $compensation->ownership_details);
    }

    public function test_ownership_details_validation_rules_work_correctly()
    {
        $data = [
            'case_number' => 'TEST-002',
            'case_date' => '2025-01-15',
            'sa_plot_no' => 'SA-123',
            'rs_plot_no' => 'RS-456',
            'applicants' => [
                ['name' => 'Test Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']
            ],
            'la_case_no' => 'LA-001',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'award_holder_names' => [
                ['name' => 'Test Applicant']
            ],
            'objector_details' => 'Test objections',
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '5 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'sa_khatian_no' => 'SA-KH-001',
            'land_schedule_sa_plot_no' => 'SA-FP-001',
            'rs_khatian_no' => 'RS-KH-001',
            'land_schedule_rs_plot_no' => 'RS-CP-001',
            'is_applicant_sa_owner' => false,
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-001',
                    'sa_khatian_no' => 'SA-KH-001'
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-001',
                    'rs_khatian_no' => 'RS-KH-001'
                ],
                'sa_owners' => [
                    ['name' => 'SA Owner 1']
                ],
                'rs_owners' => [
                    ['name' => 'RS Owner 1']
                ],
                'deed_transfers' => [],
                'inheritance_records' => [],
                'rs_records' => [],
                'transferItems' => [],
                'currentStep' => 'info',
                'completedSteps' => ['info'],
                'rs_record_disabled' => false,
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant 2',
                    'kharij_case_no' => 'KHARIJ-002',
                    'kharij_plot_no' => 'KHARIJ-PLOT-002',
                    'kharij_land_amount' => '1 acre',
                    'kharij_date' => '2024-05-01',
                    'kharij_details' => 'Test kharij details 2'
                ]
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [
                'selected_types' => ['type1'],
                'details' => ['type1' => 'Test document details']
            ]
        ];

        $response = $this->post('/compensation/store', $data);

        $this->assertStringContainsString('/compensation/', $response->headers->get('Location'));
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-002'
        ]);
    }

    public function test_ownership_details_with_tax_info_can_be_saved()
    {
        $ownershipDetails = [
            'sa_info' => [
                'sa_plot_no' => 'SA-123',
                'sa_khatian_no' => 'SA-KH-123',
                'sa_total_land_in_plot' => '5.00',
                'sa_land_in_khatian' => '2.50'
            ],
            'sa_owners' => [
                ['name' => 'আব্দুল রহমান']
            ],
            'deed_transfers' => [
                [
                    'donor_names' => [['name' => 'মোহাম্মদ আলী']],
                    'recipient_names' => [['name' => 'আব্দুল রহমান']],
                    'deed_number' => 'DEED-001',
                    'deed_date' => '01/01/2020',
                    'sale_type' => 'বিক্রয়',
                    'application_type' => 'specific',
                    'application_specific_area' => '123',
                    'application_sell_area' => '2.50',
                    'possession_deed' => 'yes',
                    'possession_application' => 'yes',
                    'mentioned_areas' => '123',
                    'special_details' => 'বিশেষ বিবরণ',
                    'tax_info' => 'খাজনার বিবরণ: ২০২০-২০২১ অর্থবছরে ৫০০০ টাকা খাজনা পরিশোধ করা হয়েছে। বর্তমানে কোন বকেয়া খাজনা নেই।'
                ]
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
            'rs_record_disabled' => false,
            'applicant_info' => [
                'applicant_name' => 'আব্দুল রহমান',
                'kharij_case_no' => 'KH-001',
                'kharij_plot_no' => '123',
                'kharij_land_amount' => '2.50',
                'kharij_date' => '01/01/2021',
                'kharij_details' => 'খারিজের বিবরণ'
            ]
        ];

        $compensation = Compensation::create([
            'case_number' => 'CASE-001',
            'case_date' => '2023-01-01',
            'applicants' => [['name' => 'আব্দুল রহমান']],
            'la_case_no' => 'LA-001',
            'award_type' => ['land'],
            'land_award_serial_no' => 'LAS-001',
            'tree_award_serial_no' => 'TAS-001',
            'infrastructure_award_serial_no' => 'IAS-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => '123',
            'award_holder_names' => [['name' => 'আব্দুল রহমান']],
            'objector_details' => null,
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '10%',
            'tree_compensation' => '50000',
            'infrastructure_compensation' => '25000',
            'land_category' => [['category_name' => 'আবাদি', 'total_land' => '5.00', 'total_compensation' => '500000', 'applicant_land' => '2.50']],
            'mouza_name' => 'মৌজা নাম',
            'jl_no' => 'JL-001',
            'sa_khatian_no' => 'SA-KH-123',
            'land_schedule_sa_plot_no' => '123',
            'rs_khatian_no' => null,
            'land_schedule_rs_plot_no' => null,
            'ownership_details' => $ownershipDetails,
            'mutation_info' => null,
            'tax_info' => null,
            'additional_documents_info' => null,
            'kanungo_opinion' => null,
            'order_signature_date' => null,
            'signing_officer_name' => null,
            'status' => 'pending'
        ]);

        $this->assertDatabaseHas('compensations', [
            'id' => $compensation->id,
        ]);

        // Verify that tax_info is saved in deed_transfers
        $savedCompensation = Compensation::find($compensation->id);
        $savedOwnershipDetails = $savedCompensation->ownership_details;
        
        $this->assertArrayHasKey('deed_transfers', $savedOwnershipDetails);
        $this->assertArrayHasKey('tax_info', $savedOwnershipDetails['deed_transfers'][0]);
        $this->assertEquals('খাজনার বিবরণ: ২০২০-২০২১ অর্থবছরে ৫০০০ টাকা খাজনা পরিশোধ করা হয়েছে। বর্তমানে কোন বকেয়া খাজনা নেই।', $savedOwnershipDetails['deed_transfers'][0]['tax_info']);
    }

    public function test_tax_info_field_is_properly_handled_in_form()
    {
        $data = [
            'case_number' => 'TEST-TAX-001',
            'case_date' => '2025-01-15',
            'applicants' => [
                ['name' => 'Test Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']
            ],
            'la_case_no' => 'LA-001',
            'award_type' => 'জমি',
            'land_award_serial_no' => 'LAS-001',
            'tree_award_serial_no' => 'TAS-001',
            'infrastructure_award_serial_no' => 'IAS-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'award_holder_names' => [
                ['name' => 'Test Holder']
            ],
            'objector_details' => null,
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'tree_compensation' => '50000',
            'infrastructure_compensation' => '25000',
            'land_category' => [
                ['category_name' => 'আবাদি', 'total_land' => '5.00', 'total_compensation' => '500000', 'applicant_land' => '2.50']
            ],
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'sa_khatian_no' => 'SA-KH-001',
            'land_schedule_sa_plot_no' => 'SA-FP-001',
            'rs_khatian_no' => null,
            'land_schedule_rs_plot_no' => null,
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-001',
                    'sa_khatian_no' => 'SA-KH-001'
                ],
                'sa_owners' => [
                    ['name' => 'SA Owner 1']
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Donor 1']],
                        'recipient_names' => [['name' => 'Recipient 1']],
                        'deed_number' => 'DEED-001',
                        'deed_date' => '2024-01-01',
                        'sale_type' => 'দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => '123',
                        'application_sell_area' => '2.50',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => '123',
                        'special_details' => 'বিশেষ বিবরণ',
                        'tax_info' => 'খাজনার বিবরণ: ২০২০-২০২১ অর্থবছরে ৫০০০ টাকা খাজনা পরিশোধ করা হয়েছে। বর্তমানে কোন বকেয়া খাজনা নেই।'
                    ]
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
                'rs_record_disabled' => false,
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'kharij_case_no' => 'KHARIJ-001',
                    'kharij_plot_no' => 'KHARIJ-PLOT-001',
                    'kharij_land_amount' => '2 acres',
                    'kharij_date' => '2024-06-01',
                    'kharij_details' => 'Test kharij details'
                ]
            ],
            'mutation_info' => null,
            'tax_info' => null,
            'additional_documents_info' => null,
            'kanungo_opinion' => null,
            'order_signature_date' => null,
            'signing_officer_name' => null,
            'status' => 'pending'
        ];

        $response = $this->post('/compensation/store', $data);
        
        // Debug: Check the response
        if ($response->getStatusCode() !== 302) {
            $this->fail('Response status is not 302. Status: ' . $response->getStatusCode() . ', Content: ' . $response->getContent());
        }

        // Check if there are any validation errors
        if ($response->getStatusCode() === 422) {
            $this->fail('Validation failed: ' . $response->getContent());
        }

        $this->assertStringContainsString('/compensation/', $response->headers->get('Location'));
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-TAX-001'
        ]);

        $compensation = Compensation::where('case_number', 'TEST-TAX-001')->first();
        
        // Verify that tax_info is saved in deed_transfers
        $this->assertNotNull($compensation->ownership_details);
        $this->assertArrayHasKey('deed_transfers', $compensation->ownership_details);
        $this->assertArrayHasKey('tax_info', $compensation->ownership_details['deed_transfers'][0]);
        $this->assertEquals('খাজনার বিবরণ: ২০২০-২০২১ অর্থবছরে ৫০০০ টাকা খাজনা পরিশোধ করা হয়েছে। বর্তমানে কোন বকেয়া খাজনা নেই।', $compensation->ownership_details['deed_transfers'][0]['tax_info']);
    }

    public function test_basic_compensation_form_submission_works()
    {
        $data = [
            'case_number' => 'TEST-BASIC-001',
            'case_date' => '2025-01-15',
            'applicants' => [
                ['name' => 'Test Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']
            ],
            'la_case_no' => 'LA-001',
            'award_type' => 'জমি',
            'land_award_serial_no' => 'LAS-001',
            'tree_award_serial_no' => 'TAS-001',
            'infrastructure_award_serial_no' => 'IAS-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'award_holder_names' => [
                ['name' => 'Test Holder']
            ],
            'objector_details' => null,
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'tree_compensation' => '50000',
            'infrastructure_compensation' => '25000',
            'land_category' => [
                ['category_name' => 'আবাদি', 'total_land' => '5.00', 'total_compensation' => '500000', 'applicant_land' => '2.50']
            ],
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'sa_khatian_no' => 'SA-KH-001',
            'land_schedule_sa_plot_no' => 'SA-FP-001',
            'rs_khatian_no' => null,
            'land_schedule_rs_plot_no' => null,
            'ownership_details' => null,
            'mutation_info' => null,
            'tax_info' => null,
            'additional_documents_info' => null,
            'kanungo_opinion' => null,
            'order_signature_date' => null,
            'signing_officer_name' => null,
            'status' => 'pending'
        ];

        $response = $this->post('/compensation/store', $data);
        
        // Debug: Check if there are validation errors
        if ($response->getStatusCode() === 422) {
            $this->fail('Validation failed: ' . $response->getContent());
        }
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-BASIC-001'
        ]);
    }

    public function test_seeder_generates_proper_data_with_tax_info()
    {
        // Clear existing data and run seeder
        Compensation::truncate();
        $this->artisan('db:seed', ['--class' => 'CompensationSeeder']);
        
        // Check that compensations were created
        $compensations = Compensation::all();
        $this->assertGreaterThan(0, $compensations->count());
        
        // Check that at least one compensation has tax_info in deed_transfers
        $compensationWithTaxInfo = $compensations->first(function($comp) {
            return isset($comp->ownership_details['deed_transfers'][0]['tax_info']) && 
                   !empty($comp->ownership_details['deed_transfers'][0]['tax_info']);
        });
        
        $this->assertNotNull($compensationWithTaxInfo, 'No compensation found with tax_info in deed_transfers');
        $this->assertNotEmpty($compensationWithTaxInfo->ownership_details['deed_transfers'][0]['tax_info']);
        
        // Check that story sequence is generated
        $this->assertArrayHasKey('storySequence', $compensationWithTaxInfo->ownership_details);
        $this->assertGreaterThan(0, count($compensationWithTaxInfo->ownership_details['storySequence']));
        
        // Check that currentStep and completedSteps are set
        $this->assertArrayHasKey('currentStep', $compensationWithTaxInfo->ownership_details);
        $this->assertArrayHasKey('completedSteps', $compensationWithTaxInfo->ownership_details);
    }
} 