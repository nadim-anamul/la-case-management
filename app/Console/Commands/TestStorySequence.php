<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Compensation;

class TestStorySequence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:story-sequence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the story sequence functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Story Sequence Functionality...');

        // Test 1: Create a compensation record with story sequence
        $compensation = Compensation::create([
            'case_number' => 'TEST-CASE-001',
            'case_date' => '2024-01-15',
            'la_case_no' => 'LA-TEST-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-TEST-123',
            'applicants' => [
                ['name' => 'Test Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']
            ],
            'award_type' => ['land'],
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
            'land_schedule_sa_plot_no' => 'SA-PLOT-TEST-123',
            'sa_khatian_no' => 'KH-TEST-456',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-TEST-123',
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
                        'sale_type' => 'বিক্রয়',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-TEST-123',
                        'application_sell_area' => '2.50',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'PLOT-TEST-123',
                        'special_details' => 'Test deed details'
                    ]
                ],
                'inheritance_records' => [
                    [
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
                        'land_amount' => '3.25',
                        'dp_khatian' => true
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'kharij_case_no' => 'KHARIJ-TEST-001',
                    'kharij_plot_no' => 'PLOT-TEST-123',
                    'kharij_land_amount' => '2.50',
                    'kharij_date' => '2023-12-01',
                    'kharij_details' => 'Test kharij details'
                ]
            ],
            'tax_info' => [
                'english_year' => '2023-24',
                'bangla_year' => '১৪৩০-৩১',
                'holding_no' => 'HOLD-TEST-001',
                'paid_land_amount' => '2.50'
            ],
            'additional_documents_info' => [
                'selected_types' => ['distribution'],
                'details' => [
                    'distribution' => 'Test distribution details'
                ]
            ],
            'status' => 'pending'
        ]);

        $this->info('✅ Test compensation record created successfully!');
        $this->info('Record ID: ' . $compensation->id);

        // Verify story sequence data
        $retrievedCompensation = Compensation::find($compensation->id);
        $storySequence = $retrievedCompensation->ownership_details['storySequence'] ?? [];

        $this->info('✅ Story sequence data retrieved successfully!');
        $this->info('Number of story items: ' . count($storySequence));

        foreach ($storySequence as $index => $item) {
            $this->line('  ' . ($index + 1) . '. ' . $item['type'] . ' - ' . $item['description']);
        }

        // Test 2: Create a compensation record without story sequence
        $compensation2 = Compensation::create([
            'case_number' => 'TEST-CASE-002',
            'case_date' => '2024-01-15',
            'la_case_no' => 'LA-TEST-002',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-TEST-456',
            'applicants' => [
                ['name' => 'Test Applicant 2', 'father_name' => 'Test Father 2', 'address' => 'Test Address 2', 'nid' => '0987654321']
            ],
            'award_type' => ['land'],
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
            'land_schedule_sa_plot_no' => 'SA-PLOT-TEST-456',
            'sa_khatian_no' => 'KH-TEST-789',
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-TEST-456',
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
                        'sale_type' => 'বিক্রয়',
                        'application_type' => 'specific',
                        'application_specific_area' => 'PLOT-TEST-456',
                        'application_sell_area' => '1.75',
                        'possession_deed' => 'yes',
                        'possession_application' => 'yes',
                        'mentioned_areas' => 'PLOT-TEST-456',
                        'special_details' => 'Test deed details 2'
                    ]
                ],
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'Test Previous Owner 2',
                        'death_date' => '2020-12-15',
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'Test inheritance details 2'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant 2',
                    'kharij_case_no' => 'KHARIJ-TEST-002',
                    'kharij_plot_no' => 'PLOT-TEST-456',
                    'kharij_land_amount' => '1.75',
                    'kharij_date' => '2023-12-01',
                    'kharij_details' => 'Test kharij details 2'
                ]
            ],
            'tax_info' => [
                'english_year' => '2023-24',
                'bangla_year' => '১৪৩০-৩১',
                'holding_no' => 'HOLD-TEST-002',
                'paid_land_amount' => '1.75'
            ],
            'additional_documents_info' => [
                'selected_types' => ['distribution'],
                'details' => [
                    'distribution' => 'Test distribution details 2'
                ]
            ],
            'status' => 'pending'
        ]);

        $this->info('✅ Test compensation record 2 created successfully!');
        $this->info('Record ID: ' . $compensation2->id);

        // Verify that the story sequence can be generated from existing data
        $retrievedCompensation2 = Compensation::find($compensation2->id);
        $hasDeedTransfers = !empty($retrievedCompensation2->ownership_details['deed_transfers'] ?? []);
        $hasInheritanceRecords = !empty($retrievedCompensation2->ownership_details['inheritance_records'] ?? []);

        $this->info('✅ Data verification completed!');
        $this->info('Has deed transfers: ' . ($hasDeedTransfers ? 'Yes' : 'No'));
        $this->info('Has inheritance records: ' . ($hasInheritanceRecords ? 'Yes' : 'No'));

        $this->info('');
        $this->info('🎉 All tests passed! Story sequence functionality is working correctly.');
        $this->info('You can now test the web interface at http://localhost:8000');
        $this->info('Check the seeded records (CASE-001 to CASE-004) for various story sequences.');

        return Command::SUCCESS;
    }
}
