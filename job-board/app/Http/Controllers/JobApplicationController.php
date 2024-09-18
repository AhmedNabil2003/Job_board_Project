<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
   
    public function showForm(JobListing $job)
    {
        return view('candidates.job-application', compact('job'));
    }
    public function submitApplication(Request $request, JobListing $job)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
    
        try {
            // Handle file upload
            $resumePath = $request->file('resume')->store('resumes', 'public');
    
            // Save application data
            Application::create([
                'user_id' => Auth::id(),
                'job_id' => $job->id,
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'resume' => $resumePath,
            ]);
    
            return redirect()->route('jobs.index')->with('status', 'Application submitted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function showApplication($id)
    {
       
        $application = Application::where('id', $id)
                                  ->where('user_id', Auth::id())
                                  ->firstOrFail();
        return view('candidates.show_application', compact('application'));
    }
};