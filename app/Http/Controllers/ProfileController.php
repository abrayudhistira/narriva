<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Post;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($request->hasFile('profile_picture')) {
            $user->profile_picture = file_get_contents($request->file('profile_picture')->getRealPath());
        }

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    // public function show(User $user)
    // {
    //     $followers = $user->followers()->count();
    //     $following = $user->following()->count();
    //     $posts = Post::where('user_id', $user->id)->count();

    //     return view('profile.show', compact('user', 'followers', 'following', 'posts'));
    // }
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $followers = $user->followers()->count(); // Assuming relationship exists
        $following = $user->following()->count(); // Assuming relationship exists
        $posts = Post::where('user_id', $user->id)->get();

        return view('profile-public', compact('user', 'followers', 'following', 'posts'));
    }
}
