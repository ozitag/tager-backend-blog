<?php

namespace OZiTAG\Tager\Backend\Blog\Utils;

use Illuminate\Support\Facades\App;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Fields\Enums\FieldType;
use OZiTAG\Tager\Backend\ModuleSettings\ModuleSettings;
use OZiTAG\Tager\Backend\Seo\TagerSeo;

class TagerBlogSeoHelper
{
    /**
     * @param BlogCategory $category
     * @return string
     */
    public function getCategoryTitle(BlogCategory $category)
    {
        if (!empty($category->page_title)) {
            return $category->page_title;
        }

        $params = [
            'id' => $category->id,
            'name' => $category->name
        ];

        if (TagerBlogConfig::isMultiLang()) {
            return TagerSeo::getPageTitle('blog_category_' . $post->language, $params);
        } else {
            return TagerSeo::getPageTitle('blog_category', $params);
        }
    }

    /**
     * @param BlogCategory $category
     * @return string
     */
    public function getCategoryDescription(BlogCategory $category)
    {
        if (!empty($category->page_description)) {
            return $category->page_description;
        }

        $params = [
            'id' => $category->id,
            'name' => $category->name
        ];

        if (TagerBlogConfig::isMultiLang()) {
            return TagerSeo::getPageDescription('blog_category_' . $post->language, $params);
        } else {
            return TagerSeo::getPageDescription('blog_category', $params);
        }
    }

    /**
     * @param BlogPost $post
     * @return string
     */
    public function getPostTitle(BlogPost $post)
    {
        if (!empty($post->page_title)) {
            return $post->page_title;
        }

        $params = [
            'id' => $post->id,
            'title' => $post->title,
            'excerpt' => $post->excerpt,
            'body' => $post->body
        ];

        if (TagerBlogConfig::isMultiLang()) {
            return TagerSeo::getPageTitle('blog_post_' . $post->language, $params);
        } else {
            return TagerSeo::getPageTitle('blog_post', $params);
        }
    }

    /**
     * @param BlogPost $post
     * @return string
     */
    public function getPostDescription(BlogPost $post)
    {
        if (!empty($post->page_description)) {
            return $post->page_description;
        }

        $params = [
            'id' => $post->id,
            'title' => $post->title,
            'excerpt' => $post->excerpt,
            'body' => $post->body
        ];

        if (TagerBlogConfig::isMultiLang()) {
            return TagerSeo::getPageDescription('blog_post_' . $post->language, $params);
        } else {
            return TagerSeo::getPageDescription('blog_post', $params);
        }
    }
}
