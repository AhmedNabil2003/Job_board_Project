<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\User;
use App\Models\Message;
use App\Models\Application;

class CandidateController extends Controller
{
    // Return the  dashboard view
    public function dashboard()
    {
        ini_set('max_execution_time', 3600);
        $jobs = Auth::user()->savedJobs;
        $user = Auth::user()->load('profile');
        $totalApplications = Application::where('user_id', Auth::id())->count();
        $messages = Message::where('user_id', Auth::id())->get();
        $newMessagesCount = $messages->where('read', false)->count();
        return view('candidates.dashboard', compact('jobs','user','totalApplications','newMessagesCount'));
    }

    public function savedJobs()
    {
        $jobs = auth()->user()->savedJobs; // Assuming savedJobs is a relationship in User model
        return view('candidates.saved_jobs', compact('jobs'));
    }
 

        public function showPageApp()
    {

        $applications = Application::where('user_id', Auth::id())->get();
        return view('candidates.show_application', compact('applications'));
    }


    public function showMessages()
    {
        $messages = Message::where('user_id', Auth::id())->get();
        $newMessagesCount = $messages->where('read', false)->count();
        
        return view('candidates.messages', compact('messages','newMessagesCount'));
    }
    public function show() {
        $user = auth()->user();

        return view('candidates.settings', compact('user'));
    }
    public function deleteAccount($id)
    {
  
        $user = User::find($id);
        
        if ($user) {
            $user->delete();
            return redirect()->route('candidate.dashboard')->with('success', 'Account deleted successfully.');
        } else {
            return redirect()->route('home')->with('error', 'User not found.');
        }
    }


  
}
