<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaLanguage\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Wame\LaravelNovaLanguage\Models\Language;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        Nova::resources([
            \Wame\LaravelNovaLanguage\Nova\Language::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Language::shouldBeStrict();
    }
}
