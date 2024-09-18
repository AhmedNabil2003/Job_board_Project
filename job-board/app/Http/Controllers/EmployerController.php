<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Category; 
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\JobListing;
use App\Models\Message;
use App\Models\Application; 
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminActionNotification;

class EmployerController extends Controller
{
   
    public function index()
    {
        $users = User::all();
        $categories = Category::withCount(['jobs' => function ($query) {
            $query->where('user_id', auth()->user()->id); // //count jobs employer 
        }])->get();
        $jobs = JobListing::where('user_id', auth()->user()->id)->get(); 
        $userJobIds = JobListing::where('user_id', Auth::id())->pluck('id');
        $candidateCount = Application::whereIn('job_id', $userJobIds)->distinct('user_id')->count('user_id');
        $userJobs = JobListing::where('user_id', Auth::id())->pluck('id');
        $totalApplications = Application::whereIn('job_id', $userJobs)->count();
        $totalJobs = $jobs->count();
        $pendingJobs = JobListing::where('status', 'pending')->get();
        $messages = Message::orderBy('created_at', 'desc')->get();
        $recentApplications = Application::orderBy('created_at', 'desc')->take(5)->count();

        return view('employers.dashboard',
         compact('totalJobs', 
         'totalApplications',
         'candidateCount',
         'categories', 
           'pendingJobs', 
           'recentApplications', 
            'messages'
        ));
    }

    // show jobs_users & manage Jobs
    public function manageJobs()
    {
        $jobs = JobListing::where('user_id', auth()->user()->id)->get();
        return view('employers.manage_jobs', compact('jobs'));
    }

    // edit Job
    public function editJob($id)
    {
        $job = JobListing::findOrFail($id);
        return view('employers.edit_job', compact('job'));
    }

    // update Job
    public function updateJob(Request $request, $id)
    {
        $job =  JobListing::find($id);
        $job->update ( $request->all());
        return redirect()->route('employer.manage_jobs')->with('success', 'Job updated successfully');
    }
    //show category
    public function showCreate()
    {
        $categories = Category::all(); 
        return view('employers.create_jobs', compact('categories')); 
    }
    //  create job
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|array',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|max:50',
            'salary_min' => 'required|numeric|min:0',
            'salary_max' => 'required|numeric|gte:salary_min',
            'application_deadline' => 'required|date',
            'category_id' => 'nullable|integer|exists:categories,id' 
        ]);

        JobListing::create([
            'user_id' => auth()->user()->id,
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
           'requirements' => $validatedData['requirements'] ? implode(', ', $validatedData['requirements']) : null,
            'location' => $validatedData['location'],
            'job_type' => $validatedData['job_type'],
            'salary_min' => $validatedData['salary_min'],
            'salary_max' => $validatedData['salary_max'],
            'application_deadline' => $validatedData['application_deadline'],
            'category_id' => $validatedData['category_id']
        ]);      
        return redirect()->route('employer.manage_jobs')->with('success', 'Job created successfully!');
    }

    
    // delete Job
    public function destroyJob($id)
    {
        $job = JobListing::findOrFail($id);
        $job->delete();

        return redirect()->route('employer.manage_jobs')->with('success', 'Job deleted successfully');
    }

   
    public function showPageApp()
    {
       
        $userJobs = JobListing::where('user_id', Auth::id())->pluck('id');
        
        $applications = Application::whereIn('job_id', $userJobs)
                                ->with('job','user')
                                ->get();
        
        return view('employers.show_application', compact('applications'));
    }

    public function showApplication($id)
    {
        $application = Application::where('id', $id)
                                ->whereHas('job', function ($query) {
                                    $query->where('user_id', Auth::id());
                                })
                                ->with('job','user') 
                                ->firstOrFail();
        
        return view('employers.show_application', compact('application'));
    }


    public function acceptApplication($id)
    {
        $application = Application::findOrFail($id);
        
        // Update application status (optional)
        $application->status = 'accepted'; // Add 'status' column to your applications table if necessary
        $application->save();
    
        // Create a message
        $message = new Message();
        $message->user_id = $application->user_id; // Assuming 'user_id' is the candidate's ID
        $message->subject = 'Application Accepted';
        $message->message = 'Congratulations! Your application for the job titled "' . $application->job->title . '" has been accepted.';
        $message->save();
    
        return redirect()->back()->with('success', 'Application accepted and message sent.');
    }




    public function show() {
        $user = auth()->user();

        return view('employers.settings', compact('user'));
    }

    public function deleteAccount($id)
    {
        // تحقق من وجود المستخدم
        $user = User::find($id);
        
        if ($user) {
            // حذف المستخدم
            $user->delete();
            return redirect()->route('employers.dashboard')->with('success', 'Account deleted successfully.');
        } else {
            return redirect()->route('home')->with('error', 'User not found.');
        }
    }

}
