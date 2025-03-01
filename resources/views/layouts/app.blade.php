<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-black">
            <!-- @include('layouts.navigation') -->
            @include('layouts.leftsidebar')
            @include('layouts.rightsidebar')
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
            <script>
            function followUser(userId) {
                $.ajax({
                url: `/user/${userId}/follow`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Perbarui tampilan ikon setelah follow berhasil
                    location.reload(); // Atau perbarui ikon secara dinamis tanpa reload
                },
                error: function(error) {
                    console.error('Error following user:', error);
                }
                });
            }

            function unfollowUser(userId) {
                $.ajax({
                url: `/user/${userId}/unfollow`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Perbarui tampilan ikon setelah unfollow berhasil
                    location.reload(); // Atau perbarui ikon secara dinamis tanpa reload
                },
                error: function(error) {
                    console.error('Error unfollowing user:', error);
                }
                });
            }
            // document.addEventListener("DOMContentLoaded", function () {
            // document.querySelectorAll(".toggle-reply").forEach(function (icon) {
            //         icon.addEventListener("click", function () {
            //             const commentId = this.closest(".comment").querySelector("input[name='parent_comment_id']").value;
            //             const replyFormContainer = document.getElementById(`reply-form-${commentId}`);
            //             replyFormContainer.style.display = replyFormContainer.style.display === "none" ? "block" : "none";
            //         });
            //     });
            // });
            document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM sudah siap, binding event reply');

            document.querySelectorAll('.toggle-reply').forEach(function(button) {
                button.addEventListener('click', function() {
                var targetId = this.getAttribute('data-target');
                console.log('Toggle reply untuk:', targetId);
                var replyFormContainer = document.getElementById(targetId);
                if (replyFormContainer) {
                    replyFormContainer.classList.toggle('active');
                } else {
                    console.error('Element dengan id', targetId, 'tidak ditemukan.');
                }
                });
            });

            // ... kode modal (jika diperlukan)
            });
            </script>
            <!-- JavaScript: Transisi Modal, Toggle Reply, dan lainnya -->
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Contoh toggle left sidebar (jika diperlukan)
                document.getElementById('toggle-left-sidebar')?.addEventListener('click', function(){
                document.getElementById('main-container').classList.toggle('leftsidebar-open');
                });
                
                // Modal: buka full image dengan transisi
                document.querySelectorAll('.left-side.feeds img').forEach(function(image) {
                image.addEventListener('click', function() {
                    var modal = document.getElementById('imageModal');
                    var modalImage = document.getElementById('modalImage');
                    modalImage.src = this.src;
                    modal.classList.add('open');
                });
                });
                
                // Modal: tutup ketika klik tombol close
                document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('imageModal').classList.remove('open');
                });
                
                // Modal: tutup ketika klik di luar modal content
                document.getElementById('imageModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    this.classList.remove('open');
                }
                });
            });
            
            </script>
           <script>
                function toggleFollow(userId, isFollowed) {
                    const endpoint = isFollowed ? `/user/${userId}/follow` : `/user/${userId}/unfollow`;
                    const method = isFollowed ? 'POST' : 'DELETE';

                    fetch(endpoint, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                    })
                    .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                    })
                    .then(data => {
                    console.log(isFollowed ? 'Berhasil mengikuti user.' : 'Berhasil berhenti mengikuti user.');
                    })
                    .catch(error => {
                    console.error('Error saat melakukan toggle follow:', error);
                    const toggleElement = document.getElementById('switch-' + userId);
                    if (toggleElement) {
                        toggleElement.checked = !isFollowed;
                    }
                    });
                }
                </script>
                //ini adalah untuk js story
                <script>
                    let currentStoryIndex = 0;
                    let stories = [];
                    let storyInterval;
                    let progressInterval;

                    // Fungsi untuk membuka story
                    function viewStory(storyId) {
                        fetch(`/stories/${storyId}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                stories = data.stories;
                                currentStoryIndex = 0;
                                showStory();
                            })
                            .catch(error => {
                                console.error('There was a problem with the fetch operation:', error);
                                alert('Failed to load stories. Please try again.');
                            });
                    }

                    // Fungsi untuk menampilkan story
                    function showStory() {
                        const storyModal = document.getElementById('storyModal');
                        const storyImage = document.getElementById('storyImage');
                        const progress = document.getElementById('progress');

                        if (currentStoryIndex >= stories.length) {
                            closeStory();
                            return;
                        }

                        storyImage.src = `data:image/jpeg;base64,${stories[currentStoryIndex].image}`;
                        storyModal.style.display = 'block';

                        // Reset progress bar
                        progress.style.width = '0%';

                        // Animate progress bar
                        let width = 0;
                        clearInterval(progressInterval);
                        progressInterval = setInterval(() => {
                            if (width >= 100) {
                                clearInterval(progressInterval);
                                currentStoryIndex++;
                                showStory();
                            } else {
                                width++;
                                progress.style.width = width + '%';
                            }
                        }, 300); // 300ms untuk 30 detik
                    }

                    // Fungsi untuk tombol "Next"
                    function nextStory() {
                        clearInterval(progressInterval);
                        currentStoryIndex++;
                        showStory();
                    }

                    // Fungsi untuk tombol "Previous"
                    function previousStory() {
                        clearInterval(progressInterval);
                        if (currentStoryIndex > 0) {
                            currentStoryIndex--;
                            showStory();
                        }
                    }

                    // Fungsi untuk menutup story
                    function closeStory() {
                        const storyModal = document.getElementById('storyModal');
                        clearInterval(progressInterval);
                        storyModal.style.display = 'none';
                        currentStoryIndex = 0;
                    }

                    // Fungsi untuk membuka modal upload
                    function openUploadModal() {
                        console.log('Opening upload modal...');
                        const uploadModal = document.getElementById('uploadModal');
                        console.log('Modal ditemukan:', uploadModal); // Debugging
                        if (uploadModal) {
                            uploadModal.style.display = 'block';
                            console.log('Modal ditampilkan'); // Debugging
                        } else {
                            console.error('Modal upload tidak ditemukan!');
                        }
                    }

                    // Fungsi untuk menutup modal upload
                    function closeUploadModal() {
                        const uploadModal = document.getElementById('uploadModal');
                        if (uploadModal) {
                            uploadModal.style.display = 'none';
                        }
                    }
                    <script>
                        document.getElementById('uploadForm').addEventListener('submit', function(e) {
                        //e.preventDefault(); // Mencegah submit langsung untuk debug

                        const formData = new FormData(this);
                        const file = formData.get('image');
                        
                        // Debug di console
                        console.log('File yang akan diunggah:', file);
                        console.log('Tipe:', file.type);
                        console.log('Ukuran:', file.size);

                        // Kirim form secara manual setelah debug
                        fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        //.then(response => response.json())
                        // .then(data => {
                        //     console.log('Respons server:', data);
                        //     alert(data.message || 'Story berhasil diunggah!');
                        //     location.reload(); // Refresh setelah berhasil
                        // })
                        // .catch(error => console.error('Error saat upload:', error));
                    });
                    </script>
                </script>
    </body>
</html>
