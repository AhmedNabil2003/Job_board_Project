<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JobListing extends Model
{
    use HasFactory;

    protected $table = 'jobs_listings';

    protected $fillable = [
        'user_id', 'title', 'description',  'requirements', 'location', 'job_type', 'salary_min', 'salary_max', 'application_deadline', 'status', 'category_id'
    ];

    // Define allowed statuses as constants
    const STATUS_ACTIVE = 'Active';
    const STATUS_CLOSED = 'Closed';

    public function getApplicationDeadlineAttribute($value)
    {
        return Carbon::parse($value);
    }
    // Allowed statuses array
    public static $allowedStatuses = [
        self::STATUS_ACTIVE,
        self::STATUS_CLOSED,
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Set default value for status
    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Validate and set status
   
    // Optional: Add a helper function to get all allowed statuses
    public static function getAllowedStatuses()
    {
        return self::$allowedStatuses;
    }
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_jobs', 'job_id', 'user_id');
    }

    public function applications()
{
    return $this->hasMany(Application::class);
}

}
