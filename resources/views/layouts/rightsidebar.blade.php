<style>


  /* CSS untuk switch follow/unfollow */
  .switch {
    --switch-width: 46px;
    --switch-height: 24px;
    --switch-bg: rgb(26, 26, 26); /* off state: abu-abu tua */
    --switch-checked-bg: #ffffff; /* aktif: putih */
    --circle-diameter: 18px;
    --circle-bg: #000000; /* background lingkaran */
    --circle-shadow: 1px 1px 2px rgb(18, 18, 18);
    --circle-checked-shadow: -1px 1px 2px rgb(18, 18, 18);
    --switch-offset: calc((var(--switch-height) - var(--circle-diameter)) / 2);
    --switch-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
    
    border: var(--switch-border);
    display: inline-block;
    position: relative;
  }

  .switch input {
    display: none;
  }

  .slider {
    box-sizing: border-box;
    width: var(--switch-width);
    height: var(--switch-height);
    background: var(--switch-bg);
    border-radius: 999px;
    display: flex;
    align-items: center;
    position: relative;
    transition: var(--switch-transition);
    cursor: pointer;
  }

  /* Elemen lingkaran utama */
  .circle {
    width: var(--circle-diameter);
    height: var(--circle-diameter);
    background-color: var(--circle-bg);
    border-radius: inherit;
    box-shadow: var(--circle-shadow);
    position: absolute;
    left: var(--switch-offset);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Pseudo-element untuk menampilkan ikon dengan filter invert (agar tampil putih) */
  .circle::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('./images/active-user.png') no-repeat center;
    background-size: 60%;
    filter: invert(1);
  }

  /* Efek garis pada slider */
  .slider::before {
    content: "";
    position: absolute;
    width: calc(var(--circle-diameter) / 2);
    height: calc((var(--circle-diameter) / 2) / 2 - 1px);
    left: calc(var(--switch-offset) + (calc(var(--circle-diameter) / 2) / 2));
    background: var(--circle-bg);
    border-radius: 1px;
    transition: all .2s ease-in-out;
  }

  /* Saat input dicheck */
  .switch input:checked + .slider {
    background: var(--switch-checked-bg);
  }
  .switch input:checked + .slider::before {
    left: calc(100% - calc(var(--circle-diameter) / 2) - (calc(var(--circle-diameter) / 2) / 2) - var(--switch-offset));
  }
  .switch input:checked + .slider .circle {
    left: calc(100% - var(--circle-diameter) - var(--switch-offset));
    box-shadow: var(--circle-checked-shadow);
  }
  /* Ganti ikon pada kondisi checked */
  .switch input:checked + .slider .circle::after {
    background: url('./images/check.png') no-repeat center;
    background-size: 60%;
    filter: invert(1);
  }

  /* Sidebar styles */
  .rightsidebar {
    position: fixed;
    top: 0;
    right: 0;
    height: 100vh;
    width: 14.28%;
    background-color:rgb(10, 10, 10);
    padding: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }

  /* Container profil dan logout (full width agar sama dengan rekomendasi) */
  .profile-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top:16px;
    margin-bottom: 16px;
    width: 100%;
  }

  /* Profil: foto, nama, dan username */
  .profile {
    display: flex;
    align-items: center;
  }

  /* Ukuran foto profil disamakan dengan rekomendasi (48px) */
  .profile-img-container {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
  }
  .profile-img-container img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Tombol logout diberi ukuran container yang konsisten */
  .logout-button {
    width: 25px;
    text-align: center;
  }
  .logout-button a img {
    width: 100%;
    height: auto;
  }

  /* Recommendation styles */
  .recommendation-card {
    width: 100%;
  }
  .recommendation-img-container {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
  }
  .recommendation-img-container img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
  }
</style>

<!-- Sidebar (tetap di sebelah kanan) -->
<div class="rightsidebar">
  <!-- Profil dan Logout (sejajar horizontal, full width) -->
  <div class="profile-container">
    <div class="profile">
      <div class="profile-img-container">
        @if (auth()->user()->profile_picture)
          <img src="{{ auth()->user()->profile_picture }}" alt="Profile Picture">
        @else
          <div style="width: 100%; height: 100%; background-color: #ddd;"></div>
        @endif
      </div>
      <div style="margin-left: 12px;">
      <p style="font-size: 1.3em; font-weight: bold; margin: 0; color: #fff;">
          <a href="{{ route('profile.public', ['username' => auth()->user()->username]) }}" style="color: #ccc; text-decoration: none;">
            {{ auth()->user()->name }}
          </a>
        </p>
        <p style="font-size: 1em; margin: 0; color: #ccc;">
          <a href="{{ route('profile.public', ['username' => auth()->user()->username]) }}" style="color: #ccc; text-decoration: none;">
            {{ '@' . auth()->user()->username }}
          </a>
        </p>
      </div>
    </div>
    <div class="logout-button">
      <a href="{{ route('logout') }}" 
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
         <img src="./images/logout (1).png" alt="Logout">
      </a>
      <!-- Form Logout (Hidden) -->
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </div>
  </div>
  
  <!-- Rekomendasi User untuk Follow -->
  <div class="recommendation-card">
    <h2 style="font-size: 1.1em; font-weight: bold; margin: 14px 0; color: #fff;">
      Rekomendasi Diikuti
    </h2>
    @foreach ($recommendations as $user)
      <div class="user-item" style="display: flex; align-items: center; margin-bottom: 12px;">
        <div class="recommendation-img-container">
          <img src="{{ $user->profile_picture ?? asset('default-avatar.png') }}" alt="Profile Picture">
        </div>

        <!-- <div style="margin-left: 8px;">
          <p style="font-size: 0.95em; font-weight: bold; margin: 0; color: #fff;">
            {{ $user->name }}
          </p>
          <p style="font-size: 0.85em; margin: 0; color: #ccc;">
            {{ '@' . $user->username }}
          </p>
        </div> -->

        <div style="margin-left: 8px;">
        <!-- Tambahkan link ke profil publik -->
        <a href="{{ route('profile.public', ['username' => $user->username]) }}" style="text-decoration: none;">
          <p style="font-size: 0.95em; font-weight: bold; margin: 0; color: #fff;">
            {{ $user->name }}
          </p>
        </a>
        <a href="{{ route('profile.public', ['username' => $user->username]) }}" style="text-decoration: none;">
          <p style="font-size: 0.85em; margin: 0; color: #ccc;">
            {{ '@' . $user->username }}
          </p>
        </a>
      </div>

        <!-- Custom Toggle Switch untuk Follow/Unfollow -->
        <label class="switch" style="margin-left: auto;">
        <!-- Custom Toggle Switch -->
        <input type="checkbox" id="switch-{{ $user->id }}" onchange="toggleFollow({{ $user->id }}, this.checked)" {{ $user->is_followed ? 'checked' : '' }}>
        <div class="slider">
          <div class="circle"></div>
        </div>
      </label>
      </div>
    @endforeach
  </div>
</div>