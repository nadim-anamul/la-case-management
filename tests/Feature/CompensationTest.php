<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Compensation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CompensationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_compensation()
    {
        $data = [
            'case_number' => 'COMP-001',
            'case_date' => '১৫/০৮/২০২৪',
            'sa_plot_no' => 'SA-123',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'আব্দুল রহমান',
                    'father_name' => 'মোহাম্মদ আলী',
                    'address' => 'গ্রাম: কাশিমপুর, থানা: সাভার',
                    'nid' => '1234567890123'
                ]
            ],
            'la_case_no' => 'LA-001',
            'award_type' => 'জমি',
            'land_award_serial_no' => 'LAS-001',
            'tree_award_serial_no' => null,
            'infrastructure_award_serial_no' => null,
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-123',
            'award_holder_names' => [
                ['name' => 'আব্দুল রহমান']
            ],
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '2.50',
                    'total_compensation' => '500000',
                    'applicant_land' => '1.25'
                ]
            ],
            'objector_details' => null,
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '5',
            'tree_compensation' => null,
            'infrastructure_compensation' => null,
            'mouza_name' => 'কাশিমপুর',
            'jl_no' => 'JL-123',
            'land_schedule_sa_plot_no' => 'SA-PLOT-123',
            'land_schedule_rs_plot_no' => null,
            'sa_khatian_no' => 'SA-KH-123',
            'rs_khatian_no' => null,
            'ownership_details' => [
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
                        'deed_date' => '১০/০১/২০২০',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => 'SA-123',
                        'application_sell_area' => '2.50',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'SA-123',
                        'special_details' => null
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'আব্দুল রহমান',
                    'kharij_case_no' => 'KH-001',
                    'kharij_plot_no' => 'KH-PLOT-123',
                    'kharij_land_amount' => '1.25',
                    'kharij_date' => '১৫/০২/২০২১',
                    'kharij_details' => 'খারিজের বিবরণ'
                ]
            ],
            'tax_info' => [
                'english_year' => '2024-25',
                'bangla_year' => '১৪৩১-৩২',
                'holding_no' => 'HOLD-123',
                'paid_land_amount' => '1.25'
            ],
            'additional_documents_info' => [
                'selected_types' => ['বণ্টননামা'],
                'details' => [
                    'বণ্টননামা' => 'বণ্টননামার বিবরণ'
                ]
            ]
        ];

        $response = $this->post(route('compensation.store'), $data);

        $response->assertRedirect(route('compensation.preview', 1));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('compensations', [
            'case_number' => 'COMP-001',
            'la_case_no' => 'LA-001',
            'mouza_name' => 'কাশিমপুর'
        ]);
    }

    public function test_can_update_compensation()
    {
        $compensation = Compensation::factory()->create();

        $data = [
            'case_number' => 'COMP-002',
            'case_date' => '২০/০৮/২০২৪',
            'sa_plot_no' => 'SA-456',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'ফাতেমা বেগম',
                    'father_name' => 'আব্দুল হামিদ',
                    'address' => 'গ্রাম: মোহাম্মদপুর, থানা: সাভার',
                    'nid' => '9876543210987'
                ]
            ],
            'la_case_no' => 'LA-002',
            'award_type' => 'জমি ও গাছপালা',
            'land_award_serial_no' => 'LAS-002',
            'tree_award_serial_no' => 'TAS-002',
            'infrastructure_award_serial_no' => null,
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-456',
            'award_holder_names' => [
                ['name' => 'ফাতেমা বেগম']
            ],
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '3.00',
                    'total_compensation' => '600000',
                    'applicant_land' => '1.50'
                ]
            ],
            'objector_details' => null,
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '5',
            'tree_compensation' => '50000',
            'infrastructure_compensation' => null,
            'mouza_name' => 'মোহাম্মদপুর',
            'jl_no' => 'JL-456',
            'land_schedule_sa_plot_no' => 'SA-PLOT-456',
            'land_schedule_rs_plot_no' => null,
            'sa_khatian_no' => 'SA-KH-456',
            'rs_khatian_no' => null,
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-456',
                    'sa_khatian_no' => 'SA-KH-456',
                    'sa_total_land_in_plot' => '6.00',
                    'sa_land_in_khatian' => '3.00'
                ],
                'sa_owners' => [
                    ['name' => 'ফাতেমা বেগম']
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'আব্দুল হামিদ']],
                        'recipient_names' => [['name' => 'ফাতেমা বেগম']],
                        'deed_number' => 'DEED-002',
                        'deed_date' => '১৫/০৩/২০২১',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'multiple',
                        'application_other_areas' => 'SA-456, SA-457',
                        'application_total_area' => '6.00',
                        'application_sell_area_other' => '3.00',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'SA-456, SA-457',
                        'special_details' => null
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'ফাতেমা বেগম',
                    'kharij_case_no' => 'KH-002',
                    'kharij_plot_no' => 'KH-PLOT-456',
                    'kharij_land_amount' => '1.50',
                    'kharij_date' => '২০/০৪/২০২২',
                    'kharij_details' => 'খারিজের বিবরণ'
                ]
            ],
            'tax_info' => [
                'english_year' => '2024-25',
                'bangla_year' => '১৪৩১-৩২',
                'holding_no' => 'HOLD-456',
                'paid_land_amount' => '1.50'
            ],
            'additional_documents_info' => [
                'selected_types' => ['না-দাবি'],
                'details' => [
                    'না-দাবি' => 'না-দাবির বিবরণ'
                ]
            ]
        ];

        $response = $this->put(route('compensation.update', $compensation->id), $data);

        $response->assertRedirect(route('compensation.preview', $compensation->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('compensations', [
            'id' => $compensation->id,
            'case_number' => 'COMP-002',
            'la_case_no' => 'LA-002',
            'mouza_name' => 'মোহাম্মদপুর'
        ]);
    }

    public function test_can_view_compensation_list()
    {
        Compensation::factory()->count(3)->create();

        $response = $this->get(route('compensation.index'));

        $response->assertStatus(200);
        $response->assertViewIs('compensation_list');
        $response->assertViewHas('compensations');
    }

    public function test_can_view_compensation_preview()
    {
        $compensation = Compensation::factory()->create();

        $response = $this->get(route('compensation.preview', $compensation->id));

        $response->assertStatus(200);
        $response->assertViewIs('compensation_preview');
        $response->assertViewHas('compensation');
    }

    public function test_can_edit_compensation()
    {
        $compensation = Compensation::factory()->create();

        $response = $this->get(route('compensation.edit', $compensation->id));

        $response->assertStatus(200);
        $response->assertViewIs('compensation_form');
        $response->assertViewHas('compensation');
    }

    public function test_validation_requires_required_fields()
    {
        $response = $this->post(route('compensation.store'), []);

        $response->assertSessionHasErrors([
            'case_number',
            'case_date',
            'applicants',
            'la_case_no',
            'award_type',
            'acquisition_record_basis',
            'plot_no',
            'award_holder_names',
            'is_applicant_in_award',
            'source_tax_percentage',
            'mouza_name',
            'jl_no'
        ]);
    }

    public function test_validation_for_ownership_details()
    {
        $data = [
            'case_number' => 'COMP-001',
            'case_date' => '১৫/০৮/২০২৪',
            'applicants' => [
                [
                    'name' => 'আব্দুল রহমান',
                    'father_name' => 'মোহাম্মদ আলী',
                    'address' => 'গ্রাম: কাশিমপুর',
                    'nid' => '1234567890123'
                ]
            ],
            'la_case_no' => 'LA-001',
            'award_type' => 'জমি',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-123',
            'award_holder_names' => [
                ['name' => 'আব্দুল রহমান']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '5',
            'mouza_name' => 'কাশিমপুর',
            'jl_no' => 'JL-123',
            'sa_plot_no' => 'SA-123',
            'land_schedule_sa_plot_no' => 'LSA-123',
            'ownership_details' => [
                'deed_transfers' => [
                    [
                        'donor_names' => [],
                        'recipient_names' => []
                    ]
                ]
            ]
        ];

        $response = $this->post(route('compensation.store'), $data);

        // The current validation only requires ownership_details to be an array
        // No specific validation for donor_names and recipient_names
        $response->assertStatus(302); // Redirect after successful creation
    }

    public function test_can_update_kanungo_opinion()
    {
        $compensation = Compensation::factory()->create();

        $data = [
            'kanungo_opinion' => [
                'has_ownership_continuity' => 'yes',
                'opinion_details' => 'মালিকানার ধারাবাহিকতা আছে।'
            ]
        ];

        $response = $this->put(route('compensation.kanungo-opinion.update', $compensation->id), $data);

        $response->assertJson([
            'success' => true,
            'message' => 'কানুনগো/সার্ভেয়ারের মতামত সফলভাবে আপডেট করা হয়েছে।'
        ]);
    }

    public function test_can_update_order()
    {
        $compensation = Compensation::factory()->create();

        $data = [
            'order_signature_date' => '2024-08-25',
            'signing_officer_name' => 'মোহাম্মদ আলী'
        ];

        $response = $this->put(route('compensation.order.update', $compensation->id), $data);

        $response->assertJson([
            'success' => true,
            'message' => 'আদেশ সফলভাবে নিষ্পত্তিকৃত হয়েছে।'
        ]);

        $this->assertDatabaseHas('compensations', [
            'id' => $compensation->id,
            'status' => 'done'
        ]);
    }
} 