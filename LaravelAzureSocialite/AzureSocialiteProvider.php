<?php

namespace Shawinigan\Sso\LaravelAzureSocialite;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class AzureSocialiteProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__.'/Routes/sso.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/lang', 'shawinigan_sso');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'shawinigan_sso');

        $this->publishes([
            __DIR__.'/lang' => $this->app->langPath('vendor/shawinigan_sso'),
            __DIR__.'/resources/views' => resource_path('views/vendor/shawinigan_sso'),
        ]);
    }
}
