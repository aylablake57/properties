<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertySubType extends Model
{
    use HasFactory;
    protected $table = 'sub_types';
    protected $fillable = ['type_id', 'name'];

    public function type()
    {
        return $this->belongsTo(PropertyType::class);
    }
}
