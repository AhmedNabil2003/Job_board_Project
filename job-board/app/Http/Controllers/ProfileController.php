<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller
{
    // Display the user profile
    public function show($id)
    {
        $user = User::with('profile')->findOrFail($id);
        return view('profiles.show', compact('user'));
    }

    // Display the edit profile form
    public function edit($id)
    {
        $user = User::with('profile')->findOrFail($id);
        return view('profiles.edit', compact('user'));
    }

    // Update the user profile
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
            'company_name' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

 
        $user = User::findOrFail($id);

 
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

  
        $filename = $user->profile->profile_image ?? null;

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_pictures', $filename);
        }

    
        $profile = $user->profile ?: new Profile(['user_id' => $user->id]);

        $profile->profile_image = $filename;
        $profile->bio = $request->input('bio', $profile->bio);
        $profile->company_name = $request->input('company_name', $profile->company_name);
        $profile->location = $request->input('location', $profile->location);
        $profile->save();

        return redirect()->route('profile.show', ['id' => $user->id])->with('status', 'Profile updated successfully.');
    }
}