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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $profile = $user->profile ?: new Profile(['user_id' => $user->id]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');  // تعريف المتغير $file
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_pictures', $filename);  // استخدام المتغير $file لتخزين الصورة
            $profile->profile_image = $filename;
        }

        $profile->bio = $request->input('bio');
        $profile->save();

        return redirect()->route('profile.show', ['id' => $user->id])->with('status', 'Profile updated successfully.');
    }
}
