<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $imageData = null;

        if ($request->hasFile('image')) {
            $imageData = file_get_contents($request->file('image')->getRealPath());
        }

        $post = new Post();
        $post->user_id = auth()->id();
        $post->caption = $request->input('caption');
        $post->image = $imageData;
        $post->save();

        return redirect()->route('posts.index');
    }

    public function index()
    {
        // $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
        // return view('posts.index', compact('posts'));
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function comment(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required',
        ]);

        auth()->user()->comments()->create([
            'post_id' => $request->post_id,
            'comment' => $request->comment,
        ]);

        return redirect()->route('dashboard');
    }

    public function reply(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required',
            'parent_comment_id' => 'required|exists:comments,id',
        ]);

        auth()->user()->comments()->create([
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'parent_comment_id' => $request->parent_comment_id,
        ]);

        return redirect()->route('dashboard');
    }
}
