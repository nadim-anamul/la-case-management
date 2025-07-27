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
                    'ownership_type' => 'deed',
                    'deed_transfers' => [
                        [
                            'donor_name' => 'Deed Donor',
                            'recipient_name' => 'Deed Recipient',
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
                            'mutation_case_no' => 'MUTATION-001',
                            'mutation_plot_no' => 'MUTATION-PLOT-001',
                            'mutation_land_amount' => '1.00',
                        ]
                    ],
                    'inheritance_records' => [],
                ],
                'mutation_info' => [
                    'mutation_case_no' => 'MUTATION-001',
                    'mutation_plot_no' => 'MUTATION-PLOT-001',
                    'mutation_land_amount' => '1.00',
                    'mutation_date' => '2024-01-01',
                    'mutation_details' => 'Mutation details',
                ],
                'flow_state' => 'transfer',
                'rs_record_disabled' => false,
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
            ],
            'kanungo_opinion' => [
                'ownership_continuity' => 'yes',
                'opinion_details' => 'Test opinion'
            ]
        ];

        $response = $this->post('/compensation/store', $compensationData);

        $response->assertRedirect('/compensations');
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-SA-001'
        ]);

        $compensation = Compensation::where('case_number', 'TEST-SA-001')->first();
        $this->assertNotNull($compensation);
        $this->assertEquals('transfer', $compensation->ownership_details['flow_state']);
        $this->assertEquals('deed', $compensation->ownership_details['transfer_info']['ownership_type']);
        $this->assertEquals('SA Owner 1', $compensation->ownership_details['sa_info']['sa_owners'][0]['name']);
        $this->assertEquals('Deed Donor', $compensation->ownership_details['transfer_info']['deed_transfers'][0]['donor_name']);
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
            'award_serial_no' => 'AWD-002',
            'acquisition_record_basis' => 'RS',
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
                    'sa_plot_no' => 'SA-PLOT-002',
                    'previous_owner_name' => 'Previous Owner',
                    'sa_khatian_no' => 'SA-KHATIAN-002',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.50',
                ],
                'rs_info' => [
                    'rs_owners' => [['name' => 'RS Owner 1']],
                    'rs_plot_no' => 'RS-PLOT-002',
                    'rs_previous_owner_name' => 'RS Previous Owner',
                    'rs_khatian_no' => 'RS-KHATIAN-002',
                    'rs_total_land_in_plot' => '2.00',
                    'rs_land_in_khatian' => '1.50',
                ],
                'transfer_info' => [
                    'ownership_type' => '',
                    'deed_transfers' => [],
                    'inheritance_records' => [],
                ],
                'mutation_info' => [
                    'mutation_case_no' => 'MUTATION-002',
                    'mutation_plot_no' => 'MUTATION-PLOT-002',
                    'mutation_land_amount' => '1.00',
                    'mutation_date' => '2024-01-01',
                    'mutation_details' => 'Mutation details for RS',
                ],
                'flow_state' => 'applicant_owner',
                'rs_record_disabled' => false,
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
            ],
            'kanungo_opinion' => [
                'ownership_continuity' => 'yes',
                'opinion_details' => 'Test opinion'
            ]
        ];

        $response = $this->post('/compensation/store', $compensationData);

        $response->assertRedirect('/compensations');
        
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'TEST-RS-001'
        ]);

        $compensation = Compensation::where('case_number', 'TEST-RS-001')->first();
        $this->assertNotNull($compensation);
        $this->assertEquals('applicant_owner', $compensation->ownership_details['flow_state']);
        $this->assertEquals('RS Owner 1', $compensation->ownership_details['rs_info']['rs_owners'][0]['name']);
        $this->assertEquals('MUTATION-002', $compensation->ownership_details['mutation_info']['mutation_case_no']);
    }
} 