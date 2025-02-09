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
        <div class="min-h-screen bg-gray-100">
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
            document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".toggle-reply").forEach(function (icon) {
                    icon.addEventListener("click", function () {
                        const commentId = this.closest(".comment").querySelector("input[name='parent_comment_id']").value;
                        const replyFormContainer = document.getElementById(`reply-form-${commentId}`);
                        replyFormContainer.style.display = replyFormContainer.style.display === "none" ? "block" : "none";
                    });
                });
            });
            </script>
    </body>
</html>
