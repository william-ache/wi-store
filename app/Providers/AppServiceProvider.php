<?php

namespace App\Providers;

use App\Support\PlanCatalog;
use App\Support\PlanPricing;
use App\Support\PlanTrial;
use App\Support\PlatformPlanSettings;
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
        View::share('wiStorePlanPricing', PlanCatalog::pricing());
        View::share('wiStorePlanLimitsStandard', PlatformPlanSettings::limits('standard'));
        View::share('wiStorePlanLimitsPremium', PlatformPlanSettings::limits('premium'));
        View::share('wiStoreTrialLimits', PlanCatalog::trialLimits());
        View::share('wiStorePostTrialPlanName', PlanCatalog::postTrialMarketingName());
        View::share('wiStorePostTrialMonthly', PlanCatalog::postTrialMonthlyFormatted());
    }
}
