<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 3/20/19 11:54 AM
 */

namespace App\Components\Passerby\Providers;

use App\Components\Passerby\Listeners\LoginMessageEventSubscriber;
use App\Components\Passerby\Repositories\Login\LoginRepository;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class PasserbyServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $dispatcher = $this->app->make('events');
        $dispatcher->subscribe(LoginMessageEventSubscriber::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->register(\App\Components\Signature\Providers\SignatureServiceProvider::class);
        $this->app->register(\App\Components\Signal\Providers\SignalServiceProvider::class);

        $this->app->bind(\App\Components\Passerby\Repositories\LoginRepositoryInterface::class, function($app) {
            return new LoginRepository();
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('password.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'password'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/passerby');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath,
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function($path) {
            return $path . '/modules/passerby';
        }, \Config::get('view.paths')), [$sourcePath]), 'passerby');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/passerby');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'passerby');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'passerby');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
