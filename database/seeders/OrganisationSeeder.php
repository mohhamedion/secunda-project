<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organisation::factory()
            ->withActivities(rand(0,10))
            ->withPhoneNumbers(rand(0,5))
            ->count(200)
            ->create();
    }
}
