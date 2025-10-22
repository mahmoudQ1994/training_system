<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SystemSetting;

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
        // ✅ مشاركة إعدادات النظام في كل الـ Views
        View::composer('*', function ($view) {
            $settings = SystemSetting::first();
            $view->with('systemSettings', $settings);
        });
    }
}
