<?php

namespace App\Models;

use App\Enums\AreaUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    use HasFactory;

    const SELL = 'sell';
    const RENT = 'rent';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'type' => PropertyType::class,
            /* 'sub_type' => PropertySubType::class, */
            'area_unit' => AreaUnit::class,
        ];
    }

    public function media(): HasMany
    {
        return $this->hasMany(PropertyMedia::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'amenity_property')->withPivot('amenity_value');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subtype(): HasOne
    {
        return $this->HasOne(Subtype::class , 'id' , 'sub_type');
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(\App\Models\PropertyType::class, 'type', 'id');
    }
}
