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
            'award_type' => ['type1', 'type2'],
            'award_serial_no' => 'AWD-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'award_holder_name' => 'Test Holder',
            'objector_details' => 'Test objections',
            'is_applicant_in_award' => true,
            'total_acquired_land' => '10 acres',
            'total_compensation' => '100000',
            'applicant_acquired_land' => '5 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'sa_khatian_no' => 'SA-KH-001',
            'former_plot_no' => 'FP-001',
            'rs_khatian_no' => 'RS-KH-001',
            'current_plot_no' => 'CP-001',
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
                        'donor_name' => 'Donor 1',
                        'recipient_name' => 'Recipient 1',
                        'deed_number' => 'DEED-001',
                        'deed_date' => '2024-01-01',
                        'sale_type' => 'Specific Plot',
                        'plot_no' => 'PLOT-001',
                        'sold_land_amount' => '2 acres',
                        'total_sotangsho' => '50%',
                        'total_shotok' => '25%',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PP-001',
                        'possession_description' => 'Test possession'
                    ]
                ],
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'Previous Owner',
                        'death_date' => '2023-01-01',
                        'inheritance_type' => 'Direct',
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

        $response->assertRedirect('/compensations');
        
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
            'award_type' => ['type1'],
            'award_serial_no' => 'AWD-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'award_holder_name' => 'Test Holder',
            'objector_details' => 'Test objections',
            'is_applicant_in_award' => true,
            'total_acquired_land' => '10 acres',
            'total_compensation' => '100000',
            'applicant_acquired_land' => '5 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'sa_khatian_no' => 'SA-KH-001',
            'former_plot_no' => 'FP-001',
            'rs_khatian_no' => 'RS-KH-001',
            'current_plot_no' => 'CP-001',
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

        $response->assertRedirect('/compensations');
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-002'
        ]);
    }
} 