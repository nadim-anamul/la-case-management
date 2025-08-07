<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Compensation;

class CompensationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Compensation::truncate();

        // Sample 1: Simple deed transfer story
        Compensation::create([
            'case_number' => 'CASE-001',
            'case_date' => '2024-01-15',
            'la_case_no' => 'LA-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-123',
            'applicants' => [
                ['name' => 'মোঃ আব্দুল রহমান', 'father_name' => 'মোঃ করিম উদ্দিন', 'address' => 'বগুড়া সদর, বগুড়া', 'nid' => '1234567890']
            ],
            'award_type' => ['land'],
            'award_holder_names' => [
                ['name' => 'মোঃ আব্দুল রহমান']
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
            'mouza_name' => 'বগুড়া সদর',
            'jl_no' => 'JL-001',
            'land_schedule_sa_plot_no' => 'SA-PLOT-123',
            'sa_khatian_no' => 'KH-456',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-123',
                    'sa_khatian_no' => 'KH-456',
                    'sa_total_land_in_plot' => '3.00',
                    'sa_land_in_khatian' => '2.50'
                ],
                'sa_owners' => [
                    ['name' => 'মোঃ করিম উদ্দিন']
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
                        'donor_names' => [['name' => 'মোঃ করিম উদ্দিন']],
                        'recipient_names' => [['name' => 'মোঃ আব্দুল রহমান']],
                        'deed_number' => 'DEED-001',
                        'deed_date' => '2020-05-15',
                        'sale_type' => 'বিক্রয়',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-123',
                        'application_sell_area' => '2.50',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'PLOT-123',
                        'special_details' => 'সাধারণ বিক্রয় দলিল'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'মোঃ আব্দুল রহমান',
                    'kharij_case_no' => 'KHARIJ-001',
                    'kharij_plot_no' => 'PLOT-123',
                    'kharij_land_amount' => '2.50',
                    'kharij_date' => '2023-12-01',
                    'kharij_details' => 'আবেদনকারীর অনুকূলে খারিজ সম্পন্ন'
                ]
            ],
            'tax_info' => [
                'english_year' => '2023-24',
                'bangla_year' => '১৪৩০-৩১',
                'holding_no' => 'HOLD-001',
                'paid_land_amount' => '2.50'
            ],
            'additional_documents_info' => [
                'selected_types' => ['distribution'],
                'details' => [
                    'distribution' => 'বণ্টননামা দাখিলকৃত'
                ]
            ],
            'status' => 'pending'
        ]);

        // Sample 2: Complex story with multiple transfers
        Compensation::create([
            'case_number' => 'CASE-002',
            'case_date' => '2024-02-20',
            'la_case_no' => 'LA-002',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-456',
            'applicants' => [
                ['name' => 'মোছাঃ ফাতেমা বেগম', 'father_name' => 'মোঃ সুলতান আহমেদ', 'address' => 'বগুড়া সদর, বগুড়া', 'nid' => '9876543210']
            ],
            'award_type' => ['land'],
            'award_holder_names' => [
                ['name' => 'মোছাঃ ফাতেমা বেগম']
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
            'mouza_name' => 'বগুড়া সদর',
            'jl_no' => 'JL-002',
            'land_schedule_sa_plot_no' => 'SA-PLOT-456',
            'sa_khatian_no' => 'KH-789',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-456',
                    'sa_khatian_no' => 'KH-789',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.75'
                ],
                'sa_owners' => [
                    ['name' => 'মোঃ সুলতান আহমেদ']
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-002',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ],
                    [
                        'type' => 'ওয়ারিশমূলে হস্তান্তর',
                        'description' => 'পূর্ববর্তী মালিক: মোঃ সুলতান আহমেদ',
                        'itemType' => 'inheritance',
                        'itemIndex' => 0,
                        'sequenceIndex' => 1
                    ],
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-003',
                        'itemType' => 'deed',
                        'itemIndex' => 1,
                        'sequenceIndex' => 2
                    ]
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ সুলতান আহমেদ']],
                        'recipient_names' => [['name' => 'মোঃ রহিম উদ্দিন']],
                        'deed_number' => 'DEED-002',
                        'deed_date' => '2018-03-10',
                        'sale_type' => 'বিক্রয়',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-456',
                        'application_sell_area' => '1.00',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'PLOT-456',
                        'special_details' => 'প্রথম বিক্রয় দলিল'
                    ],
                    [
                        'donor_names' => [['name' => 'মোঃ রহিম উদ্দিন']],
                        'recipient_names' => [['name' => 'মোছাঃ ফাতেমা বেগম']],
                        'deed_number' => 'DEED-003',
                        'deed_date' => '2022-07-25',
                        'sale_type' => 'বিক্রয়',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-456',
                        'application_sell_area' => '1.75',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'PLOT-456',
                        'special_details' => 'দ্বিতীয় বিক্রয় দলিল'
                    ]
                ],
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'মোঃ সুলতান আহমেদ',
                        'death_date' => '2020-12-15',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'ওয়ারিশান সনদ দাখিলকৃত'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'মোছাঃ ফাতেমা বেগম',
                    'kharij_case_no' => 'KHARIJ-002',
                    'kharij_plot_no' => 'PLOT-456',
                    'kharij_land_amount' => '1.75',
                    'kharij_date' => '2023-11-15',
                    'kharij_details' => 'আবেদনকারীর অনুকূলে খারিজ সম্পন্ন'
                ]
            ],
            'tax_info' => [
                'english_year' => '2023-24',
                'bangla_year' => '১৪৩০-৩১',
                'holding_no' => 'HOLD-002',
                'paid_land_amount' => '1.75'
            ],
            'additional_documents_info' => [
                'selected_types' => ['distribution', 'no_claim'],
                'details' => [
                    'distribution' => 'বণ্টননামা দাখিলকৃত',
                    'no_claim' => 'না-দাবি সনদ দাখিলকৃত'
                ]
            ],
            'status' => 'pending'
        ]);

        // Sample 3: RS record story
        Compensation::create([
            'case_number' => 'CASE-003',
            'case_date' => '2024-03-10',
            'la_case_no' => 'LA-003',
            'acquisition_record_basis' => 'RS',
            'plot_no' => 'PLOT-789',
            'applicants' => [
                ['name' => 'মোঃ জাহাঙ্গীর আলম', 'father_name' => 'মোঃ নুরুল ইসলাম', 'address' => 'বগুড়া সদর, বগুড়া', 'nid' => '1122334455']
            ],
            'award_type' => ['land'],
            'award_holder_names' => [
                ['name' => 'মোঃ জাহাঙ্গীর আলম']
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
            'mouza_name' => 'বগুড়া সদর',
            'jl_no' => 'JL-003',
            'land_schedule_rs_plot_no' => 'RS-PLOT-789',
            'rs_khatian_no' => 'KH-012',
            'ownership_details' => [
                'rs_info' => [
                    'rs_plot_no' => 'RS-789',
                    'rs_khatian_no' => 'KH-012',
                    'rs_total_land_in_plot' => '4.00',
                    'rs_land_in_khatian' => '3.25',
                    'dp_khatian' => true
                ],
                'rs_owners' => [
                    ['name' => 'মোঃ নুরুল ইসলাম']
                ],
                'storySequence' => [
                    [
                        'type' => 'আরএস রেকর্ড যোগ',
                        'description' => 'দাগ নম্বর: RS-789',
                        'itemType' => 'rs',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ],
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-004',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 1
                    ]
                ],
                'rs_records' => [
                    [
                        'owner_names' => [['name' => 'মোঃ নুরুল ইসলাম']],
                        'plot_no' => 'RS-789',
                        'khatian_no' => 'KH-012',
                        'land_amount' => '3.25',
                        'dp_khatian' => true
                    ]
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ নুরুল ইসলাম']],
                        'recipient_names' => [['name' => 'মোঃ জাহাঙ্গীর আলম']],
                        'deed_number' => 'DEED-004',
                        'deed_date' => '2021-09-20',
                        'sale_type' => 'বিক্রয়',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-789',
                        'application_sell_area' => '3.25',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'PLOT-789',
                        'special_details' => 'RS রেকর্ড ভিত্তিক বিক্রয় দলিল'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'মোঃ জাহাঙ্গীর আলম',
                    'kharij_case_no' => 'KHARIJ-003',
                    'kharij_plot_no' => 'PLOT-789',
                    'kharij_land_amount' => '3.25',
                    'kharij_date' => '2023-10-20',
                    'kharij_details' => 'আবেদনকারীর অনুকূলে খারিজ সম্পন্ন'
                ]
            ],
            'tax_info' => [
                'english_year' => '2023-24',
                'bangla_year' => '১৪৩০-৩১',
                'holding_no' => 'HOLD-003',
                'paid_land_amount' => '3.25'
            ],
            'additional_documents_info' => [
                'selected_types' => ['distribution'],
                'details' => [
                    'distribution' => 'বণ্টননামা দাখিলকৃত'
                ]
            ],
            'status' => 'pending'
        ]);

        // Sample 4: Mixed story with inheritance and RS
        Compensation::create([
            'case_number' => 'CASE-004',
            'case_date' => '2024-04-05',
            'la_case_no' => 'LA-004',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-101',
            'applicants' => [
                ['name' => 'মোঃ সাকিব আহমেদ', 'father_name' => 'মোঃ রফিকুল ইসলাম', 'address' => 'বগুড়া সদর, বগুড়া', 'nid' => '5544332211']
            ],
            'award_type' => ['land'],
            'award_holder_names' => [
                ['name' => 'মোঃ সাকিব আহমেদ']
            ],
            'land_category' => [
                [
                    'category_name' => 'ধানী জমি',
                    'total_land' => '1.50',
                    'total_compensation' => '300000',
                    'applicant_land' => '1.50'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '6',
            'mouza_name' => 'বগুড়া সদর',
            'jl_no' => 'JL-004',
            'land_schedule_sa_plot_no' => 'SA-PLOT-101',
            'sa_khatian_no' => 'KH-345',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-101',
                    'sa_khatian_no' => 'KH-345',
                    'sa_total_land_in_plot' => '2.00',
                    'sa_land_in_khatian' => '1.50'
                ],
                'sa_owners' => [
                    ['name' => 'মোঃ রফিকুল ইসলাম']
                ],
                'storySequence' => [
                    [
                        'type' => 'ওয়ারিশমূলে হস্তান্তর',
                        'description' => 'পূর্ববর্তী মালিক: মোঃ রফিকুল ইসলাম',
                        'itemType' => 'inheritance',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ],
                    [
                        'type' => 'আরএস রেকর্ড যোগ',
                        'description' => 'দাগ নম্বর: RS-101',
                        'itemType' => 'rs',
                        'itemIndex' => 0,
                        'sequenceIndex' => 1
                    ],
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-005',
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 2
                    ]
                ],
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'মোঃ রফিকুল ইসলাম',
                        'death_date' => '2021-06-10',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'ওয়ারিশান সনদ দাখিলকৃত'
                    ]
                ],
                'rs_records' => [
                    [
                        'owner_names' => [['name' => 'মোঃ সাকিব আহমেদ']],
                        'plot_no' => 'RS-101',
                        'khatian_no' => 'KH-345',
                        'land_amount' => '1.50',
                        'dp_khatian' => false
                    ]
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'মোঃ সাকিব আহমেদ']],
                        'recipient_names' => [['name' => 'মোঃ সাকিব আহমেদ']],
                        'deed_number' => 'DEED-005',
                        'deed_date' => '2022-12-01',
                        'sale_type' => 'বিক্রয়',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-101',
                        'application_sell_area' => '1.50',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'PLOT-101',
                        'special_details' => 'ওয়ারিশান ভিত্তিক বিক্রয় দলিল'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'মোঃ সাকিব আহমেদ',
                    'kharij_case_no' => 'KHARIJ-004',
                    'kharij_plot_no' => 'PLOT-101',
                    'kharij_land_amount' => '1.50',
                    'kharij_date' => '2023-09-10',
                    'kharij_details' => 'আবেদনকারীর অনুকূলে খারিজ সম্পন্ন'
                ]
            ],
            'tax_info' => [
                'english_year' => '2023-24',
                'bangla_year' => '১৪৩০-৩১',
                'holding_no' => 'HOLD-004',
                'paid_land_amount' => '1.50'
            ],
            'additional_documents_info' => [
                'selected_types' => ['distribution', 'no_claim'],
                'details' => [
                    'distribution' => 'বণ্টননামা দাখিলকৃত',
                    'no_claim' => 'না-দাবি সনদ দাখিলকৃত'
                ]
            ],
            'status' => 'pending'
        ]);

        $this->command->info('Compensation records with story sequences seeded successfully!');
    }
} 