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
            'award_serial_no' => 'AWD-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'sa_plot_no' => 'SA-PLOT-001',
            'rs_plot_no' => null,
            'award_holder_name' => 'আব্দুল রহমান',
            'is_applicant_in_award' => true,
            'total_acquired_land' => '2.5 acres',
            'total_compensation' => '500000',
            'applicant_acquired_land' => '1.25 acres',
            'mouza_name' => 'কাশিমপুর',
            'jl_no' => 'JL-001',
            'former_plot_no' => 'OLD-001',
            'current_plot_no' => 'NEW-001',
            'sa_khatian_no' => 'SA-KH-001',
            'rs_khatian_no' => null,
            'is_applicant_sa_owner' => true,
            'award_type' => ['জমি', 'জমি/গাছপালা'],
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
                        'donor_name' => 'মোহাম্মদ আলী',
                        'recipient_name' => 'আব্দুল রহমান',
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
                'rs_records' => [],
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
                'bangla_year' => '১৪৩১'
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
            ]
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
            'award_serial_no' => 'AWD-002',
            'acquisition_record_basis' => 'RS',
            'plot_no' => 'PLOT-002',
            'sa_plot_no' => null,
            'rs_plot_no' => 'RS-PLOT-002',
            'award_holder_name' => 'রহিমা খাতুন',
            'is_applicant_in_award' => true,
            'total_acquired_land' => '1.5 acres',
            'total_compensation' => '300000',
            'applicant_acquired_land' => '1.5 acres',
            'mouza_name' => 'মোহাম্মদপুর',
            'jl_no' => 'JL-002',
            'former_plot_no' => 'OLD-002',
            'current_plot_no' => 'NEW-002',
            'sa_khatian_no' => null,
            'rs_khatian_no' => 'RS-KH-002',
            'is_applicant_sa_owner' => false,
            'award_type' => ['জমি', 'জমি/গাছপালা', 'অবকাঠামো'],
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
                        'is_heir_applicant' => 'yes',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'ওয়ারিশ সনদ আছে',
                        'previous_owner_name' => 'আব্দুল মালেক',
                        'death_date' => '2023-06-15',
                        'inheritance_type' => 'direct'
                    ]
                ],
                'rs_records' => [],
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
                'bangla_year' => '১৪৩১'
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
            ]
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
            'award_serial_no' => 'AWD-003',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-003',
            'sa_plot_no' => 'SA-PLOT-003',
            'rs_plot_no' => null,
            'award_holder_name' => 'সাবরিনা আক্তার',
            'is_applicant_in_award' => true,
            'total_acquired_land' => '3.0 acres',
            'total_compensation' => '600000',
            'applicant_acquired_land' => '1.5 acres',
            'mouza_name' => 'উত্তরা',
            'jl_no' => 'JL-003',
            'former_plot_no' => 'OLD-003',
            'current_plot_no' => 'NEW-003',
            'sa_khatian_no' => 'SA-KH-003',
            'rs_khatian_no' => null,
            'is_applicant_sa_owner' => true,
            'award_type' => ['জমি', 'জমি/গাছপালা', 'অবকাঠামো'],
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
                        'donor_name' => 'মোহাম্মদ সফিক',
                        'recipient_name' => 'সাবরিনা আক্তার',
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
                        'donor_name' => 'আব্দুল হামিদ',
                        'recipient_name' => 'মাহমুদা সুলতানা',
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
                        'rs_plot_no' => 'RS-PLOT-003',
                        'rs_khatian_no' => 'RS-KH-003',
                        'rs_total_land_in_plot' => '3 acres',
                        'rs_land_in_khatian' => '1.5 acres',
                        'rs_owner_name' => 'সাবরিনা আক্তার'
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
                'bangla_year' => '১৪৩১'
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
            ]
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
            'award_serial_no' => 'AWD-004',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-004',
            'sa_plot_no' => 'SA-PLOT-004',
            'rs_plot_no' => null,
            'award_holder_name' => 'নাসরিন আক্তার',
            'is_applicant_in_award' => true,
            'total_acquired_land' => '2.0 acres',
            'total_compensation' => '400000',
            'applicant_acquired_land' => '2.0 acres',
            'mouza_name' => 'গুলশান',
            'jl_no' => 'JL-004',
            'former_plot_no' => 'OLD-004',
            'current_plot_no' => 'NEW-004',
            'sa_khatian_no' => 'SA-KH-004',
            'rs_khatian_no' => null,
            'is_applicant_sa_owner' => true,
            'award_type' => ['জমি/গাছপালা'],
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
                        'donor_name' => 'আব্দুল মতিন',
                        'recipient_name' => 'নাসরিন আক্তার',
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
                        'is_heir_applicant' => 'yes',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'ওয়ারিশ সনদ আছে',
                        'previous_owner_name' => 'আব্দুল মতিন',
                        'death_date' => '2023-12-10',
                        'inheritance_type' => 'direct'
                    ]
                ],
                'rs_records' => [],
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
                'bangla_year' => '১৪৩১'
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
            ]
        ]);
    }
}
