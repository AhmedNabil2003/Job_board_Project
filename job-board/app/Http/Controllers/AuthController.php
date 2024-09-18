<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminActionNotification;
use App\Models\User; 

class AuthController extends Controller
{

    public function showLoginForm()
    {
        ini_set('max_execution_time', 3600);
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = ['email' => $validated['email'], 'password' => $validated['password']];
         if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->is_active) {
                return redirect()->intended('/dashboard'); 
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is not activated.',
                ]);
            }
        } else {
            return back()->withErrors([
                'email' => 'The email or password is incorrect.',
            ]);
        }
    }    
    

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

  
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|in:employer,candidate,admin',
            
        ];

 
        if ($request->input('role') === 'admin') {
           
            $rules['password'] .= '|min:0'; 
        } else {
       
            $rules['password'] .= '|min:8';
        }

        $validated = $request->validate($rules);

        User::create([ 
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'is_active' => true,
        ]);

        return redirect()->route('login')->with('status', 'Registration successful. Please log in.');
    }

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
