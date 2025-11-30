<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
        View::composer('*', function ($view) {
        $user = Auth::user();

        if ($user) {
            $newNotificationCount = Notification::where('is_read', 0)
                ->where('user_id', $user->id)
                ->count();

            $newMessageCount = Message::where('is_read', 0)->count();

            $view->with([
                'newNotificationCount' => $newNotificationCount,
                'newMessageCount' => $newMessageCount,
            ]);
        }
    });

    }
}