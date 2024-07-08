<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;

class LanguageComposerServiceProvider extends ServiceProvider
{
    


    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\Interfaces\LanguageRepositoryInterface',
        'App\Repositories\LanguageRepository');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('backend.dashboard.component.nav', function($view) {
            $languageRepository = $this->app->make(LanguageRepository::class);
            $language = $languageRepository->all();
            $view->with('language', $language);
        });
    }
}
