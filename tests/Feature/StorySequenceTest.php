<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Compensation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StorySequenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_story_sequence_display_in_preview()
    {
        // Create a compensation record with story sequence
        $compensation = Compensation::create([
            'case_number' => 'TEST-CASE-001',
            'case_date' => '2024-01-15',
            'la_case_no' => 'LA-TEST-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-TEST-123',
            'sa_plot_no' => 'PLOT-TEST-123',
            'applicants' => [
                ['name' => 'Test Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']
            ],
            'award_type' => ['জমি'],
            'award_holder_names' => [
                ['name' => 'Test Applicant']
            ],
            'land_category' => [
                [
                    'category_name' => 'ধানী জমি',
                    'total_land' => '2.50',
                    'total_compensation' => '500000',
                    'applicant_land' => '2.50'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '6',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-TEST-001',
            'land_schedule_sa_plot_no' => 'PLOT-TEST-123',
            'sa_khatian_no' => 'KH-TEST-456',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'PLOT-TEST-123',
                    'sa_khatian_no' => 'KH-TEST-456',
                    'sa_total_land_in_plot' => '3.00',
                    'sa_land_in_khatian' => '2.50'
                ],
                'sa_owners' => [
                    ['name' => 'Test Owner']
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-TEST-001',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ],
                    [
                        'type' => 'ওয়ারিশমূলে হস্তান্তর',
                        'description' => 'পূর্ববর্তী মালিক: Test Previous Owner',
                        'itemType' => 'inheritance',
                        'itemIndex' => 0,
                        'sequenceIndex' => 1
                    ],
                    [
                        'type' => 'আরএস রেকর্ড যোগ',
                        'description' => 'দাগ নম্বর: RS-TEST-789',
                        'itemType' => 'rs',
                        'itemIndex' => 0,
                        'sequenceIndex' => 2
                    ]
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Test Donor']],
                        'recipient_names' => [['name' => 'Test Recipient']],
                        'deed_number' => 'DEED-TEST-001',
                        'deed_date' => '2020-05-15',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-TEST-123',
                        'application_sell_area' => '2.50',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PLOT-TEST-123',
                        'possession_description' => 'Test possession description',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'PLOT-TEST-123',
                        'special_details' => 'Test deed details'
                    ]
                ],
                'inheritance_records' => [
                    [
                        'is_heir_applicant' => 'yes',
                        'previous_owner_name' => 'Test Previous Owner',
                        'death_date' => '2020-12-15',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'Test inheritance details'
                    ]
                ],
                'rs_records' => [
                    [
                        'owner_names' => [['name' => 'Test RS Owner']],
                        'plot_no' => 'RS-TEST-789',
                        'khatian_no' => 'KH-TEST-012',
                        'land_amount' => '3.25'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'kharij_land_amount' => '2.50'
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'tax_info' => [
                'english_year' => '2023-24',
                'bangla_year' => '১৪৩০-৩১',
                'holding_no' => 'HOLD-TEST-001',
                'paid_land_amount' => '2.50'
            ],
            'additional_documents_info' => [
                'selected_types' => ['আপস- বন্টননামা'],
                'details' => [
                    'আপস- বন্টননামা' => 'Test distribution details'
                ]
            ],
            'status' => 'pending'
        ]);

        // Test that the preview page loads with story sequence
        $response = $this->get(route('compensation.preview', $compensation->id));
        
        $response->assertStatus(200);
        $response->assertSee('মালিকানার ধারাবাহিকতার কাহিনী');
        $response->assertSee('দলিলমূলে মালিকানা হস্তান্তর');
        $response->assertSee('ওয়ারিশমূলে হস্তান্তর');
        $response->assertSee('আরএস রেকর্ড যোগ');
        $response->assertSee('দলিল নম্বর: DEED-TEST-001');
        $response->assertSee('পূর্ববর্তী মালিক: Test Previous Owner');
        $response->assertSee('দাগ নম্বর: RS-TEST-789');
    }

    public function test_story_sequence_generation_from_existing_data()
    {
        // Create a compensation record without story sequence but with existing data
        $compensation = Compensation::create([
            'case_number' => 'TEST-CASE-002',
            'case_date' => '2024-01-15',
            'la_case_no' => 'LA-TEST-002',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-TEST-456',
            'sa_plot_no' => 'PLOT-TEST-456',
            'applicants' => [
                ['name' => 'Test Applicant 2', 'father_name' => 'Test Father 2', 'address' => 'Test Address 2', 'nid' => '0987654321']
            ],
            'award_type' => ['জমি'],
            'award_holder_names' => [
                ['name' => 'Test Applicant 2']
            ],
            'land_category' => [
                [
                    'category_name' => 'ধানী জমি',
                    'total_land' => '1.75',
                    'total_compensation' => '350000',
                    'applicant_land' => '1.75'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '6',
            'mouza_name' => 'Test Mouza 2',
            'jl_no' => 'JL-TEST-002',
            'land_schedule_sa_plot_no' => 'PLOT-TEST-456',
            'sa_khatian_no' => 'KH-TEST-789',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'PLOT-TEST-456',
                    'sa_khatian_no' => 'KH-TEST-789',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.75'
                ],
                'sa_owners' => [
                    ['name' => 'Test Owner 2']
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Test Donor 2']],
                        'recipient_names' => [['name' => 'Test Recipient 2']],
                        'deed_number' => 'DEED-TEST-002',
                        'deed_date' => '2020-05-15',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-TEST-456',
                        'application_sell_area' => '1.75',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PLOT-TEST-456',
                        'possession_description' => 'Test possession description 2',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'PLOT-TEST-456',
                        'special_details' => 'Test deed details 2'
                    ]
                ],
                'inheritance_records' => [
                    [
                        'is_heir_applicant' => 'yes',
                        'previous_owner_name' => 'Test Previous Owner 2',
                        'death_date' => '2020-12-15',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'Test inheritance details 2'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant 2',
                    'kharij_land_amount' => '1.75'
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'tax_info' => [
                'english_year' => '2023-24',
                'bangla_year' => '১৪৩০-৩১',
                'holding_no' => 'HOLD-TEST-002',
                'paid_land_amount' => '1.75'
            ],
            'additional_documents_info' => [
                'selected_types' => ['আপস- বন্টননামা'],
                'details' => [
                    'আপস- বন্টননামা' => 'Test distribution details 2'
                ]
            ],
            'status' => 'pending'
        ]);

        // Test that the edit form loads and can generate story sequence
        $response = $this->get(route('compensation.edit', $compensation->id));
        
        $response->assertStatus(200);
        $response->assertSee('মালিকানার ধারাবাহিকতার কাহিনী');
    }

    public function test_story_sequence_data_storage()
    {
        // Test that story sequence data is properly stored in the database
        $storySequence = [
            [
                'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                'description' => 'দলিল নম্বর: DEED-TEST-003',
                'itemType' => 'deed',
                'itemIndex' => 0,
                'sequenceIndex' => 0
            ],
            [
                'type' => 'ওয়ারিশমূলে হস্তান্তর',
                'description' => 'পূর্ববর্তী মালিক: Test Previous Owner 3',
                'itemType' => 'inheritance',
                'itemIndex' => 0,
                'sequenceIndex' => 1
            ]
        ];

        $compensation = Compensation::create([
            'case_number' => 'TEST-CASE-003',
            'case_date' => '2024-01-15',
            'la_case_no' => 'LA-TEST-003',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-TEST-789',
            'sa_plot_no' => 'PLOT-TEST-789',
            'applicants' => [
                ['name' => 'Test Applicant 3', 'father_name' => 'Test Father 3', 'address' => 'Test Address 3', 'nid' => '1122334455']
            ],
            'award_type' => ['জমি'],
            'award_holder_names' => [
                ['name' => 'Test Applicant 3']
            ],
            'land_category' => [
                [
                    'category_name' => 'ধানী জমি',
                    'total_land' => '3.25',
                    'total_compensation' => '650000',
                    'applicant_land' => '3.25'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '6',
            'mouza_name' => 'Test Mouza 3',
            'jl_no' => 'JL-TEST-003',
            'land_schedule_sa_plot_no' => 'PLOT-TEST-789',
            'sa_khatian_no' => 'KH-TEST-012',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'PLOT-TEST-789',
                    'sa_khatian_no' => 'KH-TEST-012',
                    'sa_total_land_in_plot' => '4.00',
                    'sa_land_in_khatian' => '3.25'
                ],
                'sa_owners' => [
                    ['name' => 'Test Owner 3']
                ],
                'storySequence' => $storySequence,
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Test Donor 3']],
                        'recipient_names' => [['name' => 'Test Recipient 3']],
                        'deed_number' => 'DEED-TEST-003',
                        'deed_date' => '2020-05-15',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-TEST-789',
                        'application_sell_area' => '3.25',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PLOT-TEST-789',
                        'possession_description' => 'Test possession description 3',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'PLOT-TEST-789',
                        'special_details' => 'Test deed details 3'
                    ]
                ],
                'inheritance_records' => [
                    [
                        'is_heir_applicant' => 'yes',
                        'previous_owner_name' => 'Test Previous Owner 3',
                        'death_date' => '2020-12-15',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'Test inheritance details 3'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant 3',
                    'kharij_land_amount' => '3.25'
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'tax_info' => [
                'english_year' => '2023-24',
                'bangla_year' => '১৪৩০-৩১',
                'holding_no' => 'HOLD-TEST-003',
                'paid_land_amount' => '3.25'
            ],
            'additional_documents_info' => [
                'selected_types' => ['আপস- বন্টননামা'],
                'details' => [
                    'আপস- বন্টননামা' => 'Test distribution details 3'
                ]
            ],
            'status' => 'pending'
        ]);

        // Verify that the story sequence is stored correctly
        $this->assertDatabaseHas('compensations', [
            'id' => $compensation->id,
        ]);

        $retrievedCompensation = Compensation::find($compensation->id);
        $this->assertArrayHasKey('storySequence', $retrievedCompensation->ownership_details);
        $this->assertCount(2, $retrievedCompensation->ownership_details['storySequence']);
        $this->assertEquals('দলিলমূলে মালিকানা হস্তান্তর', $retrievedCompensation->ownership_details['storySequence'][0]['type']);
        $this->assertEquals('ওয়ারিশমূলে হস্তান্তর', $retrievedCompensation->ownership_details['storySequence'][1]['type']);
    }
}
