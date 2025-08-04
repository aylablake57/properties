<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtype extends Model
{
    use HasFactory;

    protected $table = 'sub_types';

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
