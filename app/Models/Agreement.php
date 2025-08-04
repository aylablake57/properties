<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'is_agreed',
        'agreement_date',
        'agreement_text',
    ];

    public $casts = [
        'is_agreed' => 'boolean',
        'agreement_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
