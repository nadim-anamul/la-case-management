<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Compensation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_form_submission_with_bengali_dates()
    {
        $formData = [
            // Basic Case Information
            'case_number' => 'TEST-CASE-001',
            'case_date' => '১৫/০১/২০২৪', // Bengali date
            
            // Applicants Information
            'applicants' => [
                [
                    'name' => 'Test Applicant',
                    'father_name' => 'Test Father',
                    'address' => 'Test Address',
                    'nid' => '12345678901234567890'
                ]
            ],
            
            // LA Case Information
            'la_case_no' => 'LA-TEST-001',
            'award_type' => ['গাছপালা/ফসল'],
            'land_award_serial_no' => 'LAND-AWARD-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'award_holder_names' => [
                ['name' => 'Award Holder']
            ],
            'objector_details' => 'Test objector details',
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'land_schedule_sa_plot_no' => 'SA-PLOT-001',
            'sa_khatian_no' => 'SA-KHATIAN-001',
            'sa_plot_no' => 'SA-PLOT-001',
            
            // Land Category
            'land_category' => [
                [
                    'category_name' => 'Agricultural Land',
                    'total_land' => '2.5',
                    'total_compensation' => '50000',
                    'applicant_land' => '1.5'
                ]
            ],
            
            // Tax Information
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১',
                'holding_no' => 'HLD-001',
                'paid_land_amount' => '2.5 acres'
            ],
            
            // Additional Documents Information
            'additional_documents_info' => [
                'selected_types' => ['deed'],
                'details' => ['deed' => 'Test deed document details']
            ],
            
            // Ownership Details with Bengali dates
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-001',
                    'sa_khatian_no' => 'SA-KHATIAN-001',
                    'sa_total_land_in_plot' => '5 acres',
                    'sa_land_in_khatian' => '3 acres'
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-001',
                    'rs_khatian_no' => 'RS-KHATIAN-001',
                    'rs_total_land_in_plot' => '4 acres',
                    'rs_land_in_khatian' => '2 acres'
                ],
                'sa_owners' => [
                    ['name' => 'John Doe'],
                    ['name' => 'Jane Smith']
                ],
                'rs_owners' => [
                    ['name' => 'Bob Johnson'],
                    ['name' => 'Alice Brown']
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Mohammad Ali']],
                        'recipient_names' => [['name' => 'Abdul Rahman']],
                        'deed_number' => 'DEED-001',
                        'deed_date' => '১৫/০১/২০২৪', // Bengali date
                        'sale_type' => 'দলিল',

                        'possession_mentioned' => 'yes',
                        'possession_plot_no' => 'POSS-001',
                        'possession_description' => 'Full possession transferred',

                    ]
                ],
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'Deceased Owner',
                        'death_date' => '০১/১২/২০২৩', // Bengali date
                        'has_death_cert' => 'yes',
                        'heirship_certificate_info' => 'Certificate number: HEIR-001'
                    ]
                ],
                'rs_records' => [
                    [
                        'plot_no' => 'RS-PLOT-002',
                        'khatian_no' => 'RS-KHATIAN-002',
                        'land_amount' => '1.5 acres',
                        'owner_names' => [
                            ['name' => 'RS Owner']
                        ],
                        'dp_khatian' => 'on'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant',
                    'namejari_khatian_no' => 'NAMEJARI-001',
                    'kharij_case_no' => 'KHARIJ-001',
                    'kharij_plot_no' => 'KHARIJ-PLOT-001',
                    'kharij_land_amount' => '2 acres',
                    'kharij_date' => '০১/০৬/২০২৪', // Bengali date
                    'kharij_details' => 'Test kharij details for mutation'
                ],
                'transferItems' => [
                    ['type' => 'দলিল', 'index' => 0],
                    ['type' => 'ওয়ারিশ', 'index' => 0],
                    ['type' => 'আরএস রেকর্ড', 'index' => 0]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers'],
                'rs_record_disabled' => true
            ]
        ];

        // Submit the form
        $response = $this->post('/compensation/store', $formData);

        // Check if there are any validation errors
        if ($response->getStatusCode() === 422) {
            $errors = $response->json()['errors'] ?? [];
            $this->fail('Form submission failed with validation errors: ' . json_encode($errors, JSON_PRETTY_PRINT));
        }

        // If response is a redirect, check if it's a successful redirect
        if ($response->getStatusCode() === 302) {
            $redirectUrl = $response->headers->get('Location');
            
            // Check if it's a successful redirect to compensation preview
            if (str_contains($redirectUrl, '/compensation/') && str_contains($redirectUrl, '/preview')) {
                // This is a successful submission, continue with the test
            } else {
                // This might be a validation error redirect, follow it to check
                $redirectResponse = $this->get($redirectUrl);
                if ($redirectResponse->getStatusCode() === 200) {
                    // Check if there are validation errors in the session
                    $session = $this->app['session.store'];
                    $errors = $session->get('errors');
                    if ($errors) {
                        $this->fail('Form submission failed with validation errors: ' . json_encode($errors->getBag('default')->toArray(), JSON_PRETTY_PRINT));
                    }
                }
                // If redirecting to localhost, it's likely a validation error
                if (str_contains($redirectUrl, 'localhost')) {
                    $this->fail('Form submission redirected to localhost, indicating validation errors. Redirect URL: ' . $redirectUrl);
                }
            }
        }

        // If response is not successful, capture the actual response
        if (!$response->isSuccessful() && $response->getStatusCode() !== 302) {
            $this->fail('Form submission failed. Status: ' . $response->getStatusCode() . 
                       ', Response: ' . $response->getContent());
        }

        // Assert successful redirect
        $this->assertStringContainsString('/compensation/', $response->headers->get('Location'));

        // Get the saved compensation record
        $compensation = Compensation::latest()->first();

        // Assert the record was created
        $this->assertNotNull($compensation);

        // Verify that dates were properly converted
        $this->assertEquals('2024-01-15', $compensation->case_date);
        
        // Verify deed transfer date was converted
        $ownershipDetails = $compensation->ownership_details;
        $this->assertEquals('2024-01-15', $ownershipDetails['deed_transfers'][0]['deed_date']);
        
        // Verify inheritance death date was converted
        $this->assertEquals('2023-12-01', $ownershipDetails['inheritance_records'][0]['death_date']);
        
        // Verify kharij date was converted
        $this->assertEquals('2024-06-01', $ownershipDetails['applicant_info']['kharij_date']);
    }

    public function test_form_submission_with_english_dates()
    {
        $formData = [
            'case_number' => 'COMP-TEST-002',
            'case_date' => '2024-01-16',
            'sa_plot_no' => 'SA-002',
            'rs_plot_no' => null,
            'applicants' => [
                [
                    'name' => 'Test Applicant 2',
                    'father_name' => 'Test Father 2',
                    'address' => 'Test Address 2',
                    'nid' => '1234567891',
                    'mobile' => '01712345679'
                ]
            ],
            'la_case_no' => 'LA-TEST-002',
            'award_type' => ['গাছপালা/ফসল'],
            'land_award_serial_no' => 'LAND-AWARD-002',
            'tree_award_serial_no' => 'TREE-AWARD-002',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-002',
            'award_holder_names' => [
                [
                    'name' => 'Award Holder 2',
                    'father_name' => 'Test Father 2',
                    'address' => 'Test Address 2'
                ]
            ],
            'objector_details' => 'Test objector details 2',
            'is_applicant_in_award' => false,
            'source_tax_percentage' => '5.0',
            'tree_compensation' => '25000',
            'infrastructure_compensation' => null,
            'district' => 'বগুড়া',
            'upazila' => 'শিবগঞ্জ',
            'mouza_name' => 'Test Mouza 2',
            'jl_no' => 'JL-002',
            'sa_khatian_no' => 'SA-KH-002',
            'land_schedule_sa_plot_no' => 'SA-PLOT-002',
            'land_schedule_rs_plot_no' => null,
            'rs_khatian_no' => null,
            'land_category' => [
                [
                    'category_name' => 'Agricultural Land',
                    'total_land' => '3.0',
                    'total_compensation' => '75000',
                    'applicant_land' => '2.0'
                ]
            ],
            'tax_info' => [
                'english_year' => '2024',
                'bangla_year' => '১৪৩১',
                'holding_no' => 'HLD-002',
                'paid_land_amount' => '3.0'
            ],
            'additional_documents_info' => [
                'selected_types' => ['deed', 'affidavit'],
                'details' => [
                    'deed' => 'Test deed document details 2',
                    'affidavit' => 'Test affidavit details'
                ]
            ],
            'ownership_details' => [
                'sa_info' => [
                    'sa_plot_no' => 'SA-PLOT-002',
                    'sa_khatian_no' => 'SA-KH-002',
                    'sa_total_land_in_plot' => '6',
                    'sa_land_in_khatian' => '4'
                ],
                'rs_info' => [
                    'rs_plot_no' => 'RS-PLOT-002',
                    'rs_khatian_no' => 'RS-KH-002',
                    'rs_total_land_in_plot' => '5',
                    'rs_land_in_khatian' => '3'
                ],
                'sa_owners' => [
                    ['name' => 'John Doe 2']
                ],
                'rs_owners' => [
                    ['name' => 'Bob Johnson 2']
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => 'Mohammad Ali 2']],
                        'recipient_names' => [['name' => 'Abdul Rahman 2']],
                        'deed_number' => 'DEED-002',
                        'deed_date' => '2024-02-15',
                        'sale_type' => 'দলিল',
                        'possession_mentioned' => 'no',
                        'possession_plot_no' => '',
                        'possession_description' => ''
                    ]
                ],
                'inheritance_records' => [
                    [
                        'previous_owner_name' => 'Deceased Owner 2',
                        'death_date' => '2023-11-01',
                        'has_death_cert' => 'no',
                        'heirship_certificate_info' => 'Certificate number: HEIR-002'
                    ]
                ],
                'rs_records' => [
                    [
                        'plot_no' => 'RS-PLOT-003',
                        'khatian_no' => 'RS-KH-003',
                        'land_amount' => '2.5',
                        'owner_names' => [
                            ['name' => 'RS Owner 2']
                        ],
                        'dp_khatian' => 'on'
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => 'Test Applicant 2',
                    'kharij_case_no' => 'KH-002',
                    'kharij_plot_no' => 'KH-PLOT-002',
                    'kharij_land_amount' => '2.0',
                    'kharij_date' => '2024-02-16',
                    'kharij_details' => 'Test kharij details 2'
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
                        'description' => 'পূর্ববর্তী মালিক: Deceased Owner 2',
                        'itemType' => 'inheritance',
                        'itemIndex' => 0,
                        'sequenceIndex' => 1
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ]
        ];

        // Submit the form
        $response = $this->post('/compensation/store', $formData);

        // Check if there are any validation errors
        if ($response->getStatusCode() === 422) {
            $errors = $response->json()['errors'] ?? [];
            $this->fail('Form submission failed with validation errors: ' . json_encode($errors, JSON_PRETTY_PRINT));
        }

        // If response is a redirect, check if it's a successful redirect
        if ($response->getStatusCode() === 302) {
            $redirectUrl = $response->headers->get('Location');
            
            // Check if it's a successful redirect to compensation preview
            if (str_contains($redirectUrl, '/compensation/') && str_contains($redirectUrl, '/preview')) {
                // This is a successful submission, continue with the test
            } else {
                // This might be a validation error redirect, follow it to check
                $redirectResponse = $this->get($redirectUrl);
                if ($redirectResponse->getStatusCode() === 200) {
                    // Check if there are validation errors in the session
                    $session = $this->app['session.store'];
                    $errors = $session->get('errors');
                    if ($errors) {
                        $this->fail('Form submission failed with validation errors: ' . json_encode($errors->getBag('default')->toArray(), JSON_PRETTY_PRINT));
                    }
                }
                // If redirecting to localhost, it's likely a validation error
                if (str_contains($redirectUrl, 'localhost')) {
                    $this->fail('Form submission redirected to localhost, indicating validation errors. Redirect URL: ' . $redirectUrl);
                }
            }
        }

        // If response is not successful, capture the actual response
        if (!$response->isSuccessful() && $response->getStatusCode() !== 302) {
            $this->fail('Form submission failed. Status: ' . $response->getStatusCode() . 
                       ', Response: ' . $response->getContent());
        }

        // Assert successful redirect
        $this->assertStringContainsString('/compensation/', $response->headers->get('Location'));

        // Get the saved compensation record
        $compensation = Compensation::latest()->first();

        // Assert the record was created
        $this->assertNotNull($compensation);

        // Verify that dates were properly handled
        $this->assertEquals('2024-01-15', $compensation->case_date);
        
        // Verify deed transfer date was handled
        $ownershipDetails = $compensation->ownership_details;
        $this->assertEquals('2024-02-15', $ownershipDetails['deed_transfers'][0]['deed_date']);
        
        // Verify inheritance death date was handled
        $this->assertEquals('2023-11-01', $ownershipDetails['inheritance_records'][0]['death_date']);
        
        // Verify kharij date was handled
        $this->assertEquals('2024-07-01', $ownershipDetails['applicant_info']['kharij_date']);
    }
} 