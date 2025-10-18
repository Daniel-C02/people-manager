<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method is responsible for populating the 'people' table
     * and attaching interests to each person.
     */
    public function run(): void
    {
        // Get all interest IDs to attach them to people randomly
        $interestIds = Interest::pluck('id')->all();

        if (empty($interestIds)) {
            $this->command->warn('No interests found. Please run the InterestSeeder first.');
            return;
        }

        // Use the Person model's factory to generate 50 new records
        Person::factory()->count(50)->create()->each(function ($person) use ($interestIds) {
            // Attach a random number of interests (between 1 and 5) to each person
            $interestsToAttach = (array) array_rand(array_flip($interestIds), rand(1, 5));
            $person->interests()->attach($interestsToAttach);
        });
    }
}
