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
  justify-content: flex-start; /* Elemen mulai dari kiri */
  flex-wrap: nowrap;            /* Pastikan semua elemen tetap satu baris */
  width: 100%;                 /* Mengambil lebar penuh dari kontainer */
  margin-bottom: 16px;
  gap: 10px;
  color: #eaeaea;
}

.comment-form textarea {
  flex: 1;
  padding: 8px;
  background-color: rgb(13, 13, 13);
  border: 1px solid rgb(17, 17, 17);
  border-radius: 4px;
  resize: none;
  height: 40px;
  overflow: hidden;
  transition: all 1s ease;
}

.comment-form button {
  margin-left: auto;  /* Mendorong tombol ke paling kanan */
  border: none;
  background: none;
  cursor: pointer;
  font-size: 1.2em;
  color: #eaeaea;
  transition: color 1s ease;
}

.comment-form button:hover {
  color: #eaeaea;
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
        color: #eaeaea;
        
      }
      .reply-form textarea {
        flex: 1;
        padding: 8px;
        
        border-radius: 4px;
        background-color: rgb(13, 13, 13);
  border: 1px solid rgb(17, 17, 17);
        color: #eaeaea;
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
        color:rgb(218, 218, 218);
        transition: color 1s ease;
      }
      .reply-form .icon-button:hover {
        color:rgb(218, 218, 218)3;
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


<style>
      /* ... (styles sebelumnya tetap dipertahankan) ... */

      /* Responsive Styles */
      @media (max-width: 768px) {
        .container {
          width: 100% !important;
          margin-left: 0 !important;
          padding: 8px;
        }
        
        .flex-row {
          flex-direction: column;
        }
        
        .left-side.feeds {
          flex-basis: 100%;
          order: 1;
          margin-bottom: 16px;
        }
        
        .right-side {
          flex-basis: 100%;
          order: 2;
        }
        
        .header-post {
    display: flex;            /* pastikan container flex */
    flex-direction: row;      /* atur elemen secara horizontal */
    align-items: center;  
   /* agar elemen sejajar secara vertikal */
  }
  
  .profile-img {
    margin-right: 10px;       /* beri jarak antara foto dan informasi user */
    margin-bottom: 0;         /* hilangkan margin bawah jika ada */
  }
  
   /* Mengatur container komentar & reply agar lebarnya tetap sesuai dengan feed image */
   .container-commentreply {
      height: auto;
      max-height: 400px;
      width: 100%;
      max-width: 490%;  /* Sesuaikan nilai ini dengan lebar gambar feeds */
      margin: 0 auto;    /* center container */
    }
       


}

        
     
        
        .comment-form textarea {
          width: 100%;
          margin-bottom: 8px;
        }
        
        .comment-header p {
          font-size: 16px;
        }

        .reply{
          font-size: 14px;
        }
        
        .modal-content {
          max-width: 100%;
          max-height: 90vh;
        }
        
        .reply-form {
          flex-direction: column;
        }
        
        .reply-form textarea {
          width: 100%;
          margin-bottom: 8px;
        }
        
        .container-commentreply {
          height: auto;
          max-height: 400px;
        }
        
        .user-info p {
          font-size: 16px;
        }
        
        .user-info span {
          font-size: 12px;
        }
        
        .caption p {
          font-size: 14px;
        }
        .custom-file-label
        {
          width: 70%;
        }
      }

      /* Mobile Landscape Adjustment */
      @media (max-width: 768px) and (orientation: landscape) {
        .container-commentreply {
          max-height: 250px;
        }
        
        .left-side.feeds {
          aspect-ratio: 1.5/1;
        }
      }

      /* Very Small Screens */
      @media (max-width: 480px) {
        .profile-img {
          size: 100%;
        }
        
        .upload-section h3 {
          font-size: 16px;
        }
        
   


        .upload-section {
          padding: 16px;
        }
        
        .post-card {
          padding: 16px;
        }
        
        .comment {
          padding-left: 15px;
        }
        
        .reply {
          margin-left: 8px;
        }
      }


    </style>

    
  </head>
  <body>
    <!-- Container Postingan -->
    <div class="container" id="main-container">

    <!-- Container Story -->
<section class="stories-container flex items-center space-x-4 p-4 bg-gray-50">
    <!-- Tombol Upload Story -->
    <div class="story-upload text-center">
        <button onclick="openUploadModal()" class="w-16 h-16 rounded-full border-2 border-dashed flex items-center justify-center hover:bg-gray-100">
            <i class="fas fa-plus text-2xl"></i>
        </button>
        <div class="mt-2 text-sm">Your Story</div>
        <!-- resources/views/stories/index.blade.php -->
        <div class="grid grid-cols-3 gap-4">
            @foreach ($stories as $story)
                <div class="p-4 border rounded-lg">
                    <h2 class="text-lg font-semibold">Story dari User {{ $story->user_id }}</h2>
                    @if($story->image_base64 && $story->mime)
                        <img src="data:{{ $story->mime }};base64,{{ $story->image_base64 }}" 
                            alt="Story Image" class="w-full h-auto rounded">
                    @else
                        <p>Tidak ada gambar.</p>
                    @endif
                    <p class="text-gray-600 mt-2">{{ $story->created_at->format('d M Y H:i') }}</p>
                </div>
            @endforeach
        </div>
</section>

<!-- Modal Upload Story (disembunyikan secara default dengan kelas "hidden") -->
<div id="uploadModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded shadow-lg relative">
        <!-- Tombol untuk menutup modal -->
        <button onclick="closeUploadModal()" class="absolute top-2 right-2 text-gray-600 text-2xl">&times;</button>
        <h2 class="text-xl mb-4">Upload Story</h2>
        <form id="uploadForm" action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="image" accept="image/*" required class="border p-2">
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
        </form>
    </div>
</div>

<!-- Script untuk mengatur tampil/sembunyi modal -->
<script>
function openUploadModal() {
    const uploadModal = document.getElementById('uploadModal');
    if (uploadModal) {
        uploadModal.classList.remove('hidden');
    } else {
        console.error('Modal upload tidak ditemukan!');
    }
}

function closeUploadModal() {
    const uploadModal = document.getElementById('uploadModal');
    if (uploadModal) {
        uploadModal.classList.add('hidden');
    }
}
</script>




    
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
    <img src="./images/chat.png" alt="Comment Icon" style="width: 30px;">
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
  <img src="./images/auto-reply.png" alt="Auto Reply Icon" width="40%">
</button>

    
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
