<?php

namespace Database\Factories;

use App\Models\Person;
use App\Options\InterestOptions;
use App\Options\LanguageOptions;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Person>
 */
class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Generates a valid South African ID number and the corresponding birthdate.
     *
     * @return array{'id': string, 'birth_date': \DateTime}
     */
    private function generateValidIdNumber(): array
    {
        // 1. Generate Birthdate (YYMMDD)
        // We'll generate a person between 18 and 80 years old.
        $birthDate = $this->faker->dateTimeBetween('-80 years', '-18 years');
        $idDate = $birthDate->format('ymd');

        // 2. Generate Gender/Sequence (SSSS - 4 digits)
        // 0000-4999 for female, 5000-9999 for male
        $genderDigits = $this->faker->numberBetween(0, 9999);
        $ssss = str_pad($genderDigits, 4, '0', STR_PAD_LEFT);

        // 3. Citizenship (C - 1 digit)
        // 0 for SA citizen, 1 for permanent resident
        $c = $this->faker->randomElement([0, 1]);

        // 4. "A" digit (A - 1 digit)
        // This is usually 8.
        $a = 8;

        // 5. Combine first 12 digits
        $first12 = $idDate . $ssss . $c . $a;

        // 6. Calculate Checksum (Z - 1 digit)
        // This logic is copied directly from your SouthAfricanIdNumber rule
        $sumOdd = 0;
        $evenDigits = '';

        for ($i = 0; $i < 12; $i++) {
            if (($i + 1) % 2 === 0) { // Even position
                $evenDigits .= $first12[$i];
            } else { // Odd position
                $sumOdd += (int) $first12[$i];
            }
        }

        $evenNum = (int) $evenDigits * 2;
        $sumEven = 0;
        foreach (str_split((string) $evenNum) as $digit) {
            $sumEven += (int) $digit;
        }

        $totalSum = $sumOdd + $sumEven;
        $checksum = (10 - ($totalSum % 10)) % 10;

        // 7. Combine for final 13-digit ID
        $idNumber = $first12 . $checksum;

        return [
            'id' => $idNumber,
            'birth_date' => $birthDate,
        ];
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get the predefined lists of options
        $languageOptions = LanguageOptions::get();

        // Generate the valid ID and its corresponding birthdate
        $idData = $this->generateValidIdNumber();

        return [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            // Use the generated valid ID
            'south_african_id' => $idData['id'],
            'mobile_number' => '+27' . $this->faker->numerify('#########'),
            'email' => $this->faker->unique()->safeEmail,
            'birth_date' => $this->faker->date(),
            // Pick a random language from our options class
            'language' => $this->faker->randomElement($languageOptions),
        ];
    }
}

