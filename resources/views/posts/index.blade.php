<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Feed Postingan') }}
        </h2>
    </x-slot>

<!-- Style Custom -->
<style>
  /* Container Gambar Postingan */
  .post-img-container {
    width: 100%;
    max-width: 550px;  /* Maksimal lebar 550px */
    aspect-ratio: 1/1; /* Memastikan container selalu berbentuk kotak 1:1 */
    overflow: hidden;
  }
  .post-img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Crop gambar agar mengisi container secara proporsional */
    display: block;
  }

  /* Container Komentar & Reply */
  .comment-reply-container {
    height: 320px;
    overflow-y: auto;
  }

  /* Tampilan Card Postingan */
  .post-card {
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    overflow: hidden;
    margin-bottom: 1.5rem;
    padding: 1.5rem;
  }

  /* Tampilan Informasi User */
  .user-info img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 9999px;
  }
  .user-info .username {
    margin-left: 0.5rem;
    font-weight: 600;
  }

  /* Style untuk form komentar dan reply */
  .comment-box, .reply-box {
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    padding: 0.5rem;
    width: 100%;
  }

  /* Custom Flex Container untuk Kolom Kiri dan Kanan */
  .post-columns {
    display: flex;
    justify-content: center;  /* Center horizontal secara keseluruhan */
    align-items: flex-start;
    gap: 1rem;  /* Jarak horizontal lebih dekat */
  }
  .post-columns > .left,
  .post-columns > .right {
    flex: 0 0 50%;  /* Masing-masing kolom mengambil sekitar 48% dari lebar container */
  }
</style>

<div class="container mx-auto py-6">
  @foreach ($posts as $post)
    <div class="post-card">
      <div class="post-columns">
        <!-- Kolom Kiri: Gambar Postingan -->
        <div class="left">
          @if ($post->image)
            <div class="post-img-container">
              <img src="data:image/jpeg;base64,{{ base64_encode($post->image) }}" alt="Post Image">
            </div>
          @else
            <div class="post-img-container bg-gray-200 flex items-center justify-center">
              <span class="text-gray-500">No Image</span>
            </div>
          @endif
        </div>
        
        <!-- Kolom Kanan: Informasi User, Form Komentar & Komentar/Reply -->
        <div class="right">
          <!-- Informasi User -->
          <div class="flex items-center mb-4 user-info">
            @if ($post->user->profile_picture)
              <img src="{{ $post->user->profile_picture }}" alt="Profile Picture">
            @else
              <div class="w-12 h-12 bg-gray-300 rounded-full"></div>
            @endif
            <span class="username">@ {{ $post->user->username }}</span>
          </div>

          <!-- Formulir Tulis Komentar -->
          <div class="mb-4">
            <form method="POST" action="{{ route('addComment') }}">
              @csrf
              <input type="hidden" name="post_id" value="{{ $post->id }}">
              <textarea name="comment" class="comment-box" placeholder="Tulis komentar..." required></textarea>
              <div class="flex justify-end mt-2">
                <button type="submit" class="flex items-center bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  Kirim Komentar
                </button>
              </div>
            </form>
          </div>

          <!-- Container Komentar & Reply (dengan scroll jika konten melimpah) -->
          <div class="bg-gray-50 p-4 rounded comment-reply-container">
            @foreach ($post->comments as $comment)
              <div class="mb-4 p-4 bg-white rounded shadow">
                <div class="flex items-start">
                  <!-- Foto Profil Komentator -->
                  <div class="mr-2">
                    @if ($comment->user->profile_picture)
                      <img src="{{ $comment->user->profile_picture }}" alt="Profile Picture" class="rounded-full" style="width:50px; height:50px;">
                    @else
                      <div class="w-12 h-12 bg-gray-300 rounded-full"></div>
                    @endif
                  </div>
                  <div class="w-full">
                    <div class="font-semibold text-sm">@ {{ $comment->user->username }}</div>
                    <p class="text-sm">{{ $comment->comment }}</p>
                    
                    <!-- Form Reply untuk Komentar -->
                    <div class="mt-2">
                      <form method="POST" action="{{ route('addReply') }}">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
                        <div class="flex items-start">
                          <div class="mr-2">
                            @if (auth()->user()->profile_picture)
                              <img src="{{ auth()->user()->profile_picture }}" alt="My Profile" class="rounded-full" style="width:50px; height:50px;">
                            @else
                              <div class="w-12 h-12 bg-gray-300 rounded-full"></div>
                            @endif
                          </div>
                          <div class="flex-1">
                            <textarea name="reply_comment" class="reply-box" placeholder="Balas komentar..." required></textarea>
                          </div>
                          <div class="ml-2">
                            <button type="submit" class="p-2 bg-green-600 text-white rounded hover:bg-green-700">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                              </svg>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                    
                    <!-- Menampilkan Reply (jika ada) -->
                    @if ($comment->replies)
                      <div class="mt-4 ml-8 border-l pl-4">
                        @foreach ($comment->replies as $reply)
                          <div class="mb-4 p-4 bg-gray-100 rounded shadow">
                            <div class="flex items-start">
                              <!-- Foto Profil Reply -->
                              <div class="mr-2">
                                @if ($reply->user->profile_picture)
                                  <img src="{{ $reply->user->profile_picture }}" alt="Profile Picture" class="rounded-full" style="width:50px; height:50px;">
                                @else
                                  <div class="w-12 h-12 bg-gray-300 rounded-full"></div>
                                @endif
                              </div>
                              <div class="w-full">
                                <div class="font-semibold text-sm">@ {{ $reply->user->username }}</div>
                                <p class="text-sm">{{ $reply->comment }}</p>
                                
                                <!-- Form Reply untuk Reply -->
                                <div class="mt-2">
                                  <form method="POST" action="{{ route('addReply') }}">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="hidden" name="parent_comment_id" value="{{ $reply->id }}">
                                    <div class="flex items-start">
                                      <div class="mr-2">
                                        @if (auth()->user()->profile_picture)
                                          <img src="{{ auth()->user()->profile_picture }}" alt="My Profile" class="rounded-full" style="width:50px; height:50px;">
                                        @else
                                          <div class="w-12 h-12 bg-gray-300 rounded-full"></div>
                                        @endif
                                      </div>
                                      <div class="flex-1">
                                        <textarea name="reply_comment" class="reply-box" placeholder="Balas reply..." required></textarea>
                                      </div>
                                      <div class="ml-2">
                                        <button type="submit" class="p-2 bg-green-600 text-white rounded hover:bg-green-700">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                          </svg>
                                        </button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    @endif

                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>










</x-app-layout>
