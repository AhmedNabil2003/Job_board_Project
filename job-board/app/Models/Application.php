<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'job_listing_id', 'cover_letter', 'status'
    ];

    // Define allowed statuses as constants
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';

    // Validate status value
    public function setStatusAttribute($value)
    {
        $allowedStatuses = [self::STATUS_PENDING, self::STATUS_ACCEPTED, self::STATUS_REJECTED];
        if (!in_array($value, $allowedStatuses)) {
            throw new \InvalidArgumentException("Invalid status value");
        }
        $this->attributes['status'] = $value;
    }
}
