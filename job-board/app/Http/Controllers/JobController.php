<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\JobListing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
  
    public function index(Request $request)
    {
        ini_set('max_execution_time', 3600);
        $jobs = JobListing::where('status', 'Active')->get();
        return view('jobs.index', compact('jobs'));
      
    }

    public function details($id)
    {
        $job = JobListing::findOrFail($id);
        return view('jobs.details', compact('job'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'application_deadline' => 'nullable|date',
            'status' => 'required|string|in:active,closed',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        JobListing::create($request->all());

        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
    }

    public function edit($id)
    {
        $job = JobListing::findOrFail($id);
        $categories = Category::all();
        return view('jobs.edit', compact('job', 'categories'));
    }

 
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'application_deadline' => 'nullable|date',
            'status' => 'required|string|in:active,closed',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        
        $job =  JobListing::find($id);
        $job->update ( $request->all());
        $job->save();
        return redirect()->route('admin.manage_jobs')->with('success', 'job updated successfully');
    }

    public function destroy($id)
    {
        $job = JobListing::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.manage_jobs')->with('success', 'Job deleted successfully.');
    }

    
    public function saveJob(Request $request)
{
    $jobId = $request->input('job_id');
    $userId = auth()->id();

    try {
        $savedJob = DB::table('saved_jobs')->where('user_id', $userId)->where('job_id', $jobId)->first();

        if ($savedJob) {
            DB::table('saved_jobs')->where('user_id', $userId)->where('job_id', $jobId)->delete();
        } else {
            DB::table('saved_jobs')->insert([
                'user_id' => $userId,
                'job_id' => $jobId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        \Log::error('Error saving job: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'An error occurred while saving the job.']);
    }
}
    
public function savedJobs()
{
    $userId = auth()->id();
    $jobs = JobListing::whereIn('id', function($query) use ($userId) {
        $query->select('job_id')
              ->from('saved_jobs')
              ->where('user_id', $userId);
    })->get();

    return view('candidates.saved_jobs', compact('jobs'));
}
public function unsaveJob($jobId)
{
    $user = Auth::user();
    $user->savedJobs()->detach($jobId);
    return redirect()->back()->with('success', 'Job removed from saved jobs.');
}


}
