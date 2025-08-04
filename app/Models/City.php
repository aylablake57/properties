<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'name',
    ];
 
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}