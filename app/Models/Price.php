<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city',
        'phase',
        'sector',
        '125_yards',
        '133_yards',
        '200_yards',
        '250_yards',
        '300_yards',
        '400_yards',
        '500_yards',
        '800_yards',
        '1000_yards',
    ];
}
