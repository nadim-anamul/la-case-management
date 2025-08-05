<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Compensation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if demo data already exists to avoid conflicts
        if (Compensation::where('case_number', 'CASE-2024-001')->exists()) {
            $this->command->info('Demo compensation records already exist. Skipping seeder.');
            return;
        }
        
        // Create demo compensation records
        $this->createDemoCompensations();
    }

    private function createDemoCompensations()
    {
        // Demo Record 1: SA-based compensation
        Compensation::create([
            'case_number' => 'CASE-2024-001',
            'case_date' => '2024-01-15',
            'applicants' => [
                [
                    'name' => 'আব্দুল রহমান',
                    'father_name' => 'মোহাম্মদ আলী',
                    'address' => 'গ্রাম: কাশিমপুর, পোস্ট: কাশিমপুর, জেলা: ঢাকা',
                    'nid' => '1234567890123'
                ],
                [
                    'name' => 'ফাতেমা বেগম',
                    'father_name' => 'আব্দুল হামিদ',
                    'address' => 'গ্রাম: কাশিমপুর, পোস্ট: কাশিমপুর, জেলা: ঢাকা',
                    'nid' => '1234567890124'
                ]
            ],
            'la_case_no' => 'LA-2024-001',
            'land_award_serial_no' => 'LAND-AWD-001',
            'tree_award_serial_no' => 'TREE-AWD-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'sa_plot_no' => 'SA-PLOT-001',
            'rs_plot_no' => null,
            'award_holder_names' => [
                ['name' => 'আব্দুল রহমান'],
                ['name' => 'ফাতেমা বেগম']
            ],
            'objector_details' => 'কোন আপত্তি নেই',
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'tree_compensation' => '75000',
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '2.0',
                    'total_compensation' => '400000',
                    'applicant_land' => '1.0'
                ],
                [
                    'category_name' => 'অনাবাদি জমি',
                    'total_land' => '0.5',
                    'total_compensation' => '100000',
                    'applicant_land' => '0.25'
                ]
            ],
            'mouza_name' => 'কাশিমপুর',
            'jl_no' => 'JL-001',
            'land_schedule_sa_plot_no' => 'SA-OLD-001',
            'land_schedule_rs_plot_no' => 'RS-NEW-001',
            'sa_khatian_no' => 'SA-KH-001',
            'rs_khatian_no' => null,
            'award_type' => 'জমি ও গাছপালা',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-001',
                    'sa_khatian_no' => 'SA-KH-001',
                    'sa_total_land_in_plot' => '5 acres',
                    'sa_land_in_khatian' => '2.5 acres'
                ],
                'rs_info' => [
                    'rs_plot_no' => '',
                    'rs_khatian_no' => '',
                    'rs_total_land_in_plot' => '',
                    'rs_land_in_khatian' => ''
                ],
                'sa_owners' => [
                    ['name' => 'আব্দুল রহমান'],
                    ['name' => 'ফাতেমা বেগম']
                ],
                'rs_owners' => [],
                'deed_transfers' => [
                    [
                        'donor_names' => [ ['name' => 'মোহাম্মদ আলী'] ],
                        'recipient_names' => [ ['name' => 'আব্দুল রহমান'] ],
                        'deed_number' => 'DEED-001',
                        'deed_date' => '2020-01-15',
                        'sale_type' => 'বিক্রয়',
                        'plot_no' => 'PLOT-001',
                        'sold_land_amount' => '1.25 acres',
                        'total_sotangsho' => '2.5',
                        'total_shotok' => '5',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PLOT-001',
                        'possession_description' => 'দখলে আছে',
                        'mutation_case_no' => 'MUT-001',
                        'mutation_plot_no' => 'PLOT-001',
                        'mutation_land_amount' => '1.25 acres'
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [
                    [
                        'plot_no' => 'RS-PLOT-001',
                        'khatian_no' => 'RS-KH-001',
                        'land_amount' => '2.5 acres',
                        'owner_names' => [
                            ['name' => 'আব্দুল রহমান'],
                            ['name' => 'ফাতেমা বেগম']
                        ],
                        'dp_khatian' => true
                    ],
                    [
                        'plot_no' => 'RS-PLOT-001-B',
                        'khatian_no' => 'RS-KH-001-B',
                        'land_amount' => '1.0 acres',
                        'owner_names' => [
                            ['name' => 'মোহাম্মদ আলী']
                        ],
                        'dp_khatian' => false
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'আব্দুল রহমান',
                    'kharij_case_no' => 'KHARIJ-001',
                    'kharij_plot_no' => 'PLOT-001',
                    'kharij_land_amount' => '1.25 acres',
                    'kharij_date' => '2024-01-15',
                    'kharij_details' => 'খারিজ সম্পন্ন হয়েছে'
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 1],
                    ['type' => 'আবেদনকারী', 'index' => 1]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'mutation_info' => [
                'mutation_case_no' => 'MUT-001',
                'mutation_plot_no' => 'PLOT-001',
                'mutation_land_amount' => '1.25 acres',
                'mutation_date' => '2024-01-15',
                'mutation_details' => 'খারিজ সম্পন্ন হয়েছে'
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১',
                'holding_no' => 'HLD-001',
                'paid_land_amount' => '2.5 acres'
            ],
            'additional_documents_info' => [
                'selected_types' => ['আপস- বন্টননামা', 'সরেজমিন তদন্ত'],
                'details' => [
                    'আপস- বন্টননামা' => 'আপসনামা সম্পন্ন হয়েছে',
                    'সরেজমিন তদন্ত' => 'সরেজমিন তদন্ত সম্পন্ন হয়েছে'
                ]
            ],
            'kanungo_opinion' => [
                'has_ownership_continuity' => 'yes',
                'opinion_details' => 'মালিকানার ধারাবাহিকতা আছে'
            ],
            'status' => 'pending',
            'order_signature_date' => null,
            'signing_officer_name' => null
        ]);

        // Demo Record 2: RS-based compensation
        Compensation::create([
            'case_number' => 'CASE-2024-002',
            'case_date' => '2024-02-20',
            'applicants' => [
                [
                    'name' => 'রহিমা খাতুন',
                    'father_name' => 'আব্দুল মালেক',
                    'address' => 'গ্রাম: মোহাম্মদপুর, পোস্ট: মোহাম্মদপুর, জেলা: ঢাকা',
                    'nid' => '1234567890125'
                ]
            ],
            'la_case_no' => 'LA-2024-002',
            'infrastructure_award_serial_no' => 'INFRA-AWD-002',
            'acquisition_record_basis' => 'RS',
            'plot_no' => 'PLOT-002',
            'sa_plot_no' => null,
            'rs_plot_no' => 'RS-PLOT-002',
            'award_holder_names' => [
                ['name' => 'রহিমা খাতুন'],
                ['name' => 'মোহাম্মদ মালেক']
            ],
            'objector_details' => 'কোন আপত্তি নেই',
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '12%',
            'tree_compensation' => '45000',
            'infrastructure_compensation' => '75000',
            'land_category' => [
                [
                    'category_name' => 'অবকাঠামো',
                    'total_land' => '0',
                    'total_compensation' => '75000',
                    'applicant_land' => '0'
                ]
            ],
            'mouza_name' => 'মোহাম্মদপুর',
            'jl_no' => 'JL-002',
            'land_schedule_sa_plot_no' => 'SA-OLD-002',
            'land_schedule_rs_plot_no' => 'RS-NEW-002',
            'sa_khatian_no' => null,
            'rs_khatian_no' => 'RS-KH-002',
            'award_type' => 'অবকাঠামো',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => '',
                    'sa_khatian_no' => '',
                    'sa_total_land_in_plot' => '',
                    'sa_land_in_khatian' => ''
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-002',
                    'rs_khatian_no' => 'RS-KH-002',
                    'rs_total_land_in_plot' => '3 acres',
                    'rs_land_in_khatian' => '1.5 acres'
                ],
                'sa_owners' => [],
                'rs_owners' => [
                    ['name' => 'রহিমা খাতুন']
                ],
                'deed_transfers' => [],
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'আব্দুল মালেক',
                        'death_date' => '2023-06-15',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'ওয়ারিশ সনদ আছে'
                    ]
                ],
                'rs_records' => [
                    [
                        'plot_no' => 'RS-PLOT-002',
                        'khatian_no' => 'RS-KH-002',
                        'land_amount' => '1.5 acres',
                        'owner_names' => [
                            ['name' => 'রহিমা খাতুন'],
                            ['name' => 'মোহাম্মদ মালেক']
                        ],
                        'dp_khatian' => true
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'রহিমা খাতুন',
                    'kharij_case_no' => 'KHARIJ-002',
                    'kharij_plot_no' => 'PLOT-002',
                    'kharij_land_amount' => '1.5 acres',
                    'kharij_date' => '2024-02-20',
                    'kharij_details' => 'খারিজ সম্পন্ন হয়েছে'
                ],
                'transferItems' => [
                    ['type' => 'ওয়ারিশ', 'index' => 1],
                    ['type' => 'আবেদনকারী', 'index' => 1]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'mutation_info' => [
                'mutation_case_no' => 'KHARIJ-002',
                'mutation_plot_no' => 'PLOT-002',
                'mutation_land_amount' => '1.5 acres',
                'mutation_date' => '2024-02-20',
                'mutation_details' => 'খারিজ সম্পন্ন হয়েছে'
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১',
                'holding_no' => 'HLD-002',
                'paid_land_amount' => '1.5 acres'
            ],
            'additional_documents_info' => [
                'selected_types' => ['না-দাবী নামা', 'এফিডেভিটের তথ্য'],
                'details' => [
                    'না-দাবী নামা' => 'না-দাবী নামা সম্পন্ন হয়েছে',
                    'এফিডেভিটের তথ্য' => 'এফিডেভিট সম্পন্ন হয়েছে'
                ]
            ],
            'kanungo_opinion' => [
                'has_ownership_continuity' => 'yes',
                'opinion_details' => 'মালিকানার ধারাবাহিকতা আছে'
            ],
            'status' => 'pending',
            'order_signature_date' => null,
            'signing_officer_name' => null
        ]);

        // Demo Record 3: Complex SA-based with multiple transfers
        Compensation::create([
            'case_number' => 'CASE-2024-003',
            'case_date' => '2024-03-15',
            'applicants' => [
                [
                    'name' => 'সাবরিনা আক্তার',
                    'father_name' => 'মোহাম্মদ সফিক',
                    'address' => 'গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা',
                    'nid' => '1234567890126'
                ],
                [
                    'name' => 'মাহমুদা সুলতানা',
                    'father_name' => 'মোহাম্মদ সফিক',
                    'address' => 'গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা',
                    'nid' => '1234567890127'
                ]
            ],
            'la_case_no' => 'LA-2024-003',
            'land_award_serial_no' => 'LAND-AWD-003',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-003',
            'sa_plot_no' => 'SA-PLOT-003',
            'rs_plot_no' => null,
            'award_holder_names' => [
                ['name' => 'সাবরিনা আক্তার'],
                ['name' => 'মাহমুদা সুলতানা']
            ],
            'objector_details' => 'কোন আপত্তি নেই',
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '18%',
            'tree_compensation' => '90000',
            'infrastructure_compensation' => '120000',
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '2.5',
                    'total_compensation' => '500000',
                    'applicant_land' => '1.25'
                ],
                [
                    'category_name' => 'অনাবাদি জমি',
                    'total_land' => '0.5',
                    'total_compensation' => '100000',
                    'applicant_land' => '0.25'
                ]
            ],
            'mouza_name' => 'উত্তরা',
            'jl_no' => 'JL-003',
            'land_schedule_sa_plot_no' => 'SA-OLD-003',
            'land_schedule_rs_plot_no' => 'RS-NEW-003',
            'sa_khatian_no' => 'SA-KH-003',
            'rs_khatian_no' => null,
            'award_type' => 'জমি',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-003',
                    'sa_khatian_no' => 'SA-KH-003',
                    'sa_total_land_in_plot' => '6 acres',
                    'sa_land_in_khatian' => '3 acres'
                ],
                'rs_info' => [
                    'rs_plot_no' => '',
                    'rs_khatian_no' => '',
                    'rs_total_land_in_plot' => '',
                    'rs_land_in_khatian' => ''
                ],
                'sa_owners' => [
                    ['name' => 'সাবরিনা আক্তার'],
                    ['name' => 'মাহমুদা সুলতানা']
                ],
                'rs_owners' => [],
                'deed_transfers' => [
                    [
                        'donor_names' => [ ['name' => 'মোহাম্মদ সফিক'] ],
                        'recipient_names' => [ ['name' => 'সাবরিনা আক্তার'] ],
                        'deed_number' => 'DEED-002',
                        'deed_date' => '2021-03-20',
                        'sale_type' => 'বিক্রয়',
                        'plot_no' => 'PLOT-003',
                        'sold_land_amount' => '1.5 acres',
                        'total_sotangsho' => '3',
                        'total_shotok' => '6',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PLOT-003',
                        'possession_description' => 'দখলে আছে',
                        'mutation_case_no' => 'MUT-002',
                        'mutation_plot_no' => 'PLOT-003',
                        'mutation_land_amount' => '1.5 acres'
                    ],
                    [
                        'donor_names' => [ ['name' => 'আব্দুল হামিদ'] ],
                        'recipient_names' => [ ['name' => 'মাহমুদা সুলতানা'] ],
                        'deed_number' => 'DEED-003',
                        'deed_date' => '2022-05-10',
                        'sale_type' => 'বিক্রয়',
                        'plot_no' => 'PLOT-003',
                        'sold_land_amount' => '1.5 acres',
                        'total_sotangsho' => '3',
                        'total_shotok' => '6',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PLOT-003',
                        'possession_description' => 'দখলে আছে',
                        'mutation_case_no' => 'MUT-003',
                        'mutation_plot_no' => 'PLOT-003',
                        'mutation_land_amount' => '1.5 acres'
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [
                    [
                        'plot_no' => 'RS-PLOT-003',
                        'khatian_no' => 'RS-KH-003',
                        'land_amount' => '3 acres',
                        'owner_names' => [
                            ['name' => 'সাবরিনা আক্তার'],
                            ['name' => 'মাহমুদা সুলতানা']
                        ],
                        'dp_khatian' => true
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'সাবরিনা আক্তার',
                    'kharij_case_no' => 'KHARIJ-003',
                    'kharij_plot_no' => 'PLOT-003',
                    'kharij_land_amount' => '1.5 acres',
                    'kharij_date' => '2024-03-15',
                    'kharij_details' => 'খারিজ সম্পন্ন হয়েছে'
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 1],
                    ['type' => 'দলিল', 'index' => 2],
                    ['type' => 'আরএস রেকর্ড', 'index' => 1],
                    ['type' => 'আবেদনকারী', 'index' => 1]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => true
            ],
            'mutation_info' => [
                'mutation_case_no' => 'KHARIJ-003',
                'mutation_plot_no' => 'PLOT-003',
                'mutation_land_amount' => '1.5 acres',
                'mutation_date' => '2024-03-15',
                'mutation_details' => 'খারিজ সম্পন্ন হয়েছে'
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১',
                'holding_no' => 'HLD-003',
                'paid_land_amount' => '1.5 acres'
            ],
            'additional_documents_info' => [
                'selected_types' => ['আপস- বন্টননামা', 'না-দাবী নামা', 'সরেজমিন তদন্ত'],
                'details' => [
                    'আপস- বন্টননামা' => 'আপসনামা সম্পন্ন হয়েছে',
                    'না-দাবী নামা' => 'না-দাবী নামা সম্পন্ন হয়েছে',
                    'সরেজমিন তদন্ত' => 'সরেজমিন তদন্ত সম্পন্ন হয়েছে'
                ]
            ],
            'kanungo_opinion' => [
                'has_ownership_continuity' => 'yes',
                'opinion_details' => 'মালিকানার ধারাবাহিকতা আছে'
            ],
            'status' => 'pending',
            'order_signature_date' => null,
            'signing_officer_name' => null
        ]);

        // Demo Record 4: Mixed inheritance and deed
        Compensation::create([
            'case_number' => 'CASE-2024-004',
            'case_date' => '2024-04-20',
            'applicants' => [
                [
                    'name' => 'নাসরিন আক্তার',
                    'father_name' => 'আব্দুল মতিন',
                    'address' => 'গ্রাম: গুলশান, পোস্ট: গুলশান, জেলা: ঢাকা',
                    'nid' => '1234567890128'
                ]
            ],
            'la_case_no' => 'LA-2024-004',
            'land_award_serial_no' => 'LAND-AWD-004',
            'tree_award_serial_no' => 'TREE-AWD-004',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-004',
            'sa_plot_no' => 'SA-PLOT-004',
            'rs_plot_no' => null,
            'award_holder_names' => [
                ['name' => 'নাসরিন আক্তার'],
                ['name' => 'আব্দুল মতিন']
            ],
            'objector_details' => 'কোন আপত্তি নেই',
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '14%',
            'tree_compensation' => '60000',
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '1.5',
                    'total_compensation' => '300000',
                    'applicant_land' => '1.5'
                ],
                [
                    'category_name' => 'অনাবাদি জমি',
                    'total_land' => '0.5',
                    'total_compensation' => '100000',
                    'applicant_land' => '0.5'
                ]
            ],
            'mouza_name' => 'গুলশান',
            'jl_no' => 'JL-004',
            'land_schedule_sa_plot_no' => 'SA-OLD-004',
            'land_schedule_rs_plot_no' => 'RS-NEW-004',
            'sa_khatian_no' => 'SA-KH-004',
            'rs_khatian_no' => null,
            'award_type' => 'জমি ও গাছপালা',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-004',
                    'sa_khatian_no' => 'SA-KH-004',
                    'sa_total_land_in_plot' => '4 acres',
                    'sa_land_in_khatian' => '2 acres'
                ],
                'rs_info' => [
                    'rs_plot_no' => '',
                    'rs_khatian_no' => '',
                    'rs_total_land_in_plot' => '',
                    'rs_land_in_khatian' => ''
                ],
                'sa_owners' => [
                    ['name' => 'নাসরিন আক্তার']
                ],
                'rs_owners' => [],
                'deed_transfers' => [
                    [
                        'donor_names' => [ ['name' => 'আব্দুল মতিন'] ],
                        'recipient_names' => [ ['name' => 'নাসরিন আক্তার'] ],
                        'deed_number' => 'DEED-004',
                        'deed_date' => '2020-08-15',
                        'sale_type' => 'বিক্রয়',
                        'plot_no' => 'PLOT-004',
                        'sold_land_amount' => '1 acre',
                        'total_sotangsho' => '2',
                        'total_shotok' => '4',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PLOT-004',
                        'possession_description' => 'দখলে আছে',
                        'mutation_case_no' => 'MUT-004',
                        'mutation_plot_no' => 'PLOT-004',
                        'mutation_land_amount' => '1 acre'
                    ]
                ],
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'আব্দুল মতিন',
                        'death_date' => '2023-12-10',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'ওয়ারিশ সনদ আছে'
                    ]
                ],
                'rs_records' => [
                    [
                        'plot_no' => 'RS-PLOT-004',
                        'khatian_no' => 'RS-KH-004',
                        'land_amount' => '2.0 acres',
                        'owner_names' => [
                            ['name' => 'নাসরিন আক্তার']
                        ],
                        'dp_khatian' => true
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'নাসরিন আক্তার',
                    'kharij_case_no' => 'KHARIJ-004',
                    'kharij_plot_no' => 'PLOT-004',
                    'kharij_land_amount' => '2 acres',
                    'kharij_date' => '2024-04-20',
                    'kharij_details' => 'খারিজ সম্পন্ন হয়েছে'
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 1],
                    ['type' => 'ওয়ারিশ', 'index' => 1],
                    ['type' => 'আবেদনকারী', 'index' => 1]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'mutation_info' => [
                'mutation_case_no' => 'KHARIJ-004',
                'mutation_plot_no' => 'PLOT-004',
                'mutation_land_amount' => '2 acres',
                'mutation_date' => '2024-04-20',
                'mutation_details' => 'খারিজ সম্পন্ন হয়েছে'
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১',
                'holding_no' => 'HLD-004',
                'paid_land_amount' => '2 acres'
            ],
            'additional_documents_info' => [
                'selected_types' => ['এফিডেভিটের তথ্য'],
                'details' => [
                    'এফিডেভিটের তথ্য' => 'এফিডেভিট সম্পন্ন হয়েছে'
                ]
            ],
            'kanungo_opinion' => [
                'has_ownership_continuity' => 'yes',
                'opinion_details' => 'মালিকানার ধারাবাহিকতা আছে'
            ],
            'status' => 'pending',
            'order_signature_date' => null,
            'signing_officer_name' => null
        ]);

        // Demo Record 5: Missing tax and document information (to demonstrate blue asterisk behavior)
        Compensation::create([
            'case_number' => 'CASE-2024-005',
            'case_date' => '2024-05-10',
            'applicants' => [
                [
                    'name' => 'আহমেদ হোসেন',
                    'father_name' => 'মোহাম্মদ ইব্রাহিম',
                    'address' => 'গ্রাম: মিরপুর, পোস্ট: মিরপুর, জেলা: ঢাকা',
                    'nid' => '1234567890129'
                ]
            ],
            'la_case_no' => 'LA-2024-005',
            'land_award_serial_no' => 'LAND-AWD-005',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-005',
            'sa_plot_no' => 'SA-PLOT-005',
            'rs_plot_no' => null,
            'award_holder_names' => [
                ['name' => 'আহমেদ হোসেন']
            ],
            'objector_details' => 'কোন আপত্তি নেই',
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '8%',
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '1.0',
                    'total_compensation' => '200000',
                    'applicant_land' => '1.0'
                ]
            ],
            'mouza_name' => 'মিরপুর',
            'jl_no' => 'JL-005',
            'land_schedule_sa_plot_no' => 'SA-OLD-005',
            'land_schedule_rs_plot_no' => 'RS-NEW-005',
            'sa_khatian_no' => 'SA-KH-005',
            'rs_khatian_no' => null,
            'award_type' => 'জমি',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-005',
                    'sa_khatian_no' => 'SA-KH-005',
                    'sa_total_land_in_plot' => '2 acres',
                    'sa_land_in_khatian' => '1 acre'
                ],
                'rs_info' => [
                    'rs_plot_no' => '',
                    'rs_khatian_no' => '',
                    'rs_total_land_in_plot' => '',
                    'rs_land_in_khatian' => ''
                ],
                'sa_owners' => [
                    ['name' => 'আহমেদ হোসেন']
                ],
                'rs_owners' => [],
                'deed_transfers' => [
                    [
                        'donor_names' => [ ['name' => 'মোহাম্মদ ইব্রাহিম'] ],
                        'recipient_names' => [ ['name' => 'আহমেদ হোসেন'] ],
                        'deed_number' => 'DEED-005',
                        'deed_date' => '2021-10-20',
                        'sale_type' => 'বিক্রয়',
                        'plot_no' => 'PLOT-005',
                        'sold_land_amount' => '1 acre',
                        'total_sotangsho' => '2',
                        'total_shotok' => '4',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PLOT-005',
                        'possession_description' => 'দখলে আছে',
                        'mutation_case_no' => 'MUT-005',
                        'mutation_plot_no' => 'PLOT-005',
                        'mutation_land_amount' => '1 acre'
                    ]
                ],
                'inheritance_records' => [],
                'rs_records' => [
                    [
                        'plot_no' => 'RS-PLOT-005',
                        'khatian_no' => 'RS-KH-005',
                        'land_amount' => '1 acre',
                        'owner_names' => [
                            ['name' => 'আহমেদ হোসেন']
                        ],
                        'dp_khatian' => true
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'আহমেদ হোসেন',
                    'kharij_case_no' => 'KHARIJ-005',
                    'kharij_plot_no' => 'PLOT-005',
                    'kharij_land_amount' => '1 acre',
                    'kharij_date' => '2024-05-10',
                    'kharij_details' => 'খারিজ সম্পন্ন হয়েছে'
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 1],
                    ['type' => 'আবেদনকারী', 'index' => 1]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'mutation_info' => [
                'mutation_case_no' => 'KHARIJ-005',
                'mutation_plot_no' => 'PLOT-005',
                'mutation_land_amount' => '1 acre',
                'mutation_date' => '2024-05-10',
                'mutation_details' => 'খারিজ সম্পন্ন হয়েছে'
            ],
            'tax_info' => [
                'english_year' => '',
                'bangla_year' => '',
                'holding_no' => '',
                'paid_land_amount' => ''
            ],
            'additional_documents_info' => [
                'selected_types' => [],
                'details' => []
            ],
            'kanungo_opinion' => [
                'has_ownership_continuity' => 'yes',
                'opinion_details' => 'মালিকানার ধারাবাহিকতা আছে'
            ],
            'status' => 'pending',
            'order_signature_date' => null,
            'signing_officer_name' => null
        ]);

        // Demo Record 6: Partial tax information but no document information
        Compensation::create([
            'case_number' => 'CASE-2024-006',
            'case_date' => '2024-06-15',
            'applicants' => [
                [
                    'name' => 'সাবরিনা সুলতানা',
                    'father_name' => 'আব্দুল কাদের',
                    'address' => 'গ্রাম: উত্তরা, পোস্ট: উত্তরা, জেলা: ঢাকা',
                    'nid' => '1234567890130'
                ]
            ],
            'la_case_no' => 'LA-2024-006',
            'land_award_serial_no' => 'LAND-AWD-006',
            'acquisition_record_basis' => 'RS',
            'plot_no' => 'PLOT-006',
            'sa_plot_no' => null,
            'rs_plot_no' => 'RS-PLOT-006',
            'award_holder_names' => [
                ['name' => 'সাবরিনা সুলতানা']
            ],
            'objector_details' => 'কোন আপত্তি নেই',
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '10%',
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '0.75',
                    'total_compensation' => '150000',
                    'applicant_land' => '0.75'
                ]
            ],
            'mouza_name' => 'উত্তরা',
            'jl_no' => 'JL-006',
            'land_schedule_sa_plot_no' => 'SA-OLD-006',
            'land_schedule_rs_plot_no' => 'RS-NEW-006',
            'sa_khatian_no' => null,
            'rs_khatian_no' => 'RS-KH-006',
            'award_type' => 'জমি',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => '',
                    'sa_khatian_no' => '',
                    'sa_total_land_in_plot' => '',
                    'sa_land_in_khatian' => ''
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-006',
                    'rs_khatian_no' => 'RS-KH-006',
                    'rs_total_land_in_plot' => '1.5 acres',
                    'rs_land_in_khatian' => '0.75 acres'
                ],
                'sa_owners' => [],
                'rs_owners' => [
                    ['name' => 'সাবরিনা সুলতানা']
                ],
                'deed_transfers' => [],
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'আব্দুল কাদের',
                        'death_date' => '2023-08-20',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'ওয়ারিশ সনদ আছে'
                    ]
                ],
                'rs_records' => [
                    [
                        'plot_no' => 'RS-PLOT-006',
                        'khatian_no' => 'RS-KH-006',
                        'land_amount' => '0.75 acres',
                        'owner_names' => [
                            ['name' => 'সাবরিনা সুলতানা']
                        ],
                        'dp_khatian' => true
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'সাবরিনা সুলতানা',
                    'kharij_case_no' => 'KHARIJ-006',
                    'kharij_plot_no' => 'PLOT-006',
                    'kharij_land_amount' => '0.75 acres',
                    'kharij_date' => '2024-06-15',
                    'kharij_details' => 'খারিজ সম্পন্ন হয়েছে'
                ],
                'transferItems' => [
                    ['type' => 'ওয়ারিশ', 'index' => 1],
                    ['type' => 'আবেদনকারী', 'index' => 1]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ],
            'mutation_info' => [
                'mutation_case_no' => 'KHARIJ-006',
                'mutation_plot_no' => 'PLOT-006',
                'mutation_land_amount' => '0.75 acres',
                'mutation_date' => '2024-06-15',
                'mutation_details' => 'খারিজ সম্পন্ন হয়েছে'
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১',
                'holding_no' => 'HLD-006',
                'paid_land_amount' => ''
            ],
            'additional_documents_info' => [
                'selected_types' => [],
                'details' => []
            ],
            'kanungo_opinion' => [
                'has_ownership_continuity' => 'yes',
                'opinion_details' => 'মালিকানার ধারাবাহিকতা আছে'
            ],
            'status' => 'pending',
            'order_signature_date' => null,
            'signing_officer_name' => null
        ]);
    }
}
