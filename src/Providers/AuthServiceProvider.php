<?php
/**
 * AuthServiceProvider.php
 * Created by rn on 10/23/2017 12:53 AM.
 */

namespace App\Components\Passerby\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Components\Passerby\Repositories\UserRepository;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Api\App\Providers\AppServiceProvider::class);

        $this->app->bind('App\Components\Passerby\Repositories\UserRepositoryInterface', function ($app) {
            return new UserRepository();
        });
    }

}