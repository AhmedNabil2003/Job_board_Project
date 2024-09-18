<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\JobListing;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Message;
use App\Models\Application; 
use Carbon\Carbon; 

class AdminController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 3600);
        $this->middleware('auth');
        $this->middleware('role:admin'); 
    }
 

    public function index()
    {

        $users = User::all();
        $jobs = JobListing::all();
        $categories = Category::all();
        $adminCount = User::where('role', 'admin')->count();
        $candidateCount = User::where('role', 'candidate')->count();
        $employerCount = User::where('role', 'employer')->count();
        $jobCount = $jobs->count();
 
        $totalJobs = JobListing::count();
        $totalCategory = Category::count();
  
        $totalApplications = Application::count();
        $pendingJobs = JobListing::where('status', 'pending')->get();
    
        $totalUsers = User::count();

        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        $messages = Message::orderBy('created_at', 'desc')->get();
     

  
         return view('admin.dashboard', compact('users', 'jobs','categories','totalJobs','totalCategory', 'totalApplications', 'totalUsers', 'newUsers', 
       'pendingJobs','messages','adminCount', 'candidateCount', 'employerCount','jobCount'));
    }

    public function manageUsers()
    {
        $users = User::all();
        return view('admin.manage_users', compact('users'));
    }
    public function activateUser(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_active = true;
            $user->save();
            return redirect()->route('admin.manage_users')->with('status', 'User activated successfully.');
        }
    
        return redirect()->route('admin.manage_users')->with('error', 'User not found.');
    }
    public function deactivateUser($id)
{
    $user = User::find($id);
    if ($user) {
        $user->is_active = false;
        $user->save();
        return redirect()->route('admin.manage_users')->with('status', 'User deactivated successfully.');
    }

    return redirect()->route('admin.manage_users')->with('error', 'User not found.');
}


    public function editUser($id)
    {
        $user = User::find($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->role = $request->input('role');
        $user->save();
        return redirect()->route('admin.manage_users')->with('success', 'User updated successfully');
    }

   
    public function notifyUser(Request $request, $id) {
        $user = User::find($id);
        return redirect()->route('admin.manage_users')->with('success', 'Notification sent successfully');
    }

    public function destroyUser($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('admin.manage_users')->with('success', 'User deleted successfully');
    }
    
    public function manageJobs()
    {
        $jobs = JobListing::with('user')->get();
        return view('admin.manage_jobs', compact('jobs'));
    }

    public function editJob($id)
    {
        $job = JobListing::find($id);
        return view('admin.edit_job', compact('job'));
    }

    public function updateJob(Request $request, $id)
    {
        $job =  JobListing::find($id);
        $job->update ( $request->all());
        $job->save();
        return redirect()->route('admin.manage_jobs')->with('success', 'job updated successfully');
    }


    public function destroyJob($id)
    {
        $jobs = JobListing::find($id);
        $jobs->delete();
        return redirect()->route('admin.manage_jobs')->with('success', 'job deleted successfully');
    }
   
 
    public function manageCategories()
    {
        $categories = Category::all();
        return view('admin.manage_categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());

        return redirect()->route('manage_categories')->with('success', 'Category added successfully.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('manage_categories')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();

        return redirect()->route('manage_categories')->with('success', 'Category deleted successfully.');
    }
    
    public function logo() {
        $settings = Setting::first() ?? new Setting; 
        $user = auth()->user();

        return view('admin.settings', compact('settings', 'user'));
    }
    

    
    public function updateSettings(Request $request) {
        $request->validate([
            'siteName' => 'required|string|max:255',
            'siteLogo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $settings = Setting::first() ?? new Setting;
        if ($settings) {
            $settings->site_name = $request->input('siteName');
    
            if ($request->hasFile('siteLogo')) {
                $logoPath = $request->file('siteLogo');
                $filename = time() . '.' . $logoPath->getClientOriginalExtension();
                $logoPath->storeAs('public/siteLogo', $filename);
                $settings->site_logo = $filename;
            }
    
            $settings->save();
            return redirect()->back()->with('success', 'The settings have been updated successfully.');
        }
    
        return redirect()->back()->with('error', 'No settings found.');
    }
    
    //delete account
    public function deleteAccount($id)
    {
        
        $user = User::find($id);
        
        if ($user) {
            $user->delete();
            return redirect()->route('admin.dashboard')->with('success', 'Account deleted successfully.');
        } else {
            return redirect()->route('home')->with('error', 'User not found.');
        }
    }

   
}
