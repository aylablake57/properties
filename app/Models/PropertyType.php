<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use HasFactory;
    protected $table = 'types';
    protected $fillable = ['name'];

    public function subTypes()
    {
        return $this->hasMany(PropertySubType::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
