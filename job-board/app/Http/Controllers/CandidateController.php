<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\Application;

class CandidateController extends Controller
{
    public function dashboard()
    {
        ini_set('max_execution_time', 3600);
        // Return the candidate dashboard view
        return view('candidates.dashboard');
    }

    public function savedJobs()
    {
        $jobs = auth()->user()->savedJobs; // Assuming savedJobs is a relationship in User model
        return view('candidates.saved_jobs', compact('jobs'));
    }

    public function applyForJob(Request $request, $jobId)
    {
        $job = JobListing::findOrFail($jobId);

        Application::create([
            'user_id' => auth()->id(),
            'job_id' => $job->id,
        ]);

        return redirect('jobs')->with('status', 'Application submitted successfully.');
    }

    // Additional methods for candidate functionalities
}
