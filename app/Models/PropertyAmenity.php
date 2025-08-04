<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyAmenity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "amenity_property";
    protected $fillable = ['amenity_id'];

    public function amenity(): BelongsTo
    {
        return $this->belongsTo(Amenity::class);
    }
}
