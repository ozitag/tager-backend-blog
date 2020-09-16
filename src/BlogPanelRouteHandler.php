<?php

namespace OZiTAG\Tager\Backend\Blog;

use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogSeoHelper;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;
use OZiTAG\Tager\Backend\Pages\Repositories\PagesRepository;
use OZiTAG\Tager\Backend\Panel\Contracts\IRouteHandler;
use OZiTAG\Tager\Backend\Panel\Structures\TagerRouteHandlerResult;

class BlogPanelRouteHandler implements IRouteHandler
{
    /** @var PostRepository */
    private $postRepository;

    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(PostRepository $postRepository, CategoryRepository $categoryRepository)
    {
        $this->postRepository = $postRepository;

        $this->categoryRepository = $categoryRepository;
    }

    private function findPost($language, $id, $alias)
    {
        if (!$id && !$alias) return null;

        if ($alias && !$id) {
            return $this->postRepository->getByAlias($alias, $language);
        }

        $model = $this->postRepository->find($id);

        if (!$model) {
            return null;
        }

        if (($alias && $model->url_alias == $alias) && $model->language == $language) {
            return $model;
        }

        return null;
    }

    private function resultPost(BlogPost $post)
    {
        $result = new TagerRouteHandlerResult();

        $result->setModel('Post', $post->title);
        $result->addAction('Edit Post', '/blog/posts/' . $post->id);

        return $result;
    }

    private function findCategory($language, $id, $alias)
    {
        if (!$id && !$alias) return null;

        if ($alias && !$id) {
            return $this->categoryRepository->getByAlias($alias, $language);
        }

        $model = $this->categoryRepository->find($id);

        if (!$model) {
            return null;
        }

        if (($alias && $model->url_alias == $alias) && $model->language == $language) {
            return $model;
        }

        return null;
    }

    private function resultCategory(BlogCategory $category)
    {
        $result = new TagerRouteHandlerResult();

        $result->setModel('Category', $category->name);
        $result->addAction('Edit Category', '/blog/categories/' . $category->id);
        $result->addAction('Category Posts', '/blog/posts?category=' . $category->id);

        return $result;
    }

    private function checkPost($route)
    {
        $urlTemplate = TagerBlogConfig::getPostUrlTemplate();

        $languageIds = TagerBlogConfig::isMultiLang() == false ? [null] : TagerBlogConfig::getLanguageIds();

        foreach ($languageIds as $language) {

            if (!$language || TagerBlogConfig::isLanguageHideFromUrl($language)) {
                $urlTemplateRegex = '#^' . str_replace(['{language}/', '{alias}', '{id}'], ['', '(?P<alias>.+?)', '(?P<id>\d+?)'], $urlTemplate) . '$#';
            } else {
                $urlTemplateRegex = '#^' . str_replace(['{language}', '{alias}', '{id}'], [$language, '(?P<alias>.+?)', '(?P<id>\d+?)'], $urlTemplate) . '$#';
            }

            if (!preg_match($urlTemplateRegex, $route, $matches)) {
                continue;
            }

            $post = $this->findPost($language, $matches['id'] ?? null, $matches['alias'] ?? null);
            if ($post) {
                return $this->resultPost($post);
            }
        }

        return null;
    }

    private function checkCategory($route)
    {
        $urlTemplate = TagerBlogConfig::getCategoryUrlTemplate();

        $languageIds = TagerBlogConfig::isMultiLang() == false ? [null] : TagerBlogConfig::getLanguageIds();

        foreach ($languageIds as $language) {
            if (!$language || TagerBlogConfig::isLanguageHideFromUrl($language)) {
                $urlTemplateRegex = '#^' . str_replace(['{language}/', '{alias}', '{id}'], ['', '(?P<alias>.+?)', '(?P<id>\d+?)'], $urlTemplate) . '$#';
            } else {
                $urlTemplateRegex = '#^' . str_replace(['{language}', '{alias}', '{id}'], [$language, '(?P<alias>.+?)', '(?P<id>\d+?)'], $urlTemplate) . '$#';
            }

            if (!preg_match($urlTemplateRegex, $route, $matches)) {
                continue;
            }

            $post = $this->findCategory($language, $matches['id'] ?? null, $matches['alias'] ?? null);
            if ($post) {
                return $this->resultCategory($post);
            }
        }

        return null;
    }


    public function handle($route, $matches)
    {
        $result = $this->checkCategory($route);
        if (!$result) {
            $result = $this->checkPost($route);
        }

        return $result;
    }
}
