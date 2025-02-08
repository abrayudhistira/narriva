<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <!-- Profile Picture -->
    <div>
        <x-input-label for="profile_picture" :value="__('Profile Picture')" />
        <input id="profile_picture" type="file" name="profile_picture" accept="image/*" class="mt-1 block w-full" />

        @if ($user->profile_picture)
            <img src="{{ $user->profile_picture }}" alt="Profile Picture" class="mt-2 w-32 h-32 rounded-full object-cover">
        @endif

        <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
    </div>

    <!-- Username -->
    <div class="mt-4">
        <x-input-label for="username" :value="__('Username')" />
        <x-text-input id="username" type="text" name="username" :value="$user->username" class="mt-1 block w-full" required />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>

    <!-- Email -->
    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" type="email" name="email" :value="$user->email" class="mt-1 block w-full" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Bio -->
    <div class="mt-4">
        <x-input-label for="bio" :value="__('Bio')" />
        <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $user->bio }}</textarea>
        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button>
            {{ __('Save') }}
        </x-primary-button>
    </div>
</form>
