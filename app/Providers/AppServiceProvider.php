<?php

namespace App\Providers;

use App\Support\PlanTrial;
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
        View::share('wiStoreSupportEmail', config('wi-store.support_email'));
        View::share('wiStoreSupportName', config('wi-store.support_name'));
        View::share('wiStoreTrialDays', PlanTrial::days());
        View::share('wiStoreTrialDisclaimer', PlanTrial::disclaimer());
        View::share('wiStoreTrialLabel', PlanTrial::label());
    }
}
