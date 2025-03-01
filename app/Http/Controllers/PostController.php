<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Story;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|string|max:255',
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

        return redirect()->back()->with('success', 'Post berhasil dibuat!');
    }

    public function index()
    {
        //$posts = Post::with(['user', 'comments.replies', 'comments.user'])->latest()->get();
        //$posts = Post::with(['user', 'comments.user', 'comments.replies.user'])->latest()->get();
        $posts = Post::with(['comments' => function ($query) {
            $query->whereNull('parent_comment_id') // Ambil hanya komentar utama
                  ->with(['replies' => function ($query) {
                      $query->whereNotNull('parent_comment_id'); // Ambil balasan untuk setiap komentar
                  }]);
        }])->latest()->get();

        // Ambil semua story aktif (belum expired)
        $stories = Story::active()->with('user')->get();

        // Mengambil rekomendasi user untuk diikuti
        $recommendations = User::where('id', '!=', auth()->id())
            ->whereDoesntHave('followers', fn($query) => $query->where('follower_id', auth()->id()))
            ->limit(25)
            ->get();

        return view('posts.index', compact('posts', 'recommendations','stories'));
    }

    public function comment(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:255',
        ]);

        auth()->user()->comments()->create([
            'post_id' => $request->post_id,
            'comment' => $request->comment,
        ]);

        return redirect()->route('posts.index')->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function reply(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:255',
            'parent_comment_id' => 'required|exists:comments,id',
        ]);

        auth()->user()->comments()->create([
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'parent_comment_id' => $request->parent_comment_id,
        ]);

        return redirect()->route('posts.index')->with('success', 'Balasan berhasil ditambahkan!');
    }
}
