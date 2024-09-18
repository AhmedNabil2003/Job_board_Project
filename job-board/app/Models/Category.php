<?php

namespace App\Models;
use App\Models\Category; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function jobs()
    {
        return $this->hasMany(JobListing::class);
    }

    public function showCreateForm()
    {
        $categories = Category::all(); 
        return view('employers.create_jobs', compact('categories'));
    }
    
}
