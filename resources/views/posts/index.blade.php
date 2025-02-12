<x-app-layout>
  <!DOCTYPE html>
  <html lang="id">
  <head>
    <meta charset="UTF-8">
    <title>Feeds</title>
    <!-- Sertakan Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
      /* Global Styles */
      body {
        background-color: black;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
       
      }
      
      /* Container untuk postingan (default) */
      .container {
        width: 85.73%;
        margin: 0;
        padding: 16px;
        transition: width 1s ease-in-out, margin-left 1s ease-in-out;
        background-color: black;
      
      }
      .container.leftsidebar-open {
        width: 71.44%;
        margin-left: 14.28%;
      }
      
      /* Section Upload Feed */
  .upload-section {
    background-color: (10rgb, 10, 10);
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 1s ease;
    background-color: rgb(10, 10, 10);
  }
  .upload-section h3 {
    margin-top: 0;
    margin-bottom: 16px;
    color: rgb(245, 245, 245);
    font-weight: 800;
  }
  /* Flex container untuk caption dan aksi */
  .upload-row {
    display: flex;
    align-items: center;
  }
      /* Container caption (textarea) satu baris */
  .upload-row textarea {
    background-color: rgb(13, 13, 13);
    border: 1px solid rgb(17, 17, 17);
    border-radius: 4px;
    padding: 8px;
    color: rgb(245, 245, 245);
    flex: 1;
    margin-right: 16px;
    resize: none;
    height: 36px; /* Atur tinggi agar terlihat satu baris */
    transition: all 1s ease;
  }
      /* Container untuk aksi (choose file dan upload) */
  .upload-actions {
    display: flex;
    align-items: center;
  }
  /* Custom file input dengan ikon */
  .custom-file-label {
    position: relative;
    display: inline-block;
    margin-right: 8px;
    cursor: pointer;
  }
  .custom-file-label input[type="file"] {
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
  }
  .custom-file-label img {
    width: 32px;
    height: 32px;
    display: block;
  }
  /* Tombol upload dengan ikon */
  .upload-actions button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
  }
  .upload-actions button img {
    width: 32px;
    height: 32px;
    display: block;
  }






      
      
      /* Card Postingan */
      .post-card {
        background-color:rgb(10, 10, 10);
        padding: 24px;
        border-radius: 8px;
        margin-bottom: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 1s ease;

        
      }
      
      /* Flex container untuk layout post */
      .flex-row {
        display: flex;
        gap: 16px;
      }
      
      /* Bagian Kiri: Foto Feeds */
      .left-side.feeds {
        flex: 1 1 50%;
        aspect-ratio: 1 / 1;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        border-radius: 8px;
        background-color: #eaeaea;
        cursor: pointer;
        transition: transform 1s ease;
      }
      .left-side.feeds:hover {
        transform: scale(1.02);
      }
      .left-side.feeds img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 1s ease;
      }
      .no-image {
        width: 100%;
        height: 100%;
        background-color: #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #999;
        font-size: 18px;
      }
      
      /* Bagian Kanan: Informasi Postingan & Komentar */
      .right-side {
        flex: 1 1 50%;
        display: flex;
        flex-direction: column;
        transition: all 1s ease;
      }
      .header-post {
        display: flex;
        align-items: center;
        margin-bottom: 16px;
        transition: all 1s ease;
      }
      .profile-img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        transition: all 1s ease;
      }
      .user-info {
        margin-left: 12px;
        transition: all 1s ease;
        color: #eaeaea;
        font-weight: 700;
      }
      .user-info p {
        margin: 0;
        font-weight: bold;
      }
      .user-info span {
        font-size: 0.9em;
        color: #777;
      }
      .caption {
        margin-bottom: 16px;
        transition: all 1s ease;
        color: #eaeaea;
      }

      .container-commentreply {
        background-color: rgb(13, 13, 13);
        border: 1px solid rgb(17, 17, 17);
  border-radius: 5px;
  height: 490%;
  overflow-y: auto;


}



      
      /* Form Komentar */
      .comment-form {
  display: flex;
  align-items: center;
  justify-content: flex-end; /* Aligns the form content to the right */
  margin-bottom: 16px;
  transition: all 1s ease;
  gap: 5px;

}


.comment-form textarea {
  flex: 1;
  padding: 8px;
  background-color: rgb(13, 13, 13);
  border: 1px solid rgb(17, 17, 17);
  border-radius: 4px;
  resize: none;        /* Menghilangkan kemampuan mengubah ukuran */
  height: 40px;        /* Menetapkan tinggi tetap agar hanya satu baris */
  overflow: hidden;    /* Mencegah konten meluber */
  transition: all 1s ease;

}

      .comment-form button {
        margin-left: 8px;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 1.2em;
        color: #007BFF;
        transition: color 1s ease;
      }
      .comment-form button:hover {
        color: #0056b3;
      }
      
      /* Komentar & Reply */
      .comment-container {
        margin-top: 16px;
        transition: all 1s ease;

        
      }
      .comment {
        margin-bottom: 16px;
        border-bottom: 1px solid rgb(17, 17, 17);
        padding-bottom: 8px;
        transition: all 1s ease;
        padding-left: 35px;
        padding-top: 10px;

      }
      
      .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 1s ease;

        
      }
      .comment-header p {
        margin: 0;
        padding: 0;
        color:rgb(165, 165, 165);
      }

      .reply{
  color:rgb(100, 100, 100)
}
      .toggle-reply {
        cursor: pointer;
        color: #007BFF;
        font-size: 1.2em;
        transition: color 1s ease;
  float: right;
      }
      .toggle-reply:hover {
        color: #0056b3;
      }
      
      /* Reply Form Container dengan animasi */
.reply-form-container {
  max-height: 0;
  opacity: 0;
  overflow: hidden;
  transition: max-height 0.5s ease-out, opacity 0.5s ease-out;

}

.reply-form-container.active {
  /* Naikkan nilai max-height sesuai dengan tinggi konten form reply */
  max-height: 500px;
  opacity: 1;
  /* Jika perlu, tambahkan padding agar transisinya lebih halus */
  padding-top: 8px;
  padding-bottom: 8px;
  
}


      .reply-form {
        display: flex;
        align-items: center;
        transition: all 1s ease;
        
      }
      .reply-form textarea {
        flex: 1;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        color: #333;
        resize: none;
        min-height: 40px;
        transition: all 1s ease;
      }
      .reply-form .icon-button {
        margin-left: 8px;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 1.2em;
        color: #007BFF;
        transition: color 1s ease;
      }
      .reply-form .icon-button:hover {
        color: #0056b3;
      }
      .reply {
        margin-left: 16px;
        margin-top: 8px;
        border-left: 2px solid rgb(17, 17, 17);
        padding-left: 8px;
        transition: all 1s ease;
      }
      
      /* Modal untuk tampilkan gambar full */
      .modal {
        /* Modal selalu tampil sebagai flex namun disembunyikan lewat opacity */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 1s ease;
      }
      .modal.open {
        opacity: 1;
        pointer-events: auto;
      }
      .modal-content {
        max-width: 1300px;
        max-height: 800px;
        overflow: auto;
        transition: all 1s ease;
      }
      .modal-content img {
        display: block;
        width: auto;
        height: auto;
        transition: all 1s ease;
      }
      .close-modal {
        position: absolute;
        top: 20px;
        right: 20px;
        color: #fff;
        font-size: 30px;
        cursor: pointer;
        transition: color 1s ease;
      }
      .close-modal:hover {
        color: #ccc;
      }

      
    </style>
  </head>
  <body>
    <!-- Container Postingan -->
    <div class="container" id="main-container">
      
      <!-- Section Upload Feed -->
<div class="upload-section">
  <h3>Upload Feed</h3>
  <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="upload-row">
      <textarea name="caption" placeholder="Tulis caption untuk feed..."></textarea>
      <div class="upload-actions">
      <label class="custom-file-label">
  <input type="file" name="image" accept="image/*">
  <img src="./images/add-image (1).png" alt="Choose File" style="size: 30%;"> <!-- Corrected style -->
</label>
<button type="submit">
  <img src="./images/send.png" alt="Upload" style="size: 30%;"> <!-- Corrected style -->
</button>

      </div>
    </div>
  </form>
</div>
      
      <!-- Loop Postingan -->
      @foreach ($posts as $post)
        <div class="post-card">
          <div class="flex-row">
            <!-- Bagian Kiri: Foto Feeds -->
            <div class="left-side feeds">
              @if ($post->image)
                <img src="data:image/jpeg;base64,{{ base64_encode($post->image) }}" alt="Post Image">
              @else
                <div class="no-image">No Image</div>
              @endif
            </div>
            <!-- Bagian Kanan: Informasi Postingan & Komentar -->
            <div class="right-side">
            <div class="header-post">
  <img src="{{ $post->user->profile_picture }}" alt="Profile Picture" class="profile-img">
  <div class="user-info">
    <p>{{ $post->user->name }}</p>
    <span>
      {{ '@' . $post->user->username }}<br>
      {{ $post->created_at->format('d M Y, H:i') }}
    </span>
  </div>
</div>
<div class="caption">
  <p>{{ $post->caption }}</p>
</div>


              <!-- Form Komentar -->
              <form method="POST" action="{{ route('addComment') }}" class="comment-form">
  @csrf
  <input type="hidden" name="post_id" value="{{ $post->id }}">
  <textarea name="comment" placeholder="Tulis komentar..." rows="1"></textarea>
  <button type="submit" class="icon-button">
  <img src="./images/chat.png" alt="Comment Icon" style="width: 40%;">

  </button>
</form>



              <div class="container-commentreply">
              <!-- Komentar & Reply -->
              <div class="comment-container">
                @foreach ($post->comments as $comment)
                  <div class="comment">
                    <div class="comment-header">
                    <p><strong>{{ '@' . $comment->user->username }}</strong> {{ $comment->comment }}</p>

                      <!-- Tombol Reply dengan data-target -->
                      <span class="toggle-reply" data-target="reply-form-{{ $comment->id }}" title="Balas" style="float: right; padding-left: 0;">
  <img src="./images/auto-reply.png" alt="Auto Reply Icon" style="width: 40%;">
</span>

                    </div>

                    
                    <!-- Reply Form Container dengan transisi -->
<div class="reply-form-container" id="reply-form-{{ $comment->id }}">
  <form method="POST" action="{{ route('reply.comment') }}" class="reply-form">
    @csrf
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
    <textarea name="reply_comment" placeholder="Tulis reply..." rows="1"></textarea>
    <button type="submit" class="icon-button">
  <img src="./images/auto-reply.png" alt="Auto Reply Icon" width="50%">
</button>

      <i class="fas fa-paper-plane"></i>
    </button>
  </form>
</div>


                    <!-- List Reply -->
                    @if ($comment->replies->isNotEmpty())
                      <div class="replies" style="margin-left: 20px;">
                        @foreach ($comment->replies as $reply)
                          <div class="reply">
                          <p><strong>{{ "@{$reply->user->username}" }}</strong>: {{ $reply->comment }}</p>

                          </div>
                        @endforeach
                      </div>
                    @endif
                  </div>
                @endforeach
              </div>
              </div>



            </div>
          </div>
        </div>
      @endforeach
    </div>
    
    <!-- Modal Full Image -->
    <div id="imageModal" class="modal">
      <div class="modal-content">
        <img id="modalImage" src="" alt="Full Image">
      </div>
      <span id="closeModal" class="close-modal">&times;</span>
    </div>
    
    <!-- JavaScript untuk toggle form reply dan modal gambar -->
    <script>
      document.querySelectorAll('.toggle-reply').forEach(function(button) {
  button.addEventListener('click', function() {
    var targetId = this.getAttribute('data-target');
    var replyFormContainer = document.getElementById(targetId);
    if (replyFormContainer) {
      replyFormContainer.classList.toggle('active');
    }
  });
});

        
        // Contoh fungsi untuk modal full image (opsional)
        var imageModal = document.getElementById('imageModal');
        var closeModal = document.getElementById('closeModal');
        
        // Buka modal saat gambar di klik
        document.querySelectorAll('.left-side.feeds img').forEach(function(img) {
          img.addEventListener('click', function() {
            var modalImage = document.getElementById('modalImage');
            modalImage.src = this.src;
            imageModal.classList.add('open');
          });
        });
        
        // Tutup modal saat tombol close diklik
        closeModal.addEventListener('click', function() {
          imageModal.classList.remove('open');
        });
        
        // Tutup modal saat klik di luar konten modal
        imageModal.addEventListener('click', function(e) {
          if (e.target === imageModal) {
            imageModal.classList.remove('open');
          }
        });
      
      });
    </script>



  </body>
  </html>
</x-app-layout>
