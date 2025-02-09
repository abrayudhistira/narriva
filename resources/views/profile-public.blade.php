<x-app-layout>
    <style>
        body {
            background-color: darkgray;
            color: darkgray;
        }

        .profile-header {
            text-align: center;
            margin: 3rem 0;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 9999px;
            margin-bottom: 1rem;
        }

        .stats-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 1rem;
        }

        .stats-item {
            text-align: center;
        }

        .stats-item p {
            font-size: 1.25rem;
            margin: 0;
        }

        .stats-label {
            font-size: 0.875rem;
            color: #9ca3af;
        }

        .btn-edit-profile {
            background-color: #22c55e;
            color: black;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: bold;
            margin-top: 1rem;
            cursor: pointer;
        }

        .post-section {
            margin-top: 3rem;
        }

        .post-card {
            background: #1f2937;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>

    <!-- Profile Section -->
    <div class="container mx-auto py-6">
        <div class="profile-header">
            <img src="{{ auth()->user()->profile_picture }}" alt="Profile Picture">
            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
            <p class="text-gray-400">{{ $user->username }}</p>

            <div class="stats-container mt-4">
                <div class="stats-item">
                    <p>{{ count(auth()->user()->followers) }}</p>
                    <span class="stats-label">Pengikut</span>
                </div>
                <div class="stats-item">
                    <p>{{ count(auth()->user()->following) }}</p>
                    <span class="stats-label">Mengikuti</span>
                </div>
                <div class="stats-item">
                    <p>{{ count(auth()->user()->posts) }}</p>
                    <span class="stats-label">Postingan</span>
                </div>
                <div class="stats-item">
                    <p>0</p>
                    <span class="stats-label">Suka</span>
                </div>
            </div>

            <!-- Tombol Edit Profile -->
            @if(auth()->check() && auth()->user()->id === $user->id)
                <a href="{{ route('profile.edit') }}" class="btn-edit-profile mt-4">Edit Profile</a>
            @endif
        </div>
        <!-- User Posts Section -->
        <div class="post-section mt-8">
            <h2 class="text-xl font-semibold mb-4">Postingan</h2>
            @forelse ($posts as $post)
                <div class="post-card">
                    <p>{{ $post->caption }}</p>
                    @if ($post->image)
                        <img src="data:image/jpeg;base64,{{ base64_encode($post->image) }}" class="w-full mt-4 rounded" alt="Post Image">
                    @endif
                </div>
            @empty
                <p class="text-gray-400">Belum ada postingan.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
