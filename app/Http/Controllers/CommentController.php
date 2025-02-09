<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Menambahkan komentar
    public function addComment(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|integer',
            'comment' => 'required|string|max:500',
        ]);

        // Simpan komentar ke database
        Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
            'parent_comment_id' => null, // Tidak ada parent karena ini komentar utama
        ]);

        return redirect()->back(); // Redirect untuk menghindari duplikasi data saat refresh
    }

    // Menambahkan balasan
    public function addReply(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'parent_comment_id' => 'required|exists:comments,id',
            'reply_comment' => 'required|string|max:255',
        ]);

        // Menyimpan balasan sebagai komentar dengan parent_comment_id
        $comment = new Comment();
        $comment->post_id = $validated['post_id'];
        $comment->user_id = auth()->id();
        $comment->comment = $validated['reply_comment'];
        $comment->parent_comment_id = $validated['parent_comment_id']; // Menandakan ini adalah balasan
        $comment->save();

        return redirect()->back(); // Redirect kembali untuk melihat balasan
    }
    // Menghapus komentar atau balasan
    public function deleteComment(Request $request)
    {
        $validated = $request->validate([
            'comment_id' => 'required|integer',
        ]);

        // Hapus komentar atau balasan dari database
        $comment = Comment::findOrFail($validated['comment_id']);

        // Pastikan hanya user yang memposting yang dapat menghapus
        if ($comment->user_id === Auth::id()) {
            $comment->delete();
        }

        return redirect()->back(); // Redirect untuk menghindari duplikasi data saat refresh
    }
}