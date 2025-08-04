<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comments',
        'suggestions',
        'rating',
        'status',
    ];

    // By Asfia
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
