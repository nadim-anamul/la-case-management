<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the ModularCompensationSeeder for better organization
        $this->call([
            ModularCompensationSeeder::class,
        ]);
    }
}
