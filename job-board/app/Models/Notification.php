<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'data', 'read_at','status'
    ];

    protected $casts = [
        'data' => 'array', // Assuming 'data' is stored as JSON
    ];
}
