<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'south_african_id',
        'mobile_number',
        'email',
        'birth_date',
        'language',
    ];

    /**
     * Handle specific data types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Automatically convert the 'birth_date' column to/from a Carbon instance
        'birth_date' => 'date',
    ];

    /**
     * The interests that belong to the person.
     */
    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class);
    }

    /**
     * Get the user's formatted birthdate.
     *
     * @return Attribute
     */
    protected function formattedBirthDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->birth_date ? $this->birth_date->format('d M Y') : null,
        );
    }
}
