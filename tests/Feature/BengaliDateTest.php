<?php

namespace Tests\Feature;

use App\Models\Compensation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BengaliDateTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_signature_date_bengali_format()
    {
        // Create a compensation record with English date
        $compensation = Compensation::factory()->create([
            'order_signature_date' => '2024-08-25',
            'signing_officer_name' => 'Test Officer',
            'status' => 'pending'
        ]);

        // Test that the Bengali date accessor works
        $this->assertEquals('২৫/০৮/২০২৪', $compensation->order_signature_date_bengali);

        // Test the API endpoint returns Bengali date
        $response = $this->getJson("/compensation/{$compensation->id}/order");
        $response->assertStatus(200);
        $response->assertJson([
            'order_signature_date' => '২৫/০৮/২০২৪',
            'signing_officer_name' => 'Test Officer'
        ]);
    }

    public function test_order_signature_date_bengali_input_conversion()
    {
        // Create a compensation record
        $compensation = Compensation::factory()->create([
            'status' => 'pending'
        ]);

        // Test updating with Bengali date input
        $response = $this->putJson("/compensation/{$compensation->id}/order", [
            'order_signature_date' => '২৫/০৮/২০২৪',
            'signing_officer_name' => 'Test Officer'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'আদেশ সফলভাবে নিষ্পত্তিকৃত হয়েছে।'
        ]);

        // Verify the date was stored in English format
        $compensation->refresh();
        $this->assertEquals('2024-08-25', $compensation->order_signature_date);
        $this->assertEquals('done', $compensation->status);
    }

    public function test_bengali_date_trait_conversion_methods()
    {
        $compensation = new Compensation();

        // Test English to Bengali conversion
        $bengaliDate = $compensation->convertToBengaliDate('2024-08-25');
        $this->assertEquals('২৫/০৮/২০২৪', $bengaliDate);

        // Test Bengali to English conversion
        $englishDate = $compensation->convertFromBengaliDate('২৫/০৮/২০২৪');
        $this->assertEquals('2024-08-25', $englishDate);

        // Test null handling
        $this->assertNull($compensation->convertToBengaliDate(null));
        $this->assertNull($compensation->convertFromBengaliDate(null));
    }
}
