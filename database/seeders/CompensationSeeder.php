<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Compensation;

class CompensationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample compensation records with different types
        Compensation::factory()->count(10)->create();
        
        // Create some completed compensations
        Compensation::factory()->count(5)->completed()->create();
        
        // Create some RS record compensations
        Compensation::factory()->count(3)->rsRecord()->create();
        
        // Create some with kanungo opinion
        Compensation::factory()->count(3)->withKanungoOpinion()->create();
        
        // Create a specific sample record for demonstration
        Compensation::create([
            'case_number' => 'COMP-SAMPLE-001',
            'case_date' => '2024-08-15',
            'sa_plot_no' => 'SA-123',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'আব্দুল রহমান',
                    'father_name' => 'মোহাম্মদ আলী',
                    'address' => 'গ্রাম: কাশিমপুর, থানা: সাভার, জেলা: ঢাকা',
                    'nid' => '1234567890123'
                ]
            ],
            'la_case_no' => 'LA-SAMPLE-001',
            'award_type' => ['জমি'],
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
                        'deed_date' => '2020-01-10',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'specific',
                        'application_specific_area' => 'SA-123',
                        'application_sell_area' => '2.50',
                        'application_other_areas' => null,
                        'application_total_area' => null,
                        'application_sell_area_other' => null,
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PLOT-123',
                        'possession_description' => 'দখলে আছে',
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
                    'kharij_date' => '2021-02-15',
                    'kharij_details' => 'খারিজের বিবরণ: আবেদনকারী উপরোক্ত মালিকের কাছ থেকে জমি ক্রয় করেছেন।'
                ]
            ],
            'mutation_info' => null,
            'tax_info' => [
                'english_year' => '2024-25',
                'bangla_year' => '১৪৩১-৩২',
                'holding_no' => 'HOLD-123',
                'paid_land_amount' => '1.25'
            ],
            'additional_documents_info' => [
                'selected_types' => ['আপস- বন্টননামা'],
                'details' => [
                    'আপস- বন্টননামা' => 'আপসনামার বিবরণ: আবেদনকারী পরিবারের মধ্যে জমি বণ্টন করা হয়েছে।'
                ]
            ],
            'kanungo_opinion' => [
                'has_ownership_continuity' => 'yes',
                'opinion_details' => 'মালিকানার ধারাবাহিকতা আছে। দলিল মূলে হস্তান্তর সঠিকভাবে সম্পন্ন হয়েছে।'
            ],
            'order_signature_date' => '2024-08-25',
            'signing_officer_name' => 'মোহাম্মদ আলী',
            'status' => 'done'
        ]);

        // Create a sample record with multiple plots application type
        Compensation::create([
            'case_number' => 'COMP-MULTIPLE-001',
            'case_date' => '2024-08-20',
            'sa_plot_no' => 'SA-456',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'ফাতেমা বেগম',
                    'father_name' => 'আব্দুল মালেক',
                    'address' => 'গ্রাম: মোহাম্মদপুর, থানা: সাভার, জেলা: ঢাকা',
                    'nid' => '9876543210987'
                ]
            ],
            'la_case_no' => 'LA-MULTIPLE-001',
            'award_type' => ['জমি'],
            'land_award_serial_no' => 'LAS-002',
            'tree_award_serial_no' => null,
            'infrastructure_award_serial_no' => null,
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-456',
            'award_holder_names' => [
                ['name' => 'ফাতেমা বেগম']
            ],
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '3.75',
                    'total_compensation' => '750000',
                    'applicant_land' => '2.25'
                ]
            ],
            'objector_details' => null,
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '4',
            'tree_compensation' => null,
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
                    'sa_land_in_khatian' => '3.75'
                ],
                'sa_owners' => [
                    ['name' => 'ফাতেমা বেগম']
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'আব্দুল মালেক']],
                        'recipient_names' => [['name' => 'ফাতেমা বেগম']],
                        'deed_number' => 'DEED-002',
                        'deed_date' => '2020-03-15',
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => 'multiple',
                        'application_specific_area' => null,
                        'application_sell_area' => null,
                        'application_other_areas' => 'SA-456, SA-789, SA-101',
                        'application_total_area' => '4.50',
                        'application_sell_area_other' => '2.25',
                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'PLOT-456',
                        'possession_description' => 'দখলে আছে',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'SA-456, SA-789, SA-101',
                        'special_details' => 'বিভিন্ন দাগ থেকে জমি ক্রয় করা হয়েছে'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'ফাতেমা বেগম',
                    'kharij_case_no' => 'KH-002',
                    'kharij_plot_no' => 'KH-PLOT-456',
                    'kharij_land_amount' => '2.25',
                    'kharij_date' => '2021-05-20',
                    'kharij_details' => 'খারিজের বিবরণ: আবেদনকারী বিভিন্ন দাগ থেকে জমি ক্রয় করেছেন।'
                ]
            ],
            'mutation_info' => null,
            'tax_info' => [
                'english_year' => '2024-25',
                'bangla_year' => '১৪৩১-৩২',
                'holding_no' => 'HOLD-456',
                'paid_land_amount' => '2.25'
            ],
            'additional_documents_info' => [
                'selected_types' => ['আপস- বন্টননামা'],
                'details' => [
                    'আপস- বন্টননামা' => 'আপসনামার বিবরণ: পরিবারের মধ্যে জমি বণ্টন করা হয়েছে।'
                ]
            ],
            'kanungo_opinion' => [
                'has_ownership_continuity' => 'yes',
                'opinion_details' => 'মালিকানার ধারাবাহিকতা আছে। বিভিন্ন দাগ থেকে জমি ক্রয় সঠিকভাবে সম্পন্ন হয়েছে।'
            ],
            'order_signature_date' => '2024-08-30',
            'signing_officer_name' => 'আব্দুল মালেক',
            'status' => 'done'
        ]);

        $this->command->info('Compensation records seeded successfully!');
        $this->command->info('Created:');
        $this->command->info('- 10 basic compensation records');
        $this->command->info('- 5 completed compensations');
        $this->command->info('- 3 RS record compensations');
        $this->command->info('- 3 compensations with kanungo opinion');
        $this->command->info('- 1 sample demonstration record (specific plot)');
        $this->command->info('- 1 sample demonstration record (multiple plots)');
    }
} 