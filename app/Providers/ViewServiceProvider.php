<?php

namespace App\Providers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    // public function boot()
    // {
    //     // Kirim data rekomendasi ke semua view
    //     View::composer('*', function ($view) {
    //         if (Auth::check()) {
    //             $recommendations = User::where('id', '!=', Auth::id())
    //                 ->whereDoesntHave('followers', fn($query) => $query->where('follower_id', Auth::id()))
    //                 ->limit(5)
    //                 ->get();

    //             $view->with('recommendations', $recommendations);
    //         } else {
    //             $view->with('recommendations', collect()); // Kosong jika tidak login
    //         }
    //     });
    // }
    // public function boot()
    // {
    //     // Kirim data rekomendasi ke semua view
    //     View::composer('*', function ($view) {
    //         if (Auth::check()) {
    //             $recommendations = User::where('id', '!=', Auth::id())
    //                 ->limit(5)
    //                 ->get();
    //             $view->with('recommendations', $recommendations);
    //         } else {
    //             $view->with('recommendations', collect()); // Kosong jika tidak login
    //         }
    //     });
    // }
    public function boot()
    {
        // Kirim data rekomendasi ke semua view
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $recommendations = User::where('id', '!=', Auth::id())
                    ->with(['followers' => fn($query) => $query->where('follower_id', Auth::id())])
                    ->limit(5)
                    ->get()
                    ->map(function ($user) {
                        $user->is_followed = $user->followers->isNotEmpty(); // Tambahkan status "is_followed"
                        return $user;
                    });
                $view->with('recommendations', $recommendations);
            } else {
                $view->with('recommendations', collect()); // Kosong jika tidak login
            }
        });
    }
}
