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

        // Generate 10 random compensations (mixed use cases)
        Compensation::factory()->count(10)->create();

        // Generate 2 completed compensations
        Compensation::factory()->count(2)->completed()->create();

        // Generate 2 with kanungo opinion
        Compensation::factory()->count(2)->withKanungoOpinion()->create();

        // Generate 2 RS record compensations
        Compensation::factory()->count(2)->rsRecord()->create();

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

        $this->command->info('Compensation records with diverse use cases seeded successfully!');
    }
} 