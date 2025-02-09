<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;

class PublicProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $followers = $user->followers()->count();
        $following = $user->following()->count();
        $posts = $user->posts;

        // Mengambil rekomendasi user untuk diikuti
        $recommendations = User::where('id', '!=', auth()->id())
            ->whereDoesntHave('followers', fn($query) => $query->where('follower_id', auth()->id()))
            ->limit(5)
            ->get();

        return view('profile-public', compact('user', 'followers', 'following', 'posts', 'recommendations'));
    }
}
