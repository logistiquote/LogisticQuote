<?php

namespace App\Providers;

use App\Models\Quotation;
use App\Observers\QuotationObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\LocationImport\ImportStrategyBuilderInterface::class,
            \App\Services\LocationImport\ImportStrategyBuilder::class
        );
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        Quotation::observe(QuotationObserver::class);
    }
}
