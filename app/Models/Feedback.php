<?php

namespace App\Models;

use App\Enums\FeedbackStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'rating',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => FeedbackStatus::class,
        ];
    }

    // By Asfia
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
