<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Options\InterestOptions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table before seeding to avoid duplicates
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Interest::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $interests = InterestOptions::get();

        foreach ($interests as $interestName) {
            Interest::create(['name' => $interestName]);
        }
    }
}
