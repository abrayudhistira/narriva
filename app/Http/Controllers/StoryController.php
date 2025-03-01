<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    /**
     * Menampilkan semua story aktif (belum expired).
     */
    // app/Http/Controllers/StoryController.php
    // app/Http/Controllers/StoryController.php
    public function index()
    {
        $stories = \App\Models\Story::all();

        // Buat instance finfo untuk mendeteksi MIME type
        $finfo = new \finfo(FILEINFO_MIME_TYPE);

        $stories->transform(function ($story) use ($finfo) {
            // Deteksi MIME type dari data binary
            $mimeType = $finfo->buffer($story->image);

            // Konversi gambar ke base64
            $story->image_base64 = base64_encode($story->image);
            $story->mime = $mimeType; // Simpan MIME type (contoh: image/jpeg, image/png)
            return $story;
        });

        return view('stories.index', compact('stories'));
    }
    /**
     * Upload story baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Debug request
        \Log::info('Data request:', $request->all());

        // Cek apakah file terupload
        if ($request->hasFile('image')) {
            $image = $request->file('image')->get();
            \Log::info('Data image:', ['size' => strlen($image)]);

            Story::create([
                'user_id' => Auth::id(),
                'image' => $image,
            ]);

            return redirect()->back()->with('success', 'Post berhasil dibuat!');
        }

        return response()->json(['message' => 'Gagal mengunggah story.'], 400);
    }
    /**
     * Menampilkan detail story berdasarkan ID.
     */
    public function show($id)
    {
        // Cari story berdasarkan ID dan pastikan story masih aktif
        $story = Story::active()->findOrFail($id);

        // Kembalikan data dalam format JSON
        return response()->json([
            'success' => true,
            'stories' => [$story], // Mengembalikan array karena JavaScript mengharapkan array
        ]);
    }
    /**
     * Menghapus story berdasarkan ID.
     */
    public function destroy($id)
    {
        // Cari story berdasarkan ID
        $story = Story::findOrFail($id);

        // Hapus story
        $story->delete();

        return response()->json([
            'success' => true,
            'message' => 'Story berhasil dihapus!',
        ]);
    }
}