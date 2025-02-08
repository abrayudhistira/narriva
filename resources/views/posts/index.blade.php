<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Feed Postingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Posting -->
            <div class="bg-white p-6 rounded-md shadow-md">
                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <textarea name="caption" class="w-full p-2 border rounded-md" placeholder="Apa yang Anda pikirkan?"></textarea>
                        @error('caption')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Upload Gambar</label>
                        <input type="file" name="image" class="mt-1 block w-full border p-2 rounded-md">
                        @error('image')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                        Simpan
                    </button>
                </form>
            </div>

            <!-- Daftar Postingan -->
            <div class="mt-6">
            @foreach ($posts as $post)
                <div class="bg-white shadow-md rounded p-4 my-4">
                    <!-- User Information -->
                    <div class="flex items-center mb-4">
                        <!-- Profile Picture -->
                        @if ($post->user->profile_picture)
                            <img src="{{ $post->user->profile_picture }}" alt="Profile Picture" class="rounded-lg object-cover" style="width: 50px; height: 50px !important; margin-right: 10px;">
                        @else
                            <div class="w-6 h-6 bg-gray-300 rounded-lg"></div>
                        @endif
                        <!-- Username -->
                        <span class="ml-2 font-semibold">@ {{ $post->user->username }}</span>
                    </div>
                    <!-- Post Content -->
                    <p>{{ $post->caption }}</p>

                    <!-- Post Image -->
                    @if ($post->image)
                        <img src="data:image/jpeg;base64,{{ base64_encode($post->image) }}" class="mt-4 w-full rounded">
                    @endif
                </div>
            @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
