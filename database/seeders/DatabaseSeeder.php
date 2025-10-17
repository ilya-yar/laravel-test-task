<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Business;
use App\Models\Organisation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!User::where('email', 'test@example.com')->first()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            BuildingSeeder::class,
            BusinessSeeder::class,
            OrganisationSeeder::class,
        ]);
    }
}
