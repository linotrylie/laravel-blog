<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserApiTokenRepository::class, \App\Repositories\UserApiTokenRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\HomeMenuRepository::class, \App\Repositories\HomeMenuRepositoryEloquent::class);
        //:end-bindings:
    }
}
