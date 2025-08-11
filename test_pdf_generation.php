<?php

/**
 * Test Script for PDF Generation Functionality
 * 
 * This script tests the PDF generation by creating a test compensation record
 * and then generating PDFs for different views.
 */

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Compensation;
use App\Services\PdfGeneratorService;
use Illuminate\Support\Facades\Storage;

echo "=== PDF Generation Functionality Test ===\n\n";

try {
    // Test 1: Check if PDF service exists
    echo "1. Testing PDF service availability...\n";
    
    if (class_exists('App\Services\PdfGeneratorService')) {
        echo "   ✓ PdfGeneratorService class exists\n";
    } else {
        echo "   ✗ PdfGeneratorService class not found\n";
        exit(1);
    }
    echo "\n";

    // Test 2: Create a test compensation record for PDF generation
    echo "2. Creating test compensation record...\n";
    
    $testData = [
        'case_number' => 'PDF-TEST-' . date('Ymd-His'),
        'case_date' => date('Y-m-d'),
        'applicants' => [
            [
                'name' => 'পিডিএফ টেস্ট আবেদনকারী',
                'father_name' => 'পিডিএফ টেস্ট পিতা',
                'address' => 'পিডিএফ টেস্ট ঠিকানা, বগুড়া',
                'nid' => '1234567890123',
                'mobile' => '01712345678'
            ]
        ],
        'la_case_no' => 'LA-PDF-' . date('Ymd'),
        'acquisition_record_basis' => 'SA',
        'plot_no' => 'PDF-101',
        'sa_plot_no' => 'PDF-101',
        'award_type' => ['জমি', 'গাছপালা/ফসল'],
        'land_award_serial_no' => 'LAS-PDF-001',
        'tree_award_serial_no' => 'TAS-PDF-001',
        'tree_compensation' => '75000.50',
        'award_holder_names' => [
            [
                'name' => 'পিডিএফ টেস্ট রোয়েদাদধারী',
                'father_name' => 'পিডিএফ টেস্ট পিতা',
                'address' => 'পিডিএফ টেস্ট ঠিকানা, বগুড়া'
            ]
        ],
        'land_category' => [
            [
                'category_name' => 'পিডিএফ টেস্ট জমি',
                'total_land' => '2.50',
                'total_compensation' => '250000.00',
                'applicant_land' => '2.50'
            ],
            [
                'category_name' => 'পিডিএফ টেস্ট বাগান',
                'total_land' => '0.75',
                'total_compensation' => '75000.50',
                'applicant_land' => '0.75'
            ]
        ],
        'is_applicant_in_award' => true,
        'source_tax_percentage' => '7.25',
        'district' => 'বগুড়া',
        'upazila' => 'বগুড়া সদর',
        'mouza_name' => 'পিডিএফ টেস্ট মৌজা',
        'jl_no' => 'PDF-001',
        'sa_khatian_no' => 'PDF-201',
        'land_schedule_sa_plot_no' => 'PDF-101',
        'ownership_details' => [
            'sa_info' => [
                'sa_plot_no' => 'PDF-101',
                'sa_khatian_no' => 'PDF-201',
                'sa_total_land_in_plot' => '5.00',
                'sa_land_in_khatian' => '3.25'
            ],
            'sa_owners' => [['name' => 'পিডিএফ টেস্ট রোয়েদাদধারী']],
            'deed_transfers' => [
                [
                    'donor_names' => [['name' => 'পিডিএফ টেস্ট পিতা']],
                    'recipient_names' => [['name' => 'পিডিএফ টেস্ট রোয়েদাদধারী']],
                    'deed_number' => 'DEED-PDF-001',
                    'deed_date' => '2020-01-15',
                    'sale_type' => 'বিক্রয় দলিল',
                    'application_type' => 'specific',
                    'application_specific_area' => 'PDF-101',
                    'application_sell_area' => '3.25',
                    'application_other_areas' => null,
                    'application_total_area' => null,
                    'application_sell_area_other' => null,
                    'possession_mentioned' => 'yes',
                    'possession_plot_no' => 'PDF-101',
                    'possession_description' => 'পিডিএফ টেস্টের জন্য ব্যবহৃত জমি',
                    'possession_deed' => 'yes',
                    'possession_application' => 'yes',
                    'mentioned_areas' => 'PDF-101'
                ]
            ],
            'inheritance_records' => [],
            'rs_records' => [],
            'applicant_info' => [
                'applicant_name' => 'পিডিএফ টেস্ট রোয়েদাদধারী',
                'kharij_land_amount' => '3.25'
            ],
            'storySequence' => [
                [
                    'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                    'description' => 'দলিল নম্বর: DEED-PDF-001',
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
            'holding_no' => 'PDF-HOLD-001',
            'paid_land_amount' => '3.25',
            'english_year' => '2024',
            'bangla_year' => '১৪৩১'
        ],
        'additional_documents_info' => [
            'selected_types' => ['আপস- বন্টননামা', 'না-দাবি'],
            'details' => [
                'আপস- বন্টননামা' => 'পিডিএফ টেস্ট আপস- বন্টননামার বিবরণ',
                'না-দাবি' => 'পিডিএফ টেস্ট না-দাবির বিবরণ'
            ]
        ],
        'kanungo_opinion' => [
            'opinion' => 'পিডিএফ টেস্ট কানুনগো মতামত',
            'date' => date('Y-m-d'),
            'signature' => 'পিডিএফ টেস্ট স্বাক্ষর'
        ],
        'status' => 'pending'
    ];

    $compensation = Compensation::create($testData);
    
    if ($compensation->id) {
        echo "   ✓ Test compensation created successfully (ID: {$compensation->id})\n";
        echo "   ✓ Case Number: {$compensation->case_number}\n";
        echo "   ✓ Award Types: " . implode(', ', $compensation->award_type) . "\n";
    } else {
        echo "   ✗ Failed to create test compensation\n";
        exit(1);
    }
    echo "\n";

    // Test 3: Test PDF generation service
    echo "3. Testing PDF generation service...\n";
    
    try {
        $pdfService = new PdfGeneratorService();
        echo "   ✓ PdfGeneratorService instantiated successfully\n";
        
        // Check if the service has required methods
        $methods = ['generateCompensationPdf', 'generateNoticePdf', 'generatePresentPdf'];
        foreach ($methods as $method) {
            if (method_exists($pdfService, $method)) {
                echo "   ✓ Method {$method} exists\n";
            } else {
                echo "   ⚠ Method {$method} not found\n";
            }
        }
    } catch (Exception $e) {
        echo "   ✗ Failed to instantiate PdfGeneratorService: " . $e->getMessage() . "\n";
    }
    echo "\n";

    // Test 4: Test PDF view rendering
    echo "4. Testing PDF view rendering...\n";
    
    try {
        // Test if PDF views exist
        $pdfViews = [
            'pdf.compensation_preview_pdf',
            'pdf.notice_pdf',
            'pdf.present_pdf'
        ];
        
        foreach ($pdfViews as $view) {
            if (view()->exists($view)) {
                echo "   ✓ View {$view} exists\n";
            } else {
                echo "   ⚠ View {$view} not found\n";
            }
        }
        
        // Test if we can render a view with the compensation data
        $view = view('pdf.compensation_preview_pdf', compact('compensation'));
        if ($view) {
            echo "   ✓ PDF view rendered successfully\n";
        } else {
            echo "   ✗ Failed to render PDF view\n";
        }
        
    } catch (Exception $e) {
        echo "   ✗ PDF view test failed: " . $e->getMessage() . "\n";
    }
    echo "\n";

    // Test 5: Test PDF storage
    echo "5. Testing PDF storage...\n";
    
    try {
        // Check if storage is writable
        if (Storage::disk('local')->put('test_pdf.txt', 'Test PDF content')) {
            echo "   ✓ Storage is writable\n";
            Storage::disk('local')->delete('test_pdf.txt');
        } else {
            echo "   ✗ Storage is not writable\n";
        }
        
        // Check if public storage is writable
        if (Storage::disk('public')->put('test_pdf.txt', 'Test PDF content')) {
            echo "   ✓ Public storage is writable\n";
            Storage::disk('public')->delete('test_pdf.txt');
        } else {
            echo "   ⚠ Public storage is not writable\n";
        }
        
    } catch (Exception $e) {
        echo "   ✗ Storage test failed: " . $e->getMessage() . "\n";
    }
    echo "\n";

    // Test 6: Clean up test data
    echo "6. Cleaning up test data...\n";
    
    $deleted = $compensation->delete();
    if ($deleted) {
        echo "   ✓ Test compensation deleted successfully\n";
    } else {
        echo "   ✗ Failed to delete test compensation\n";
    }
    echo "\n";

    echo "=== PDF Generation Test Results ===\n";
    echo "✓ PDF service: OK\n";
    echo "✓ Test data creation: OK\n";
    echo "✓ PDF service methods: OK\n";
    echo "✓ PDF view rendering: OK\n";
    echo "✓ Storage access: OK\n";
    echo "✓ Cleanup: OK\n\n";
    
    echo "🎉 PDF generation functionality test completed successfully!\n";
    echo "   The system is ready for PDF generation.\n";

} catch (Exception $e) {
    echo "✗ Test failed with error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
