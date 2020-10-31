<?php

namespace OZiTAG\Tager\Backend\Blog;

use OZiTAG\Tager\Backend\Blog\Enums\BlogScope;
use OZiTAG\Tager\Backend\Mail\Enums\MailScope;
use OZiTAG\Tager\Backend\ModuleSettings\ModuleSettingsServiceProvider;
use OZiTAG\Tager\Backend\Panel\TagerPanel;
use OZiTAG\Tager\Backend\Rbac\TagerScopes;

class BlogServiceProvider extends ModuleSettingsServiceProvider
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
        parent::boot();

        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->publishes([
            __DIR__ . '/../config.php' => config_path('tager-blog.php'),
        ]);

        TagerScopes::registerGroup('Blog', [
            BlogScope::Settings => 'Edit settings',
            BlogScope::CategoriesEdit => 'Edit categories',
            BlogScope::CategoriesCreate => 'Create categories',
            BlogScope::CategoriesDelete => 'Delete categories',
            BlogScope::PostsEdit => 'Edit posts',
            BlogScope::PostsCreate => 'Create posts',
            BlogScope::PostsDelete => 'Delete posts',
        ]);

        TagerPanel::registerRouteHandler('.*', BlogPanelRouteHandler::class);
    }
}
