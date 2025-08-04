<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'reviews';

    // Allow mass assignment on these fields
    protected $fillable = [
        'name',
        'email',
        'reviewRating',
        'message',
    ];
}

