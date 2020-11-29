<?php

namespace OZiTAG\Tager\Backend\Blog;

use Carbon\Carbon;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;
use OZiTAG\Tager\Backend\Sitemap\Contracts\ISitemapHandler;
use OZiTAG\Tager\Backend\Sitemap\Structures\SitemapItem;

class BlogSitemapHandler implements ISitemapHandler
{
    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var PostRepository */
    private $postRepository;

    /** @var TagerBlogUrlHelper */
    private $urlHelper;

    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository, TagerBlogUrlHelper $tagerBlogUrlHelper)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
        $this->urlHelper = $tagerBlogUrlHelper;
    }

    public function handle()
    {
        $categories = $this->categoryRepository->all();
        $posts = $this->postRepository->all();

        $result = [];

        $languages = TagerBlogConfig::getLanguageIds();
        if (empty($languages)) {
            $homeUrl = $this->urlHelper->getHomeUrl();
            if (!empty($homeUrl)) {
                $result[] = new SitemapItem($homeUrl);
            }
        } else {
            foreach ($languages as $language) {
                $homeUrl = $this->urlHelper->getHomeUrl($language);
                if (!empty($homeUrl)) {
                    $result[] = new SitemapItem($homeUrl);
                }
            }
        }

        foreach ($categories as $category) {
            $result[] = new SitemapItem('/' . $category->url);
        }

        foreach ($posts as $post) {
            $result[] = new SitemapItem('/' . $post->url, new Carbon($post->updated_at));
        }

        return $result;
    }
}
