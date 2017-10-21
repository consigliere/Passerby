<?php

namespace App\Components\Passerby\Providers;

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

        $this->loadMigrationsFrom(__DIR__.'/../../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Optimus\ApiConsumer\Provider\LaravelServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../../Config/config.php' => config_path('passerby.php'),
        ],'config-passerby');
        $this->mergeConfigFrom(
            __DIR__.'/../../Config/config.php', 'passerby'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/components/passerby');

        $sourcePath = __DIR__.'/../../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/components/passerby';
        }, \Config::get('view.paths')), [$sourcePath]), 'passerby');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/components/passerby');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'passerby');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../../Resources/lang', 'passerby');
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
