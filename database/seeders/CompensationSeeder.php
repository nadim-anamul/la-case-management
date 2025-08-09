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

        // Generate comprehensive test cases for form validation
        $this->createTestCases();

        // Generate 2 compensations with all optional fields filled (maximal data)
        Compensation::factory()->count(2)->state(function (array $attributes) {
            return [
                'tree_compensation' => '50000',
                'infrastructure_compensation' => '75000',
                'objector_details' => 'বিরোধী পক্ষের বিস্তারিত',
                'tax_info' => [
                    'english_year' => '2024-25',
                    'bangla_year' => '১৪৩১-৩২',
                    'holding_no' => 'HOLD-' . fake()->numberBetween(100, 999),
                    'paid_land_amount' => fake()->randomFloat(2, 0.5, 5)
                ],
                'additional_documents_info' => [
                    'selected_types' => ['আপস- বন্টননামা', 'না-দাবি', 'সরেজমিন তদন্ত', 'এফিডেভিট'],
                    'details' => [
                        'আপস- বন্টননামা' => fake()->paragraph(),
                        'না-দাবি' => fake()->paragraph(),
                        'সরেজমিন তদন্ত' => fake()->paragraph(),
                        'এফিডেভিট' => fake()->paragraph()
                    ]
                ],
            ];
        })->create();

        // Generate 2 compensations with only minimal required fields (edge case)
        Compensation::factory()->count(2)->state(function (array $attributes) {
            return [
                'tree_compensation' => null,
                'infrastructure_compensation' => null,
                'objector_details' => null,
                'tax_info' => null,
                'additional_documents_info' => null,
                'land_category' => [
                    [
                        'category_name' => 'ধানী জমি',
                        'total_land' => '1.00',
                        'total_compensation' => '100000',
                        'applicant_land' => '1.00'
                    ]
                ],
            ];
        })->create();

        // Generate 2 compensations with multiple applicants and award holders (comprehensive test)
        Compensation::factory()->count(2)->state(function (array $attributes) {
            return [
                'applicants' => [
                    [
                        'name' => fake()->name(),
                        'father_name' => fake()->name(),
                        'address' => fake()->address(),
                        'nid' => fake()->numerify('#############'),
                        'mobile' => fake()->phoneNumber()
                    ],
                    [
                        'name' => fake()->name(),
                        'father_name' => fake()->name(),
                        'address' => fake()->address(),
                        'nid' => fake()->numerify('#############'),
                        'mobile' => fake()->phoneNumber()
                    ]
                ],
                'award_holder_names' => [
                    [
                        'name' => fake()->name(),
                        'father_name' => fake()->name(),
                        'address' => fake()->address()
                    ],
                    [
                        'name' => fake()->name(),
                        'father_name' => fake()->name(),
                        'address' => fake()->address()
                    ]
                ],
                'district' => fake()->randomElement(['বগুড়া', 'ঢাকা', 'চট্টগ্রাম', 'রাজশাহী']),
                'upazila' => fake()->randomElement(['বগুড়া সদর', 'শিবগঞ্জ', 'শেরপুর', 'দুপচাঁচিয়া']),
            ];
        })->create();

        $this->command->info('Compensation records with comprehensive test cases seeded successfully!');
        $this->command->info('Total records created: ' . Compensation::count());
    }

    private function createTestCases()
    {
        $this->command->info('Creating comprehensive test data for form validation...');

        // Test Case 1: Basic Land Award (জমি) - Simple case with proper number formats
        $this->createBasicLandCase();

        // Test Case 2: Land and Trees Award (জমি ও গাছপালা) with decimal numbers
        $this->createLandAndTreesCase();

        // Test Case 3: Infrastructure Award (অবকাঠামো)
        $this->createInfrastructureCase();

        // Test Case 4: Multiple Applicants with proper mobile/NID format
        $this->createMultipleApplicantsCase();

        // Test Case 5: Complex decimal numbers test
        $this->createDecimalTestCase();
    }

    private function createBasicLandCase()
    {
        Compensation::create([
            'case_number' => '1001',
            'case_date' => '2024-01-15',
            'applicants' => [
                [
                    'name' => 'মোঃ রহিম উদ্দিন',
                    'father_name' => 'মোঃ করিম উদ্দিন',
                    'address' => 'গ্রাম: পাড়াতলী, ডাকঘর: বগুড়া সদর, জেলা: বগুড়া',
                    'nid' => '1234567890123',
                    'mobile' => '01712345678'
                ]
            ],
            'la_case_no' => '2001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => '101',
            'sa_plot_no' => '101',
            'award_type' => 'জমি',
            'land_award_serial_no' => '501',
            'award_holder_names' => [
                [
                    'name' => 'মোঃ রহিম উদ্দিন',
                    'father_name' => 'মোঃ করিম উদ্দিন',
                    'address' => 'গ্রাম: পাড়াতলী, ডাকঘর: বগুড়া সদর, জেলা: বগুড়া'
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'ধানী জমি',
                    'total_land' => '2.50',
                    'total_compensation' => '250000.00',
                    'applicant_land' => '2.50'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '5.50',
            'district' => 'বগুড়া',
            'upazila' => 'বগুড়া সদর',
            'mouza_name' => 'পাড়াতলী',
            'jl_no' => '15',
            'sa_khatian_no' => '201',
            'land_schedule_sa_plot_no' => '101',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => '101',
                    'sa_khatian_no' => '201',
                    'sa_total_land_in_plot' => '5.00',
                    'sa_land_in_khatian' => '2.50'
                ],
                'sa_owners' => [['name' => 'মোঃ রহিম উদ্দিন']],
                'applicant_info' => [
                    'applicant_name' => 'মোঃ রহিম উদ্দিন',
                    'kharij_land_amount' => '2.50'
                ]
            ],
            'tax_info' => [
                'holding_no' => '1001',
                'paid_land_amount' => '2.50',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'status' => 'pending'
        ]);
    }

    private function createLandAndTreesCase()
    {
        Compensation::create([
            'case_number' => '1002',
            'case_date' => '2024-02-10',
            'applicants' => [
                [
                    'name' => 'মোছাঃ ফাতেমা খাতুন',
                    'father_name' => 'মোঃ আব্দুল হামিদ',
                    'address' => 'গ্রাম: কুমারপুর, ডাকঘর: শিবগঞ্জ, জেলা: বগুড়া',
                    'nid' => '9876543210987',
                    'mobile' => '01987654321'
                ]
            ],
            'la_case_no' => '2002',
            'acquisition_record_basis' => 'SA',
            'plot_no' => '102',
            'sa_plot_no' => '102',
            'award_type' => 'জমি ও গাছপালা',
            'tree_award_serial_no' => '601',
            'tree_compensation' => '75000.50',
            'award_holder_names' => [
                [
                    'name' => 'মোছাঃ ফাতেমা খাতুন',
                    'father_name' => 'মোঃ আব্দুল হামিদ',
                    'address' => 'গ্রাম: কুমারপুর, ডাকঘর: শিবগঞ্জ, জেলা: বগুড়া'
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '1.75',
                    'total_compensation' => '175000.75',
                    'applicant_land' => '1.75'
                ],
                [
                    'category_name' => 'বাগান জমি',
                    'total_land' => '0.50',
                    'total_compensation' => '80000.25',
                    'applicant_land' => '0.50'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '7.25',
            'district' => 'বগুড়া',
            'upazila' => 'শিবগঞ্জ',
            'mouza_name' => 'কুমারপুর',
            'jl_no' => '25',
            'sa_khatian_no' => '302',
            'land_schedule_sa_plot_no' => '102',
            'ownership_details' => [
                'sa_info' => [
                    'sa_total_land_in_plot' => '3.25',
                    'sa_land_in_khatian' => '2.25'
                ],
                'sa_owners' => [['name' => 'মোছাঃ ফাতেমা খাতুন']],
                'applicant_info' => ['kharij_land_amount' => '2.25']
            ],
            'tax_info' => [
                'holding_no' => '1002',
                'paid_land_amount' => '2.25',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ]
        ]);
    }

    private function createInfrastructureCase()
    {
        Compensation::create([
            'case_number' => '1003',
            'case_date' => '2024-03-05',
            'applicants' => [
                [
                    'name' => 'মোঃ আলমগীর হোসেন',
                    'father_name' => 'মোঃ নূরুল ইসলাম',
                    'address' => 'গ্রাম: রামপুর, ডাকঘর: শেরপুর, জেলা: বগুড়া',
                    'nid' => '5555666677778',
                    'mobile' => '01555666777'
                ]
            ],
            'la_case_no' => '2003',
            'acquisition_record_basis' => 'RS',
            'plot_no' => '203',
            'rs_plot_no' => '203',
            'award_type' => 'অবকাঠামো',
            'infrastructure_award_serial_no' => '701',
            'infrastructure_compensation' => '500000.00',
            'award_holder_names' => [
                [
                    'name' => 'মোঃ আলমগীর হোসেন',
                    'father_name' => 'মোঃ নূরুল ইসলাম',
                    'address' => 'গ্রাম: রামপুর, ডাকঘর: শেরপুর, জেলা: বগুড়া'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '10.00',
            'district' => 'বগুড়া',
            'upazila' => 'শেরপুর',
            'mouza_name' => 'রামপুর',
            'jl_no' => '35',
            'rs_khatian_no' => '403',
            'land_schedule_rs_plot_no' => '203',
            'ownership_details' => [
                'rs_info' => [
                    'rs_total_land_in_plot' => '1.00',
                    'rs_land_in_khatian' => '1.00'
                ],
                'rs_owners' => [['name' => 'মোঃ আলমগীর হোসেন']],
                'applicant_info' => ['kharij_land_amount' => '1.00']
            ],
            'tax_info' => [
                'holding_no' => '1003',
                'paid_land_amount' => '1.00',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ]
        ]);
    }

    private function createMultipleApplicantsCase()
    {
        Compensation::create([
            'case_number' => '1004',
            'case_date' => '2024-04-20',
            'applicants' => [
                [
                    'name' => 'মোঃ সাইফুল ইসলাম',
                    'father_name' => 'মোঃ আব্দুর রহমান',
                    'address' => 'গ্রাম: নয়াপাড়া, ডাকঘর: দুপচাঁচিয়া, জেলা: বগুড়া',
                    'nid' => '1111222233334',
                    'mobile' => '01711223344'
                ],
                [
                    'name' => 'মোছাঃ সালমা খাতুন',
                    'father_name' => 'মোঃ আব্দুর রহমান',
                    'address' => 'গ্রাম: নয়াপাড়া, ডাকঘর: দুপচাঁচিয়া, জেলা: বগুড়া',
                    'nid' => '2222333344445',
                    'mobile' => '01822334455'
                ]
            ],
            'la_case_no' => '2004',
            'acquisition_record_basis' => 'SA',
            'plot_no' => '104',
            'sa_plot_no' => '104',
            'award_type' => 'জমি',
            'land_award_serial_no' => '504',
            'award_holder_names' => [
                [
                    'name' => 'মোঃ আব্দুর রহমান',
                    'father_name' => 'মোঃ আব্দুল কাদের',
                    'address' => 'গ্রাম: নয়াপাড়া, ডাকঘর: দুপচাঁচিয়া, জেলা: বগুড়া'
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'আবাদি জমি',
                    'total_land' => '4.00',
                    'total_compensation' => '400000.00',
                    'applicant_land' => '2.00'
                ]
            ],
            'is_applicant_in_award' => false,
            'source_tax_percentage' => '6.75',
            'district' => 'বগুড়া',
            'upazila' => 'দুপচাঁচিয়া',
            'mouza_name' => 'নয়াপাড়া',
            'jl_no' => '45',
            'sa_khatian_no' => '504',
            'land_schedule_sa_plot_no' => '104'
        ]);
    }

    private function createDecimalTestCase()
    {
        Compensation::create([
            'case_number' => '1005',
            'case_date' => '2024-05-15',
            'applicants' => [
                [
                    'name' => 'দশমিক সংখ্যা টেস্ট',
                    'father_name' => 'নিউমেরিক ভ্যালিডেশন',
                    'address' => 'দশমিক পরীক্ষার ঠিকানা',
                    'nid' => '1234567890124',
                    'mobile' => '01712345679'
                ]
            ],
            'la_case_no' => '2005',
            'acquisition_record_basis' => 'SA',
            'plot_no' => '105',
            'award_type' => 'জমি ও গাছপালা',
            'tree_award_serial_no' => '605',
            'tree_compensation' => '12345.67',
            'award_holder_names' => [
                [
                    'name' => 'দশমিক সংখ্যা টেস্ট',
                    'father_name' => 'নিউমেরিক ভ্যালিডেশন',
                    'address' => 'দশমিক পরীক্ষার ঠিকানা'
                ]
            ],
            'land_category' => [
                [
                    'category_name' => 'দশমিক জমি',
                    'total_land' => '0.01',
                    'total_compensation' => '1000.01',
                    'applicant_land' => '0.01'
                ],
                [
                    'category_name' => 'ভগ্নাংশ জমি',
                    'total_land' => '123.45',
                    'total_compensation' => '123456.78',
                    'applicant_land' => '67.89'
                ]
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '12.34',
            'ownership_details' => [
                'sa_info' => [
                    'sa_total_land_in_plot' => '999.99',
                    'sa_land_in_khatian' => '123.45'
                ],
                'sa_owners' => [['name' => 'দশমিক সংখ্যা টেস্ট']],
                'applicant_info' => ['kharij_land_amount' => '67.89']
            ],
            'tax_info' => [
                'holding_no' => '1005',
                'paid_land_amount' => '67.89',
                'english_year' => '2024',
                'bangla_year' => '১৪৩১'
            ],
            'district' => 'দশমিক জেলা',
            'upazila' => 'দশমিক উপজেলা',
            'mouza_name' => 'দশমিক মৌজা',
                        'jl_no' => '105'
        ]);
    }
} 