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

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'tager-blog');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->publishes([
            __DIR__ . '/../config.php' => config_path('tager-blog.php'),
        ]);

        TagerScopes::registerGroup(__('tager-blog::scopes.group'), [
            BlogScope::CategoriesEdit => __('tager-blog::scopes.edit_categories'),
            BlogScope::CategoriesCreate => __('tager-blog::scopes.create_categories'),
            BlogScope::CategoriesDelete => __('tager-blog::scopes.delete_categories'),
            BlogScope::PostsEdit => __('tager-blog::scopes.edit_posts'),
            BlogScope::PostsCreate => __('tager-blog::scopes.create_posts'),
            BlogScope::PostsDelete => __('tager-blog::scopes.delete_posts'),
        ]);

        TagerPanel::registerRouteHandler('.*', BlogPanelRouteHandler::class);

        TagerSeo::registerSitemapHandler(BlogSitemapHandler::class);

        $nameFieldLabel = __('tager-blog::seo-template.field_name');
        $titleFieldLabel = __('tager-blog::seo-template.field_title');
        $excerptFieldLabel = __('tager-blog::seo-template.field_excerpt');
        $bodyFieldLabel = __('tager-blog::seo-template.field_body');

        if (TagerBlogConfig::isMultiLang()) {
            foreach (TagerBlogConfig::getLanguageIds() as $languageId) {
                TagerSeo::registerParamsTemplate('blog_index_' . $languageId, new ParamsTemplate(
                    __('tager-blog::seo-template.blog_index_multilang', ['lang' => TagerBlogConfig::getLanguageLabel($languageId)]),
                    [], true, 'Blog'
                ));

                TagerSeo::registerParamsTemplate('blog_category_' . $languageId, new ParamsTemplate(
                    __('tager-blog::seo-template.blog_category_multilang', ['lang' => TagerBlogConfig::getLanguageLabel($languageId)]),
                    ['id' => 'ID', 'name' => $nameFieldLabel], false, 'Blog Category "{{title}}"'
                ));

                TagerSeo::registerParamsTemplate('blog_post_' . $languageId, new ParamsTemplate(
                    __('tager-blog::seo-template.blog_post_multilang', ['lang' => TagerBlogConfig::getLanguageLabel($languageId)]),
                    ['id' => 'ID', 'title' => $titleFieldLabel, 'excerpt' => $excerptFieldLabel, 'body' => $bodyFieldLabel],
                    false, 'Blog Post "{{title}}"'
                ));
            }
        } else {
            TagerSeo::registerParamsTemplate('blog_index', new ParamsTemplate(
                __('tager-blog::seo-template.blog_index'), [], true, 'Blog'
            ));

            TagerSeo::registerParamsTemplate('blog_category', new ParamsTemplate(
                __('tager-blog::seo-template.blog_category'),
                ['id' => 'ID', 'name' => $nameFieldLabel],
                false, 'Blog Category "{{title}}"'
            ));

            TagerSeo::registerParamsTemplate('blog_post', new ParamsTemplate(
                __('tager-blog::seo-template.blog_post'),
                ['id' => 'ID', 'title' => $titleFieldLabel, 'excerpt' => $excerptFieldLabel, 'body' => $bodyFieldLabel],
                false, 'Blog Post "{{title}}"'
            ));
        }
    }
}
