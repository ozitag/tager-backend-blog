<?php

namespace OZiTAG\Tager\Backend\Blog;

use Illuminate\Console\Scheduling\Schedule;
use OZiTAG\Tager\Backend\Blog\Console\FlushBlogUpdateFileScenariosCommand;
use OZiTAG\Tager\Backend\Blog\Console\UpdateTagerBlogPostStatusesCommand;
use OZiTAG\Tager\Backend\Blog\Enums\BlogScope;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Panel\TagerPanel;
use OZiTAG\Tager\Backend\Rbac\TagerScopes;
use OZiTAG\Tager\Backend\Seo\Structures\ParamsTemplate;
use OZiTAG\Tager\Backend\Seo\TagerSeo;
use Illuminate\Support\ServiceProvider;


class BlogServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            UpdateTagerBlogPostStatusesCommand::class
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'tager-blog');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->publishes([
            __DIR__ . '/../config.php' => config_path('tager-blog.php'),
        ]);

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('cron:tager-blog:update-post-statuses')->everyMinute();
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                FlushBlogUpdateFileScenariosCommand::class,
                UpdateTagerBlogPostStatusesCommand::class,
            ]);
        }

        TagerScopes::registerGroup(__('tager-blog::scopes.group'), [
            BlogScope::CategoriesEdit->value => __('tager-blog::scopes.edit_categories'),
            BlogScope::CategoriesCreate->value => __('tager-blog::scopes.create_categories'),
            BlogScope::CategoriesDelete->value => __('tager-blog::scopes.delete_categories'),
            BlogScope::PostsEdit->value => __('tager-blog::scopes.edit_posts'),
            BlogScope::PostsCreate->value => __('tager-blog::scopes.create_posts'),
            BlogScope::PostsDelete->value => __('tager-blog::scopes.delete_posts'),
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
