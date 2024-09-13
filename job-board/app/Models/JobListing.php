<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    protected $table = 'jobs_listings';

    protected $fillable = [
        'user_id', 'title', 'description', 'requirements', 'location', 'job_type', 'salary_min', 'salary_max', 'application_deadline', 'status', 'category_id'
    ];

    // Define allowed statuses as constants
    const STATUS_ACTIVE = 'active';
    const STATUS_CLOSED = 'closed';

    protected $casts = [
        'status' => 'string',
    ];

    // Set default value for status
    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    // Validate and set status
    public function setStatusAttribute($value)
    {
        $allowedStatuses = [self::STATUS_ACTIVE, self::STATUS_CLOSED];
        if (!in_array($value, $allowedStatuses)) {
            throw new \InvalidArgumentException("Invalid status value");
        }
        $this->attributes['status'] = $value;
    }
}
