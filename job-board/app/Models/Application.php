<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'job_applications'; 

    protected $fillable = ['user_id', 'job_id', 'email', 'phone', 'resume'];


    public function job()
    {
        return $this->belongsTo(JobListing::class, 'job_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
