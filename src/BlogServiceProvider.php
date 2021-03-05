<?php

namespace OZiTAG\Tager\Backend\Blog;

use OZiTAG\Tager\Backend\Blog\Enums\BlogScope;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Mail\Enums\MailScope;
use OZiTAG\Tager\Backend\ModuleSettings\ModuleSettingsServiceProvider;
use OZiTAG\Tager\Backend\Panel\TagerPanel;
use OZiTAG\Tager\Backend\Rbac\TagerScopes;
use OZiTAG\Tager\Backend\Seo\Structures\ParamsTemplate;
use OZiTAG\Tager\Backend\Seo\TagerSeo;
use OZiTAG\Tager\Backend\Sitemap\TagerSitemap;

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

        TagerSitemap::registerHandler(BlogSitemapHandler::class);
        
        if (TagerBlogConfig::isMultiLang()) {
            foreach (TagerBlogConfig::getLanguageIds() as $languageId) {
                TagerSeo::registerParamsTemplate('blog_index_' . $languageId, new ParamsTemplate(
                    'Blog - Home' . ' (' . TagerBlogConfig::getLanguageLabel($languageId) . ')',
                    [], true, 'Blog'
                ));

                TagerSeo::registerParamsTemplate('blog_category_' . $languageId, new ParamsTemplate(
                    'Blog - Category' . ' (' . TagerBlogConfig::getLanguageLabel($languageId) . ')',
                    ['id' => 'ID', 'name' => 'Name'], false, 'Blog Category "{{title}}"'
                ));

                TagerSeo::registerParamsTemplate('blog_post_' . $languageId, new ParamsTemplate(
                    'Blog - Post' . ' (' . TagerBlogConfig::getLanguageLabel($languageId) . ')',
                    ['id' => 'ID', 'title' => 'Title', 'excerpt' => 'Excerpt', 'body' => 'Body'],
                    false, 'Blog Post "{{title}}"'
                ));
            }
        } else {
            TagerSeo::registerParamsTemplate('blog_index', new ParamsTemplate(
                'Blog - Home', [], true, 'Blog'
            ));

            TagerSeo::registerParamsTemplate('blog_category', new ParamsTemplate(
                'Blog - Category',
                ['id' => 'ID', 'name' => 'Name'],
                false, 'Blog Category "{{title}}"'
            ));

            TagerSeo::registerParamsTemplate('blog_post', new ParamsTemplate(
                'Blog - Post',
                ['id' => 'ID', 'title' => 'Title', 'excerpt' => 'Excerpt', 'body' => 'Body'],
                false, 'Blog Post "{{title}}"'
            ));
        }
    }
}
