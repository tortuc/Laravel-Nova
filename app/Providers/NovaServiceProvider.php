<?php

namespace App\Providers;

use App\Nova\Metrics\FbReporting\TagsDailyTotalProfit;
use App\Nova\Metrics\FbReporting\TagsDailyTotalRevenue;
use App\Nova\Metrics\FbReporting\TagsDailyTotalRoi;
use App\Nova\Metrics\FbReporting\TagsDailyTotalSpend;
use FbReporting\TypeDailyPerf\TypeDailyPerf;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            
            // (new TagsDailyTotalSpend())->width('1/4'),
            // (new TagsDailyTotalRevenue())->width('1/4'),
            // (new TagsDailyTotalProfit())->width('1/4'),
            // (new TagsDailyTotalRoi())->width('1/4'),
            (new TypeDailyPerf())->dailyTotalsByTag(),
            // new Help,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}