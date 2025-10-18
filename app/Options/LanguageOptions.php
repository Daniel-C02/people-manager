<?php

namespace App\Options;

class LanguageOptions
{
    /**
     * Get the available language options.
     *
     * @return array
     */
    public static function get(): array
    {
        return [
            'English',
            'Afrikaans',
            'Zulu',
            'Xhosa',
            'Sotho',
        ];
    }
}
