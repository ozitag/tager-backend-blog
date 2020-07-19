<?php

namespace OZiTAG\Tager\Backend\Blog;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class TagerBackendBlogServiceProvider extends RouteServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->publishes([
            __DIR__ . '/../config.php' => config_path('tager-blog.php'),
        ]);

        parent::boot();
    }
}
