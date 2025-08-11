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
            'case_date' => '2024-01-15',
            'sa_plot_no' => 'SA-001',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'Test Applicant',
                    'father_name' => 'Test Father',
                    'address' => 'Test Address',
                    'nid' => '1234567890',
                    'mobile' => '01712345678'
                ]
            ],
            'la_case_no' => 'LA-001',
            'award_type' => ['গাছপালা/ফসল'],
            'land_award_serial_no' => 'LAS-001',
            'tree_award_serial_no' => 'TAS-001',
            'infrastructure_award_serial_no' => null,
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'SA-001',
            'award_holder_names' => [
                [
                    'name' => 'Test Award Holder',
                    'father_name' => 'Test Father',
                    'address' => 'Test Address'
                ]
            ],
            'objector_details' => null,
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '5.0',
            'tree_compensation' => '50000',
            'infrastructure_compensation' => null,
            'district' => 'বগুড়া',
            'upazila' => 'শিবগঞ্জ',
            'mouza_name' => 'Test Mouza',
            'jl_no' => '001',
            'sa_khatian_no' => '001',
            'land_schedule_sa_plot_no' => 'SA-001',
            'land_schedule_rs_plot_no' => null,
            'rs_khatian_no' => null,
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '1.00',
                    'total_compensation' => '100000',
                    'applicant_land' => '1.00'
                ]
            ],
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-001',
                    'sa_khatian_no' => '001',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.00'
                ],
                'sa_owners' => [['name' => 'Test Award Holder']],
                'deed_transfers' => [],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'kharij_land_amount' => '1.00'
                ],
                'storySequence' => [],
                'currentStep' => 'applicant',
                'completedSteps' => ['info'],
                'rs_record_disabled' => false
            ],
            'mutation_info' => [],
            'tax_info' => [
                'holding_no' => 'HOLD-001',
                'paid_land_amount' => '1.00',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'additional_documents_info' => [],
            'kanungo_opinion' => []
        ];

        $response = $this->post(route('compensation.store'), $data);

        $response->assertRedirect(route('compensation.preview', 1));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('compensations', [
            'case_number' => 'COMP-001',
            'la_case_no' => 'LA-001',
            'mouza_name' => 'Test Mouza'
        ]);
    }

    public function test_can_update_compensation()
    {
        $compensation = Compensation::factory()->create();

        $data = [
            'case_number' => 'COMP-002',
            'case_date' => '2024-01-16',
            'sa_plot_no' => 'SA-456',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'ফাতেমা বেগম',
                    'father_name' => 'আব্দুল হামিদ',
                    'address' => 'গ্রাম: মোহাম্মদপুর, থানা: সাভার',
                    'nid' => '9876543210987',
                    'mobile' => '01712345679'
                ]
            ],
            'la_case_no' => 'LA-002',
            'award_type' => ['গাছপালা/ফসল'],
            'land_award_serial_no' => 'LAS-002',
            'tree_award_serial_no' => 'TAS-002',
            'infrastructure_award_serial_no' => null,
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-456',
            'award_holder_names' => [
                [
                    'name' => 'ফাতেমা বেগম',
                    'father_name' => 'আব্দুল হামিদ',
                    'address' => 'গ্রাম: মোহাম্মদপুর, থানা: সাভার'
                ]
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
            'source_tax_percentage' => '5.0',
            'tree_compensation' => '50000',
            'infrastructure_compensation' => null,
            'district' => 'বগুড়া',
            'upazila' => 'শিবগঞ্জ',
            'mouza_name' => 'মোহাম্মদপুর',
            'jl_no' => 'JL-456',
            'sa_khatian_no' => 'SA-KH-456',
            'land_schedule_sa_plot_no' => 'SA-PLOT-456',
            'land_schedule_rs_plot_no' => null,
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
                        'deed_date' => '2021-03-20',
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
                    'kharij_date' => '2022-04-20',
                    'kharij_details' => 'খারিজের বিবরণ'
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-002',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
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
            'case_date' => '2024-01-15',
            'sa_plot_no' => 'SA-123',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'আব্দুল রহমান',
                    'father_name' => 'মোহাম্মদ আলী',
                    'address' => 'গ্রাম: কাশিমপুর, থানা: সাভার',
                    'nid' => '1234567890123',
                    'mobile' => '01712345678'
                ]
            ],
            'la_case_no' => 'LA-001',
            'award_type' => ['জমি'],
            'land_award_serial_no' => 'LAS-001', // Added missing required field
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-123',
            'award_holder_names' => [
                [
                    'name' => 'আব্দুল রহমান',
                    'father_name' => 'মোহাম্মদ আলী', // Added missing required field
                    'address' => 'গ্রাম: কাশিমপুর, থানা: সাভার' // Added missing required field
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '2.50',
                    'total_compensation' => '500000',
                    'applicant_land' => '1.25'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '5',
            'district' => 'ঢাকা',
            'upazila' => 'সাভার',
            'mouza_name' => 'কাশিমপুর',
            'jl_no' => 'JL-123',
            'land_schedule_sa_plot_no' => 'SA-PLOT-123',
            'sa_khatian_no' => 'SA-KH-123',
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
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-001',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ]
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
                ],
                'inheritance_records' => [], // Added missing field
                'rs_records' => [], // Added missing field
                'currentStep' => 'applicant', // Added missing field
                'completedSteps' => ['info'], // Added missing field
                'rs_record_disabled' => false // Added missing field
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

        $response->assertRedirect();
        $this->assertDatabaseHas('compensations', [
            'case_number' => 'COMP-001'
        ]);

        // Verify that the story sequence was saved
        $compensation = Compensation::where('case_number', 'COMP-001')->first();
        $this->assertNotNull($compensation);
        $this->assertNotNull($compensation->ownership_details, 'ownership_details should not be null');
        $this->assertArrayHasKey('storySequence', $compensation->ownership_details);
        $this->assertCount(1, $compensation->ownership_details['storySequence']);
        $this->assertEquals('দলিলমূলে মালিকানা হস্তান্তর', $compensation->ownership_details['storySequence'][0]['type']);
    }

    public function test_story_sequence_is_preserved_on_edit()
    {
        // Create a compensation with story sequence
        $compensation = Compensation::create([
            'case_number' => 'COMP-002',
            'case_date' => '১৫/০৮/২০২৪',
            'applicants' => [
                [
                    'name' => 'আব্দুল রহমান',
                    'father_name' => 'মোহাম্মদ আলী',
                    'address' => 'গ্রাম: কাশিমপুর, থানা: সাভার',
                    'nid' => '1234567890123'
                ]
            ],
            'la_case_no' => 'LA-002',
            'award_type' => ['জমি'],
            'land_award_serial_no' => 'LAS-002', // Added missing required field
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-123',
            'award_holder_names' => [
                [
                    'name' => 'আব্দুল রহমান',
                    'father_name' => 'মোহাম্মদ আলী', // Added missing required field
                    'address' => 'গ্রাম: কাশিমপুর, থানা: সাভার' // Added missing required field
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '2.50',
                    'total_compensation' => '500000',
                    'applicant_land' => '1.25'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '5',
            'mouza_name' => 'কাশিমপুর',
            'jl_no' => 'JL-123',
            'land_schedule_sa_plot_no' => 'SA-PLOT-123',
            'sa_khatian_no' => 'SA-KH-123',
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
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-001',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ],
                    [
                        'type' => 'ওয়ারিশমূলে হস্তান্তর',
                        'description' => 'পূর্ববর্তী মালিক: মোহাম্মদ আলী',
                        'itemType' => 'inheritance',
                        'itemIndex' => 0,
                        'sequenceIndex' => 1
                    ]
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
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'মোহাম্মদ আলী',
                        'death_date' => '১৫/০১/২০২০',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'ওয়ারিশান সনদের বিবরণ'
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
        ]);

        // Update the compensation
        $updateData = [
            'case_number' => 'COMP-001-UPDATED',
            'case_date' => '2024-01-16',
            'sa_plot_no' => 'SA-001-UPDATED',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'Test Applicant Updated',
                    'father_name' => 'Test Father Updated',
                    'address' => 'Test Address Updated',
                    'nid' => '1234567890',
                    'mobile' => '01712345678'
                ]
            ],
            'la_case_no' => 'LA-001-UPDATED',
            'award_type' => ['গাছপালা/ফসল'],
            'land_award_serial_no' => 'LAS-001-UPDATED',
            'tree_award_serial_no' => 'TAS-001-UPDATED',
            'infrastructure_award_serial_no' => null,
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'SA-001-UPDATED',
            'award_holder_names' => [
                [
                    'name' => 'Test Award Holder Updated',
                    'father_name' => 'Test Father Updated',
                    'address' => 'Test Address Updated'
                ]
            ],
            'objector_details' => 'Updated objector details',
            'is_applicant_in_award' => false,
            'source_tax_percentage' => '6.0',
            'tree_compensation' => '60000',
            'infrastructure_compensation' => null,
            'district' => 'বগুড়া',
            'upazila' => 'দুপচাঁচিয়া',
            'mouza_name' => 'Test Mouza Updated',
            'jl_no' => '001-UPDATED',
            'sa_khatian_no' => '001-UPDATED',
            'land_schedule_sa_plot_no' => 'SA-001-UPDATED',
            'land_schedule_rs_plot_no' => null,
            'rs_khatian_no' => null,
            'land_category' => [
                [
                    'category_name' => 'ধানী জমি',
                    'total_land' => '2.00',
                    'total_compensation' => '200000',
                    'applicant_land' => '2.00'
                ]
            ],
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-001-UPDATED',
                    'sa_khatian_no' => '001-UPDATED',
                    'sa_total_land_in_plot' => '5.00',
                    'sa_land_in_khatian' => '2.50'
                ],
                'sa_owners' => [
                    ['name' => 'Test Award Holder Updated']
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Test Father Updated']],
                        'recipient_names' => [['name' => 'Test Award Holder Updated']],
                        'deed_number' => 'DEED-001-UPDATED',
                        'deed_date' => '2020-01-10',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => 'SA-001-UPDATED',
                        'application_sell_area' => '2.50',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'SA-001-UPDATED',
                        'possession_description' => 'জমিটি দীর্ঘদিন যাবৎ চাষাবাদের কাজে ব্যবহৃত',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'SA-001-UPDATED'
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [],
                'applicant_info' => [
                    'applicant_name' => 'Test Award Holder Updated',
                    'kharij_land_amount' => '2.50'
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-001-UPDATED',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'tax_info' => [
                'english_year' => '2024-25',
                'bangla_year' => '১৪৩১-৩২',
                'holding_no' => 'HOLD-001-UPDATED',
                'paid_land_amount' => '2.50'
            ],
            'additional_documents_info' => [
                'selected_types' => ['আপস- বন্টননামা'],
                'details' => [
                    'আপস- বন্টননামা' => 'বণ্টননামার বিবরণ আপডেট করা হয়েছে'
                ]
            ]
        ];

        $response = $this->put(route('compensation.update', $compensation->id), $updateData);

        $response->assertRedirect();
        
        // Verify that the story sequence was preserved and updated
        $updatedCompensation = Compensation::find($compensation->id);
        $this->assertNotNull($updatedCompensation);
        $this->assertArrayHasKey('storySequence', $updatedCompensation->ownership_details);
        $this->assertCount(2, $updatedCompensation->ownership_details['storySequence']);
        $this->assertEquals('দলিল নম্বর: DEED-001', $updatedCompensation->ownership_details['storySequence'][0]['description']);
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