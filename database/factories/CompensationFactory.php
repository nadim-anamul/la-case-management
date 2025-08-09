<?php

namespace Database\Factories;

use App\Models\Compensation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compensation>
 */
class CompensationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $acquisitionBasis = $this->faker->randomElement(['SA', 'RS']);
        
        return [
            'case_number' => 'COMP-' . $this->faker->unique()->numberBetween(1000, 9999),
            'case_date' => $this->faker->date('Y-m-d'),
            'sa_plot_no' => $acquisitionBasis === 'SA' ? 'SA-' . $this->faker->numberBetween(100, 999) : null,
            'rs_plot_no' => $acquisitionBasis === 'RS' ? 'RS-' . $this->faker->numberBetween(100, 999) : null,
            'applicants' => [
                [
                    'name' => $this->faker->name(),
                    'father_name' => $this->faker->name(),
                    'address' => $this->faker->address(),
                    'nid' => $this->faker->numerify('#############'),
                    'mobile' => '01' . $this->faker->numerify('#########')
                ]
            ],
            'la_case_no' => 'LA-' . $this->faker->unique()->numberBetween(1000, 9999),
            'award_type' => [$this->faker->randomElement(['জমি', 'জমি ও গাছপালা', 'অবকাঠামো'])],
            'land_award_serial_no' => 'LAS-' . $this->faker->numberBetween(100, 999),
            'tree_award_serial_no' => null,
            'infrastructure_award_serial_no' => null,
            'acquisition_record_basis' => $acquisitionBasis,
            'plot_no' => 'PLOT-' . $this->faker->numberBetween(100, 999),
            'award_holder_names' => [
                [
                    'name' => $this->faker->name(),
                    'father_name' => $this->faker->name(),
                    'address' => $this->faker->address()
                ]
            ],
            'land_category' => [
                [
                    'category_name' => $this->faker->randomElement(['আবাদি জমি', 'অনাবাদি জমি', 'বাড়িঘর']),
                    'total_land' => $this->faker->randomFloat(2, 1, 10),
                    'total_compensation' => $this->faker->numberBetween(100000, 1000000),
                    'applicant_land' => $this->faker->randomFloat(2, 0.5, 5)
                ]
            ],
            'objector_details' => null,
            'is_applicant_in_award' => $this->faker->boolean(),
            'source_tax_percentage' => $this->faker->randomFloat(2, 0.5, 15.0),
            'tree_compensation' => null,
            'infrastructure_compensation' => null,
            'district' => $this->faker->randomElement(['বগুড়া', 'ঢাকা', 'চট্টগ্রাম', 'রাজশাহী', 'খুলনা', 'সিলেট', 'রংপুর', 'বরিশাল']),
            'upazila' => $this->faker->randomElement(['বগুড়া সদর', 'শিবগঞ্জ', 'শেরপুর', 'দুপচাঁচিয়া', 'আদমদীঘি', 'নন্দীগ্রাম', 'সোনাতলা', 'ধুনট', 'গাবতলী', 'কাহালু', 'সারিয়াকান্দি', 'শাজাহানপুর']),
            'mouza_name' => $this->faker->city(),
            'jl_no' => 'JL-' . $this->faker->numberBetween(100, 999),
            'land_schedule_sa_plot_no' => $acquisitionBasis === 'SA' ? 'SA-PLOT-' . $this->faker->numberBetween(100, 999) : null,
            'land_schedule_rs_plot_no' => $acquisitionBasis === 'RS' ? 'RS-PLOT-' . $this->faker->numberBetween(100, 999) : null,
            'sa_khatian_no' => $acquisitionBasis === 'SA' ? 'SA-KH-' . $this->faker->numberBetween(100, 999) : null,
            'rs_khatian_no' => $acquisitionBasis === 'RS' ? 'RS-KH-' . $this->faker->numberBetween(100, 999) : null,
            'ownership_details' => $this->generateOwnershipDetails($acquisitionBasis),
            'mutation_info' => null,
            'tax_info' => [
                'english_year' => '2024-25',
                'bangla_year' => '১৪৩১-৩২',
                'holding_no' => 'HOLD-' . $this->faker->numberBetween(100, 999),
                'paid_land_amount' => $this->faker->randomFloat(2, 0.5, 5)
            ],
            'additional_documents_info' => [
                'selected_types' => [$this->faker->randomElement(['আপস- বন্টননামা', 'না-দাবি', 'সরেজমিন তদন্ত', 'এফিডেভিট'])],
                'details' => [
                    'আপস- বন্টননামা' => $this->faker->paragraph(),
                    'না-দাবি' => $this->faker->paragraph(),
                    'সরেজমিন তদন্ত' => $this->faker->paragraph(),
                    'এফিডেভিট' => $this->faker->paragraph()
                ]
            ],
            'kanungo_opinion' => null,
            'order_signature_date' => null,
            'signing_officer_name' => null,
            'status' => 'pending'
        ];
    }

    /**
     * Generate ownership details based on acquisition basis
     */
    private function generateOwnershipDetails(string $acquisitionBasis): array
    {
        if ($acquisitionBasis === 'SA') {
            return [
                'sa_info' => [
                    'sa_plot_no' => 'SA-' . $this->faker->numberBetween(100, 999),
                    'sa_khatian_no' => 'SA-KH-' . $this->faker->numberBetween(100, 999),
                    'sa_total_land_in_plot' => $this->faker->randomFloat(2, 5, 20),
                    'sa_land_in_khatian' => $this->faker->randomFloat(2, 2, 10)
                ],
                'sa_owners' => [
                    ['name' => $this->faker->name()]
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => $this->faker->name()]],
                        'recipient_names' => [['name' => $this->faker->name()]],
                        'deed_number' => 'DEED-' . $this->faker->numberBetween(100, 999),
                        'deed_date' => $this->faker->date('Y-m-d'),
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => $applicationType = $this->faker->randomElement(['specific', 'multiple']),
                        'application_specific_area' => $applicationType === 'specific' ? 'SA-' . $this->faker->numberBetween(100, 999) : null,
                        'application_sell_area' => $applicationType === 'specific' ? $this->faker->randomFloat(2, 1, 5) : null,
                        'application_other_areas' => $applicationType === 'multiple' ? 'SA-' . $this->faker->numberBetween(100, 999) . ', SA-' . $this->faker->numberBetween(100, 999) : null,
                        'application_total_area' => $applicationType === 'multiple' ? $this->faker->randomFloat(2, 3, 10) : null,
                        'application_sell_area_other' => $applicationType === 'multiple' ? $this->faker->randomFloat(2, 1, 5) : null,
                        'possession_mentioned' => $this->faker->randomElement(['yes', 'no']),
                        'possession_plot_no' => 'PLOT-' . $this->faker->numberBetween(100, 999),
                        'possession_description' => $this->faker->sentence(),
                        'possession_deed' => $this->faker->randomElement(['yes', 'no']),
                        'possession_application' => $this->faker->randomElement(['yes', 'no']),
                        'mentioned_areas' => 'SA-' . $this->faker->numberBetween(100, 999),
                        'special_details' => null,
                        'tax_info' => $this->faker->optional(0.7)->paragraph()
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => $this->faker->name(),
                    'kharij_case_no' => 'KH-' . $this->faker->numberBetween(100, 999),
                    'kharij_plot_no' => 'KH-PLOT-' . $this->faker->numberBetween(100, 999),
                    'kharij_land_amount' => $this->faker->randomFloat(2, 0.5, 5),
                    'kharij_date' => $this->faker->date('Y-m-d'),
                    'kharij_details' => $this->faker->sentence()
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-' . $this->faker->numberBetween(100, 999),
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ];
        } else {
            return [
                'rs_info' => [
                    'rs_plot_no' => 'RS-' . $this->faker->numberBetween(100, 999),
                    'rs_khatian_no' => 'RS-KH-' . $this->faker->numberBetween(100, 999),
                    'rs_total_land_in_plot' => $this->faker->randomFloat(2, 5, 20),
                    'rs_land_in_khatian' => $this->faker->randomFloat(2, 2, 10),
                    'dp_khatian' => $this->faker->boolean()
                ],
                'rs_owners' => [
                    ['name' => $this->faker->name()]
                ],
                'deed_transfers' => [
                    [
                        'donor_names' => [['name' => $this->faker->name()]],
                        'recipient_names' => [['name' => $this->faker->name()]],
                        'deed_number' => 'DEED-' . $this->faker->numberBetween(100, 999),
                        'deed_date' => $this->faker->date('Y-m-d'),
                        'sale_type' => 'বিক্রয় দলিল',
                        'application_type' => $applicationType = $this->faker->randomElement(['specific', 'multiple']),
                        'application_specific_area' => $applicationType === 'specific' ? 'RS-' . $this->faker->numberBetween(100, 999) : null,
                        'application_sell_area' => $applicationType === 'specific' ? $this->faker->randomFloat(2, 1, 5) : null,
                        'application_other_areas' => $applicationType === 'multiple' ? 'RS-' . $this->faker->numberBetween(100, 999) . ', RS-' . $this->faker->numberBetween(100, 999) : null,
                        'application_total_area' => $applicationType === 'multiple' ? $this->faker->randomFloat(2, 3, 10) : null,
                        'application_sell_area_other' => $applicationType === 'multiple' ? $this->faker->randomFloat(2, 1, 5) : null,
                        'possession_mentioned' => $this->faker->randomElement(['yes', 'no']),
                        'possession_plot_no' => 'PLOT-' . $this->faker->numberBetween(100, 999),
                        'possession_description' => $this->faker->sentence(),
                        'possession_deed' => $this->faker->randomElement(['yes', 'no']),
                        'possession_application' => $this->faker->randomElement(['yes', 'no']),
                        'mentioned_areas' => 'RS-' . $this->faker->numberBetween(100, 999),
                        'special_details' => null,
                        'tax_info' => $this->faker->optional(0.7)->paragraph()
                    ]
                ],
                'applicant_info' => [
                    'applicant_name' => $this->faker->name(),
                    'kharij_case_no' => 'KH-' . $this->faker->numberBetween(100, 999),
                    'kharij_plot_no' => 'KH-PLOT-' . $this->faker->numberBetween(100, 999),
                    'kharij_land_amount' => $this->faker->randomFloat(2, 0.5, 5),
                    'kharij_date' => $this->faker->date('Y-m-d'),
                    'kharij_details' => $this->faker->sentence()
                ],
                'storySequence' => [
                    [
                        'type' => 'দলিলমূলে মালিকানা হস্তান্তর',
                        'description' => 'দলিল নম্বর: DEED-' . $this->faker->numberBetween(100, 999),
                        'itemType' => 'deed',
                        'itemIndex' => 0,
                        'sequenceIndex' => 0
                    ]
                ],
                'currentStep' => 'applicant',
                'completedSteps' => ['info', 'transfers', 'applicant'],
                'rs_record_disabled' => false
            ];
        }
    }

    /**
     * Indicate that the compensation is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'done',
            'order_signature_date' => $this->faker->date('Y-m-d'),
            'signing_officer_name' => $this->faker->name(),
            'kanungo_opinion' => [
                'has_ownership_continuity' => $this->faker->randomElement(['yes', 'no']),
                'opinion_details' => $this->faker->paragraph()
            ]
        ]);
    }

    /**
     * Indicate that the compensation has kanungo opinion.
     */
    public function withKanungoOpinion(): static
    {
        return $this->state(fn (array $attributes) => [
            'kanungo_opinion' => [
                'has_ownership_continuity' => $this->faker->randomElement(['yes', 'no']),
                'opinion_details' => $this->faker->paragraph()
            ]
        ]);
    }

    /**
     * Indicate that the compensation is for RS record basis.
     */
    public function rsRecord(): static
    {
        return $this->state(fn (array $attributes) => [
            'acquisition_record_basis' => 'RS',
            'rs_plot_no' => 'RS-' . $this->faker->numberBetween(100, 999),
            'land_schedule_rs_plot_no' => 'RS-PLOT-' . $this->faker->numberBetween(100, 999),
            'rs_khatian_no' => 'RS-KH-' . $this->faker->numberBetween(100, 999),
            'sa_plot_no' => null,
            'land_schedule_sa_plot_no' => null,
            'sa_khatian_no' => null,
            'ownership_details' => $this->generateOwnershipDetails('RS')
        ]);
    }
} 