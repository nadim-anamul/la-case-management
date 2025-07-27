<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Compensation;

class CompensationTaxInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_tax_info_structure_with_english_and_bangla_year()
    {
        $compensationData = [
            'case_number' => 'TEST-001',
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
            'award_serial_no' => 'AWD-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'award_holder_name' => 'Test Award Holder',
            'is_applicant_in_award' => true,
            'total_acquired_land' => '1.00',
            'total_compensation' => '100000',
            'applicant_acquired_land' => '1.00',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'sa_khatian_no' => 'SA-001',
            'rs_khatian_no' => 'RS-001',
            'former_plot_no' => 'FORMER-001',
            'current_plot_no' => 'CURRENT-001',
            'ownership_details' => [
                'sa_info' => [
                    'sa_owners' => [['name' => 'SA Owner 1']],
                    'sa_plot_no' => 'SA-PLOT-001',
                    'previous_owner_name' => 'Previous Owner',
                    'sa_khatian_no' => 'SA-KHATIAN-001',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.50',
                ],
                'rs_info' => [
                    'rs_owners' => [['name' => 'RS Owner 1']],
                    'rs_plot_no' => 'RS-PLOT-001',
                    'rs_previous_owner_name' => 'RS Previous Owner',
                    'rs_khatian_no' => 'RS-KHATIAN-001',
                    'rs_total_land_in_plot' => '2.00',
                    'rs_land_in_khatian' => '1.50',
                ],
                'transfer_info' => [
                    'ownership_type' => '',
                    'deed_transfers' => [],
                    'inheritance_records' => [],
                ],
                'mutation_info' => [
                    'mutation_case_no' => '',
                    'mutation_plot_no' => '',
                    'mutation_land_amount' => '',
                    'mutation_date' => '',
                    'mutation_details' => '',
                ],
                'flow_state' => 'initial',
                'rs_record_disabled' => false,
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
            ],
            'kanungo_opinion' => [
                'ownership_continuity' => 'yes',
                'opinion_details' => 'Test opinion'
            ]
        ];

        $response = $this->post('/compensation/store', $compensationData);

        $response->assertRedirect('/compensations');
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-001'
        ]);

        $compensation = Compensation::where('case_number', 'TEST-001')->first();
        $this->assertNotNull($compensation);
        $this->assertEquals('2024', $compensation->tax_info['english_year']);
        $this->assertEquals('১৪৩১', $compensation->tax_info['bangla_year']);
    }

    public function test_tax_info_validation_rules()
    {
        $response = $this->post('/compensation/store', [
            'case_number' => 'TEST-002',
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
            'award_serial_no' => 'AWD-002',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-002',
            'award_holder_name' => 'Test Award Holder',
            'is_applicant_in_award' => true,
            'total_acquired_land' => '1.00',
            'total_compensation' => '100000',
            'applicant_acquired_land' => '1.00',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-002',
            'sa_khatian_no' => 'SA-002',
            'rs_khatian_no' => 'RS-002',
            'former_plot_no' => 'FORMER-002',
            'current_plot_no' => 'CURRENT-002',
            'ownership_details' => [
                'sa_info' => [
                    'sa_owners' => [['name' => 'SA Owner 1']],
                    'sa_plot_no' => 'SA-PLOT-001',
                    'previous_owner_name' => 'Previous Owner',
                    'sa_khatian_no' => 'SA-KHATIAN-001',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.50',
                ],
                'rs_info' => [
                    'rs_owners' => [['name' => 'RS Owner 1']],
                    'rs_plot_no' => 'RS-PLOT-001',
                    'rs_previous_owner_name' => 'RS Previous Owner',
                    'rs_khatian_no' => 'RS-KHATIAN-001',
                    'rs_total_land_in_plot' => '2.00',
                    'rs_land_in_khatian' => '1.50',
                ],
                'transfer_info' => [
                    'ownership_type' => '',
                    'deed_transfers' => [],
                    'inheritance_records' => [],
                ],
                'mutation_info' => [
                    'mutation_case_no' => '',
                    'mutation_plot_no' => '',
                    'mutation_land_amount' => '',
                    'mutation_date' => '',
                    'mutation_details' => '',
                ],
                'flow_state' => 'initial',
                'rs_record_disabled' => false,
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
            ],
            'kanungo_opinion' => [
                'ownership_continuity' => 'yes',
                'opinion_details' => 'Test opinion'
            ]
        ]);

        $response->assertSessionHasNoErrors();
    }
}
