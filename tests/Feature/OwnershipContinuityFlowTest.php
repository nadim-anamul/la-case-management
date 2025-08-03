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
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-001',
            'acquisition_record_basis' => 'SA',
            'sa_plot_no' => 'SA-PLOT-001',
            'plot_no' => 'PLOT-001',
            'award_holder_names' => [
                ['name' => 'Test Award Holder']
            ],
            'is_applicant_in_award' => true,
            'total_acquired_land' => '1.00',
            'total_compensation' => '100000',
            'source_tax_percentage' => '5.00',
            'applicant_acquired_land' => '1.00',
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
                        'sale_type' => 'Specific Plot',
                        'plot_no' => 'PLOT-001',
                        'sold_land_amount' => '1.00',
                        'total_sotangsho' => '50',
                        'total_shotok' => '25',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'POSSESSION-001',
                        'possession_description' => 'Possession details',
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'kharij_case_no' => 'KHARIJ-001',
                    'kharij_plot_no' => 'KHARIJ-PLOT-001',
                    'kharij_land_amount' => '1.00',
                    'kharij_date' => '2024-01-01',
                    'kharij_details' => 'Kharij details',
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
            'total_acquired_land' => '1.00',
            'total_compensation' => '100000',
            'source_tax_percentage' => '5.00',
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
                        'sale_type' => 'Specific Plot',
                        'plot_no' => 'PLOT-001',
                        'sold_land_amount' => '1.00',
                        'total_sotangsho' => '50',
                        'total_shotok' => '25',
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
} 