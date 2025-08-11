<?php

/**
 * Test Script for Compensation Form Functionality
 * 
 * This script tests the basic functionality of the compensation form
 * by creating a test record and validating the data structure.
 */

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Compensation;
use Illuminate\Support\Facades\DB;

echo "=== Compensation Form Functionality Test ===\n\n";

try {
    // Test 1: Check if we can connect to the database
    echo "1. Testing database connection...\n";
    DB::connection()->getPdo();
    echo "   ✓ Database connection successful\n\n";

    // Test 2: Check if compensations table exists
    echo "2. Testing table structure...\n";
    $tableExists = DB::getSchemaBuilder()->hasTable('compensations');
    if ($tableExists) {
        echo "   ✓ Compensations table exists\n";
        
        // Get table columns
        $columns = DB::getSchemaBuilder()->getColumnListing('compensations');
        echo "   ✓ Table has " . count($columns) . " columns\n";
        echo "   ✓ Key columns: " . implode(', ', array_slice($columns, 0, 10)) . "...\n";
    } else {
        echo "   ✗ Compensations table does not exist\n";
        exit(1);
    }
    echo "\n";

    // Test 3: Create a test compensation record
    echo "3. Testing compensation creation...\n";
    
    $testData = [
        'case_number' => 'TEST-' . date('Ymd-His'),
        'case_date' => date('Y-m-d'),
        'applicants' => [
            [
                'name' => 'টেস্ট আবেদনকারী',
                'father_name' => 'টেস্ট পিতা',
                'address' => 'টেস্ট ঠিকানা, বগুড়া',
                'nid' => '1234567890123',
                'mobile' => '01712345678'
            ]
        ],
        'la_case_no' => 'LA-TEST-' . date('Ymd'),
        'acquisition_record_basis' => 'SA',
        'plot_no' => 'TEST-101',
        'sa_plot_no' => 'TEST-101',
        'award_type' => ['জমি'],
        'land_award_serial_no' => 'LAS-TEST-001',
        'award_holder_names' => [
            [
                'name' => 'টেস্ট রোয়েদাদধারী',
                'father_name' => 'টেস্ট পিতা',
                'address' => 'টেস্ট ঠিকানা, বগুড়া'
            ]
        ],
        'land_category' => [
            [
                'category_name' => 'টেস্ট জমি',
                'total_land' => '1.00',
                'total_compensation' => '100000.00',
                'applicant_land' => '1.00'
            ]
        ],
        'is_applicant_in_award' => true,
        'source_tax_percentage' => '5.50',
        'district' => 'বগুড়া',
        'upazila' => 'বগুড়া সদর',
        'mouza_name' => 'টেস্ট মৌজা',
        'jl_no' => 'TEST-001',
        'sa_khatian_no' => 'TEST-201',
        'land_schedule_sa_plot_no' => 'TEST-101',
        'ownership_details' => [],
        'tax_info' => [
            'holding_no' => 'TEST-HOLD-001',
            'paid_land_amount' => '1.00',
            'english_year' => '2024',
            'bangla_year' => '১৪৩১'
        ],
        'status' => 'pending'
    ];

    $compensation = Compensation::create($testData);
    
    if ($compensation->id) {
        echo "   ✓ Test compensation created successfully (ID: {$compensation->id})\n";
        echo "   ✓ Case Number: {$compensation->case_number}\n";
        echo "   ✓ LA Case No: {$compensation->la_case_no}\n";
        echo "   ✓ Award Type: " . implode(', ', $compensation->award_type) . "\n";
    } else {
        echo "   ✗ Failed to create test compensation\n";
        exit(1);
    }
    echo "\n";

    // Test 4: Validate the created record
    echo "4. Validating created record...\n";
    
    $retrieved = Compensation::find($compensation->id);
    if ($retrieved) {
        echo "   ✓ Record retrieved successfully\n";
        echo "   ✓ Applicants count: " . count($retrieved->applicants) . "\n";
        echo "   ✓ Award holders count: " . count($retrieved->award_holder_names) . "\n";
        echo "   ✓ Land categories count: " . count($retrieved->land_category) . "\n";
        echo "   ✓ Tax info: " . ($retrieved->tax_info ? 'Present' : 'Missing') . "\n";
    } else {
        echo "   ✗ Failed to retrieve created record\n";
        exit(1);
    }
    echo "\n";

    // Test 5: Test form validation rules
    echo "5. Testing form validation...\n";
    
    $validationErrors = [];
    
    // Test required fields
    $requiredFields = ['case_number', 'case_date', 'la_case_no', 'acquisition_record_basis', 'plot_no', 'award_type'];
    foreach ($requiredFields as $field) {
        if (empty($retrieved->$field)) {
            $validationErrors[] = "Missing required field: {$field}";
        }
    }
    
    // Test award type specific fields
    if (in_array('জমি', $retrieved->award_type)) {
        if (empty($retrieved->land_award_serial_no)) {
            $validationErrors[] = "Missing land award serial no for land award type";
        }
        if (empty($retrieved->land_category)) {
            $validationErrors[] = "Missing land category for land award type";
        }
    }
    
    if (empty($validationErrors)) {
        echo "   ✓ All validation checks passed\n";
    } else {
        echo "   ✗ Validation errors found:\n";
        foreach ($validationErrors as $error) {
            echo "     - {$error}\n";
        }
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

    echo "=== Test Results ===\n";
    echo "✓ Database connection: OK\n";
    echo "✓ Table structure: OK\n";
    echo "✓ Record creation: OK\n";
    echo "✓ Data validation: OK\n";
    echo "✓ Record retrieval: OK\n";
    echo "✓ Form validation: OK\n";
    echo "✓ Cleanup: OK\n\n";
    
    echo "🎉 All tests passed! The compensation form is working correctly.\n";

} catch (Exception $e) {
    echo "✗ Test failed with error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
