<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSearchLog extends Model
{
    use HasFactory;
    protected $table = 'user_search_logs';
    protected $fillable = [
        'created_at', //created_at fillable added by Asim
        'search_query', 
        // By Asfia
        'location',
        'type',
        'sub_type',
    ];
}
