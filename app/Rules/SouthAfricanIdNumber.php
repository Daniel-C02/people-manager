<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SouthAfricanIdNumber implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        // 1. Check format: 13 digits and numeric
        if (!is_string($value) || strlen($value) !== 13 || !ctype_digit($value)) {
            return false;
        }

        // 2. Perform the Luhn checksum validation
        $sum = 0;
        $oddEven = false;

        for ($i = 0; $i < 12; $i++) {
            $digit = (int) $value[$i];

            if ($oddEven) { // Even position digits (2nd, 4th, 6th...)
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            // Odd position digits are added as-is

            $sum += $digit;
            $oddEven = !$oddEven; // Flip for the next iteration
        }

        // Alternative Luhn algorithm (as some implementations differ)
        // This is a common implementation for SA ID:

        $sumOdd = 0;
        $evenDigits = '';

        for ($i = 0; $i < 12; $i++) {
            if (($i + 1) % 2 === 0) { // Even position (2, 4, 6...)
                $evenDigits .= $value[$i];
            } else { // Odd position (1, 3, 5...)
                $sumOdd += (int) $value[$i];
            }
        }

        $evenNum = (int) $evenDigits * 2;
        $sumEven = 0;
        foreach (str_split((string) $evenNum) as $digit) {
            $sumEven += (int) $digit;
        }

        $totalSum = $sumOdd + $sumEven;
        $checksum = (10 - ($totalSum % 10)) % 10;

        // The calculated checksum must match the 13th digit
        return $checksum === (int) $value[12];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute is not a valid South African ID number.';
    }
}
