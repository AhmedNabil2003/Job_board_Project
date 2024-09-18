<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    
    public function savedJobs()
    {
        return $this->belongsToMany(JobListing::class, 'saved_jobs', 'user_id', 'job_id');
    }
    public function jobs()
    {
    return $this->hasMany(JobListing::class, 'user_id');
    }
    
    public function applications()
    {
    return $this->hasMany(Application::class, 'user_id');
    }
   
   
}

