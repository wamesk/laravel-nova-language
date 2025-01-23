<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaLanguage\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Wame\LaravelNovaLanguage\Models\Language;
use Wame\LaravelNovaLanguage\Policies\LanguagePolicy;

class LaraveNovaLanguageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'laravel-nova-language');

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
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        
        Language::shouldBeStrict();

        Gate::policy(Language::class, LanguagePolicy::class);
    }
}
