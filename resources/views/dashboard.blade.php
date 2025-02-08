<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard - Posts Feed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-4">Create a Post</h3>
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <textarea name="caption" class="w-full p-2 border rounded" placeholder="Write a caption..." required></textarea>
                        <input type="file" name="images[]" class="mt-2" multiple>
                        <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                            Post
                        </button>
                    </form>
                </div>

                <div class="mt-8">
                    <h3 class="font-semibold text-lg">Posts Feed</h3>
                    @foreach ($posts as $post)
                        <div class="p-4 mt-4 border rounded bg-gray-50">
                            <h4 class="font-bold">{{ $post->user->name }}</h4>
                            <p>{{ $post->caption }}</p>
                            <small>{{ $post->created_at->format('d M Y, H:i') }}</small>

                            @if ($post->images->count())
                                <div class="flex mt-2">
                                    @foreach ($post->images as $image)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($image->image) }}" alt="Post Image" class="w-20 h-20 object-cover mr-2">
                                    @endforeach
                                </div>
                            @endif

                            <h5 class="mt-4 font-semibold">Comments</h5>
                            @foreach ($post->comments as $comment)
                                <div class="mt-2 ml-4 p-2 bg-gray-100 rounded">
                                    <p class="font-bold">{{ $comment->user->name }}</p>
                                    <p>{{ $comment->comment }}</p>

                                    <!-- Reply Form -->
                                    <form action="{{ route('posts.reply') }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
                                        <textarea name="comment" class="w-full p-2 border rounded" placeholder="Write a reply..." required></textarea>
                                        <button type="submit" class="mt-2 bg-green-500 text-white px-4 py-2 rounded">
                                            Reply
                                        </button>
                                    </form>
                                </div>
                            @endforeach

                            <!-- Comment Form -->
                            <form action="{{ route('posts.comment') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <textarea name="comment" class="w-full p-2 border rounded" placeholder="Write a comment..." required></textarea>
                                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                                    Comment
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>