<?php

namespace App\Providers;

use App\Support\ViewComposerDefiners\DashboardViewComposersDefiner;
use App\Support\ViewComposerDefiners\FrontViewComposersDefiner;
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
        FrontViewComposersDefiner::defineAll();
        DashboardViewComposersDefiner::defineAll();
    }
}
