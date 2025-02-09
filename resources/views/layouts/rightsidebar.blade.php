<!-- Sidebar (tidak di dalam container, tetap di sebelah kanan) -->
<div class="rightsidebar" style="position: fixed; top: 0; right: 0; height: 100vh; width: 14.28%; background-color: #fff; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <!-- Tombol Logout -->
    <div style="display: flex; justify-content: flex-end; margin-bottom: 16px;">
        <a href="{{ route('logout') }}" 
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none; color: #e53e3e; display: flex; align-items: center;">
        <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout
        </a>
        <!-- Form Logout (Hidden) -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        </form>
    </div>  
<!-- Profil User -->
  <div class="profile" style="display: flex; align-items: center; margin-bottom: 16px;">
    <div class="flex items-center">
      @if (auth()->user()->profile_picture)
        <img src="{{ auth()->user()->profile_picture }}" alt="Profile Picture" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover;">
      @else
        <div style="width: 64px; height: 64px; background-color: #ddd; border-radius: 50%;"></div>
      @endif
      <div style="margin-left: 12px;">
        <p style="font-size: 1.1em; font-weight: bold; margin: 0;">{{ auth()->user()->username }}</p>
      </div>
    </div>
  </div>
  
  <!-- Rekomendasi User untuk Follow -->
  <div class="recommendation-card">
    <h2 style="font-size: 1.1em; font-weight: bold; margin-bottom: 12px;">Rekomendasi untuk Diikuti</h2>
    @foreach ($recommendations as $user)
        <div class="user-item" style="display: flex; align-items: center; margin-bottom: 12px;">
            <img src="{{ $user->profile_picture ?? asset('default-avatar.png') }}" alt="Profile Picture" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
            <span style="margin-left: 8px; font-size: 0.95em; color: #333;">{{ $user->username }}</span>
            @if ($user->is_followed)
            <button onclick="unfollowUser({{ $user->id }})" id="user-button-{{ $user->id }}" class="follow-button" style="margin-left: auto; border: none; background: #e53e3e; color: white; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                Unfollow
            </button>
            @else
            <button onclick="followUser({{ $user->id }})" id="user-button-{{ $user->id }}" class="follow-button" style="margin-left: auto; border: none; background: #22c55e; color: white; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                Follow
            </button>
            @endif
        </div>
    @endforeach
  </div>
</div>

<!-- JavaScript: Toggle Reply Form dan Follow/Unfollow -->
<script>
  function followUser(userId) {
    fetch('/follow/' + userId, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ userId: userId })
    })
    .then(response => response.json())
    .then(data => {
      const button = document.getElementById('user-button-' + userId);
      if (button) {
        // Ubah teks dan warna tombol menjadi "Unfollow"
        button.textContent = 'Unfollow';
        button.style.backgroundColor = '#e53e3e'; // Warna merah
        button.setAttribute('onclick', 'unfollowUser(' + userId + ')');
      }
    })
    .catch(error => {
      console.error('Error following user:', error);
    });
  }

  function unfollowUser(userId) {
    fetch('/unfollow/' + userId, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ userId: userId })
    })
    .then(response => response.json())
    .then(data => {
      const button = document.getElementById('user-button-' + userId);
      if (button) {
        // Ubah teks dan warna tombol menjadi "Follow"
        button.textContent = 'Follow';
        button.style.backgroundColor = '#22c55e'; // Warna hijau
        button.setAttribute('onclick', 'followUser(' + userId + ')');
      }
    })
    .catch(error => {
      console.error('Error unfollowing user:', error);
    });
  }
</script>