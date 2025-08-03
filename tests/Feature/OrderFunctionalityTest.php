<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Compensation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_modal_can_be_opened()
    {
        $compensation = Compensation::create([
            'case_number' => 'CASE-001',
            'case_date' => '2024-01-15',
            'applicants' => [['name' => 'Test Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']],
            'la_case_no' => 'LA-001',
            'award_serial_no' => 'AWD-001',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-001',
            'award_holder_name' => 'Test Holder',
            'is_applicant_in_award' => true,
            'applicant_acquired_land' => '2 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-001',
            'sa_khatian_no' => 'SA-KH-001',
            'land_schedule_sa_plot_no' => 'SA-FP-001',
            'rs_khatian_no' => 'RS-KH-001',
            'land_schedule_rs_plot_no' => 'RS-CP-001',
            'is_applicant_sa_owner' => false,
            'ownership_details' => [],
            'mutation_info' => [],
            'tax_info' => [],
            'additional_documents_info' => [],
            'status' => 'pending'
        ]);

        $response = $this->get("/compensation/{$compensation->id}/order");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'order_signature_date',
            'signing_officer_name'
        ]);
    }

    public function test_order_can_be_updated()
    {
        $compensation = Compensation::create([
            'case_number' => 'CASE-002',
            'case_date' => '2024-01-15',
            'applicants' => [['name' => 'Test Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']],
            'la_case_no' => 'LA-002',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-002',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-002',
            'award_holder_names' => [
                ['name' => 'Test Holder']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '2 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-002',
            'sa_khatian_no' => 'SA-KH-002',
            'land_schedule_sa_plot_no' => 'SA-FP-002',
            'rs_khatian_no' => 'RS-KH-002',
            'land_schedule_rs_plot_no' => 'RS-CP-002',
            'is_applicant_sa_owner' => false,
            'ownership_details' => [],
            'mutation_info' => [],
            'tax_info' => [],
            'additional_documents_info' => [],
            'status' => 'pending'
        ]);

        $orderData = [
            'order_signature_date' => '2024-12-01',
            'signing_officer_name' => 'জনাব আহমেদ'
        ];

        $response = $this->put("/compensation/{$compensation->id}/order", $orderData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'আদেশ সফলভাবে নিষ্পত্তিকৃত হয়েছে।'
        ]);

        // Check if compensation status is updated
        $compensation->refresh();
        $this->assertEquals('done', $compensation->status);
        $this->assertEquals('2024-12-01', $compensation->order_signature_date);
        $this->assertEquals('জনাব আহমেদ', $compensation->signing_officer_name);
    }

    public function test_order_validation_works()
    {
        $compensation = Compensation::create([
            'case_number' => 'CASE-003',
            'case_date' => '2024-01-15',
            'applicants' => [['name' => 'Test Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']],
            'la_case_no' => 'LA-003',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-003',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-003',
            'award_holder_names' => [
                ['name' => 'Test Holder']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '2 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-003',
            'sa_khatian_no' => 'SA-KH-003',
            'land_schedule_sa_plot_no' => 'SA-FP-003',
            'rs_khatian_no' => 'RS-KH-003',
            'land_schedule_rs_plot_no' => 'RS-CP-003',
            'is_applicant_sa_owner' => false,
            'ownership_details' => [],
            'mutation_info' => [],
            'tax_info' => [],
            'additional_documents_info' => [],
            'status' => 'pending'
        ]);

        // Test missing required fields
        $response = $this->put("/compensation/{$compensation->id}/order", []);
        $response->assertStatus(500);

        // Test invalid date
        $response = $this->put("/compensation/{$compensation->id}/order", [
            'order_signature_date' => 'invalid-date',
            'signing_officer_name' => 'জনাব আহমেদ'
        ]);
        $response->assertStatus(500);
    }

    public function test_compensation_list_filters_by_status()
    {
        // Create pending compensation
        Compensation::create([
            'case_number' => 'CASE-PENDING',
            'case_date' => '2024-01-15',
            'applicants' => [['name' => 'Pending Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']],
            'la_case_no' => 'LA-PENDING',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-PENDING',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-PENDING',
            'award_holder_names' => [
                ['name' => 'Test Holder']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '2 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-PENDING',
            'sa_khatian_no' => 'SA-KH-PENDING',
            'land_schedule_sa_plot_no' => 'SA-FP-PENDING',
            'rs_khatian_no' => 'RS-KH-PENDING',
            'land_schedule_rs_plot_no' => 'RS-CP-PENDING',
            'is_applicant_sa_owner' => false,
            'ownership_details' => [],
            'mutation_info' => [],
            'tax_info' => [],
            'additional_documents_info' => [],
            'status' => 'pending'
        ]);

        // Create done compensation
        Compensation::create([
            'case_number' => 'CASE-DONE',
            'case_date' => '2024-01-15',
            'applicants' => [['name' => 'Done Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']],
            'la_case_no' => 'LA-DONE',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-DONE',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-DONE',
            'award_holder_names' => [
                ['name' => 'Test Holder']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '2 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-DONE',
            'sa_khatian_no' => 'SA-KH-DONE',
            'land_schedule_sa_plot_no' => 'SA-FP-DONE',
            'rs_khatian_no' => 'RS-KH-DONE',
            'land_schedule_rs_plot_no' => 'RS-CP-DONE',
            'is_applicant_sa_owner' => false,
            'ownership_details' => [],
            'mutation_info' => [],
            'tax_info' => [],
            'additional_documents_info' => [],
            'status' => 'done'
        ]);

        // Test pending filter (default)
        $response = $this->get('/compensations');
        $response->assertStatus(200);
        $response->assertSee('LA-PENDING');
        $response->assertDontSee('LA-DONE');

        // Test done filter
        $response = $this->get('/compensations?status=done');
        $response->assertStatus(200);
        $response->assertSee('LA-DONE');
        $response->assertDontSee('LA-PENDING');
    }

    public function test_compensation_list_search_functionality()
    {
        Compensation::create([
            'case_number' => 'CASE-SEARCH',
            'case_date' => '2024-01-15',
            'applicants' => [['name' => 'Search Applicant', 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']],
            'la_case_no' => 'LA-SEARCH-123',
            'award_type' => 'জমি',
            'award_serial_no' => 'AWD-SEARCH',
            'acquisition_record_basis' => 'SA',
            'plot_no' => 'PLOT-SEARCH',
            'award_holder_names' => [
                ['name' => 'Test Holder']
            ],
            'is_applicant_in_award' => true,
            'source_tax_percentage' => '3%',
            'applicant_acquired_land' => '2 acres',
            'mouza_name' => 'Test Mouza',
            'jl_no' => 'JL-SEARCH',
            'sa_khatian_no' => 'SA-KH-SEARCH',
            'land_schedule_sa_plot_no' => 'SA-FP-SEARCH',
            'rs_khatian_no' => 'RS-KH-SEARCH',
            'land_schedule_rs_plot_no' => 'RS-CP-SEARCH',
            'is_applicant_sa_owner' => false,
            'ownership_details' => [],
            'mutation_info' => [],
            'tax_info' => [],
            'additional_documents_info' => [],
            'status' => 'pending'
        ]);

        // Test search by LA case number
        $response = $this->get('/compensations?search=LA-SEARCH-123');
        $response->assertStatus(200);
        $response->assertSee('LA-SEARCH-123');

        // Test search by applicant name
        $response = $this->get('/compensations?search=Search Applicant');
        $response->assertStatus(200);
        $response->assertSee('Search Applicant');
    }

    public function test_pagination_works()
    {
        // Create more than 10 compensations to test pagination
        for ($i = 1; $i <= 15; $i++) {
            Compensation::create([
                'case_number' => "CASE-PAGINATION-{$i}",
                'case_date' => '2024-01-15',
                'applicants' => [['name' => "Applicant {$i}", 'father_name' => 'Test Father', 'address' => 'Test Address', 'nid' => '1234567890']],
                'la_case_no' => "LA-PAGINATION-{$i}",
                'award_serial_no' => "AWD-PAGINATION-{$i}",
                'acquisition_record_basis' => 'SA',
                'plot_no' => "PLOT-PAGINATION-{$i}",
                'award_holder_name' => 'Test Holder',
                'is_applicant_in_award' => true,
                'source_tax_percentage' => '3%',
                'applicant_acquired_land' => '2 acres',
                'mouza_name' => 'Test Mouza',
                'jl_no' => "JL-PAGINATION-{$i}",
                'sa_khatian_no' => "SA-KH-PAGINATION-{$i}",
                'land_schedule_sa_plot_no' => "SA-FP-PAGINATION-{$i}",
                'rs_khatian_no' => "RS-KH-PAGINATION-{$i}",
                'land_schedule_rs_plot_no' => "RS-CP-PAGINATION-{$i}",
                'is_applicant_sa_owner' => false,
                'ownership_details' => [],
                'mutation_info' => [],
                'tax_info' => [],
                'additional_documents_info' => [],
                'status' => 'pending'
            ]);
        }

        $response = $this->get('/compensations');
        $response->assertStatus(200);
        
        // Should show pagination links (Laravel's default pagination)
        $response->assertSee('Showing');
    }
}
