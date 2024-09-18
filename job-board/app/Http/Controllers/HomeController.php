<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Category;
use App\Models\JobListing;

class HomeController extends Controller
{
    /**
     * Display the home page with categories, featured jobs, and latest jobs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch settings
        $settings = Setting::first();
        
        $categories = Category::all();

        return view('home.home', compact('settings', 'categories'));
    }



}

