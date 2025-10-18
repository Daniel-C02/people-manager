<?php

namespace App\Options;

class InterestOptions
{
    /**
     * Get the available interest options.
     *
     * @return array
     */
    public static function get(): array
    {
        return [
            'Reading',
            'Sports',
            'Music',
            'Gaming',
            'Traveling',
            'Cooking',
            'Hiking',
            'Photography',
            'Movies',
            'Dancing',
            'Painting',
            'Writing',
            'Yoga',
            'Gardening',
            'Fishing',
            'Coding',
            'Volunteering',
        ];
    }
}
