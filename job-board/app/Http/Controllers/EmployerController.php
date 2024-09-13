<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;

class EmployerController extends Controller
{
    public function dashboard()
    {
        ini_set('max_execution_time', 3600);
        // Return the employer dashboard view
        return view('employers.dashboard');
    }

    public function jobListings()
    {
        $jobs = JobListing::where('employer_id', auth()->id())->get();
        return view('employers.job_listings', compact('jobs'));
    }

    // Additional methods for employer functionalities
}
