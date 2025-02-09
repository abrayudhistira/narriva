<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Feed Postingan') }}
        </h2>
    </x-slot>

<!-- Custom Styles -->
<style>
  /* Container Gambar Postingan */
  .post-img-container {
    width: 100%;
    max-width: 550px;
    aspect-ratio: 1/1;
    overflow: hidden;
  }
  .post-img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  /* Komentar & Reply */
  .comment-container {
    margin-top: 1rem;
    background: #1f2937;
    border-radius: 0.5rem;
    padding: 1rem;
    color: white;
  }
  
  .comment-box {
    background: #374151;
    border: none;
    border-radius: 0.375rem;
    width: 100%;
    padding: 0.5rem;
    color: white;
  }
  
  .reply-container {
    margin-left: 2rem;
    background: #2d3748;
    padding: 0.5rem;
    border-radius: 0.375rem;
  }

  .btn-submit {
    background-color: #22c55e;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    margin-top: 0.5rem;
  }

</style>

<!-- Main Container -->
<div class="container mx-auto py-6">
  <div class="flex gap-4">
    
    <!-- Feed Postingan -->
    <div class="flex-1">
      @foreach ($posts as $post)
        <div class="post-card bg-gray-800 text-white p-6 rounded-lg mb-4">
          <div>
            <!-- Header Post -->
            <div class="flex items-center mb-4">
              <img src="{{ $post->user->profile_picture }}" alt="Profile Picture" class="w-12 h-12 rounded-full">
              <div class="ml-4">
                <p class="font-semibold">{{ $post->user->name }}</p>
                <span class="text-sm text-gray-400">@ {{ $post->user->username }} • {{ $post->created_at->format('d M Y, H:i') }}</span>
              </div>
            </div>

            <!-- Gambar Postingan -->
            @if ($post->image)
              <div class="post-img-container">
                <img src="data:image/jpeg;base64,{{ base64_encode($post->image) }}" alt="Post Image">
              </div>
            @endif

            <!-- Caption -->
            <p class="mt-4">{{ $post->caption }}</p>

            <!-- Komentar -->
            <div class="comment-container mt-4">
              <h3 class="text-lg font-semibold mb-2">Komentar:</h3>
              @foreach ($post->comments as $comment)
                <div class="mb-2">
                  <p class="font-semibold">@ {{ $comment->user->username }}</p>
                  <p>{{ $comment->comment }}</p>

                  <!-- Reply -->
                  <div class="reply-container mt-2">
                    @foreach ($comment->replies as $reply)
                      <div class="mb-2">
                        <p class="font-semibold">@ {{ $reply->user->username }}</p>
                        <p>{{ $reply->comment }}</p>
                      </div>
                    @endforeach

                    <!-- Form Reply -->
                    <form method="POST" action="{{ route('reply.comment') }}" class="mt-2">
                      @csrf
                      <input type="hidden" name="post_id" value="{{ $post->id }}">
                      <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
                      <textarea name="comment" class="comment-box mt-1" placeholder="Tulis balasan..."></textarea>
                      <button type="submit" class="btn-submit">Reply</button>
                    </form>
                  </div>
                </div>
              @endforeach

              <!-- Form Komentar -->
              <form method="POST" action="{{ route('comment.post') }}" class="mt-4">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <textarea name="comment" class="comment-box" placeholder="Tulis komentar..."></textarea>
                <button type="submit" class="btn-submit">Kirim Komentar</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Sidebar -->
    <div class="right-sidebar w-1/4">
      <!-- User Profile -->
      <div class="bg-white p-4 rounded shadow-md">
        <div class="flex items-center">
          @if (auth()->user()->profile_picture)
            <img src="{{ auth()->user()->profile_picture }}" alt="Profile Picture" class="w-16 h-16 rounded-full object-cover">
          @else
            <div class="w-16 h-16 bg-gray-300 rounded-full"></div>
          @endif
          <div class="ml-4">
            <p class="font-semibold text-lg">{{ auth()->user()->username }}</p>
          </div>
        </div>
      </div>

      <!-- Rekomendasi User untuk Follow -->
      <div class="recommendation-card bg-white p-4 mt-4 rounded shadow-md">
        <h2 class="font-semibold text-lg mb-4">Rekomendasi untuk Diikuti</h2>
        @foreach ($recommendations as $user)
            <div class="flex items-center space-x-4 mb-4">
                <img src="{{ $user->profile_picture ?? asset('default-avatar.png') }}" alt="Profile Picture" class="w-16 h-16 rounded-full object-cover">
                <span>{{ $user->username }}</span>

                @if (auth()->user()->following->contains($user))
                <button onclick="unfollowUser({{ $user->id }})" class="text-green-500 hover:text-green-700">
                    <i class="fas fa-bell"></i> <!-- Ikon bel berdering -->
                </button>
                @else
                <button onclick="followUser({{ $user->id }})" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-bell-slash"></i> <!-- Ikon bel tidak berdering -->
                </button>
                @endif
            </div>
        @endforeach
        </div>
    </div>

  </div>
</div>
</x-app-layout>
