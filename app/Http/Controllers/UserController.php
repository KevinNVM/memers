<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    function profile()
    {
        return view('user.profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:3', // nullable because password is optional
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image file
        ]);

        // Find the user based on your logic (e.g., by user ID or email)
        $user = User::find(Auth::user()->id); // Replace $userId with the actual user ID

        if (!$user) {
            return abort(404, 'User not found');
        }

        // Update the username
        $user->username = $request->input('username');

        // Update the password if it exists in the request
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Check if a new image file was uploaded
        if ($request->hasFile('image')) {
            // Get the uploaded image file
            $imageFile = $request->file('image');

            // Store the new image in a folder (e.g., "public/images")
            // Make sure to configure the filesystem to use the "public" disk in the "config/filesystems.php" file
            $imagePath = $imageFile->store('public/images');

            // Update the user's image path in the database
            $user->image = $imagePath;
        }

        // Save the changes
        $user->save();

        return redirect()->back();
    }
}
