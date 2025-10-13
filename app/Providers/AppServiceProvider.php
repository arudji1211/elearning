<?php

namespace App\Providers;

use App\Services\CourseServices;
use App\Services\impl\CourseServicesImpl;
use App\Services\impl\UserServicesImpl;
use App\Services\UserServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(CourseServices::class, CourseServicesImpl::class);
        $this->app->bind(UserServices::class, UserServicesImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
