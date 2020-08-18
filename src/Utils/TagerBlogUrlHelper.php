<?php

namespace OZiTAG\Tager\Backend\Blog\Utils;

use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;

class TagerBlogUrlHelper
{
    /**
     * @return string
     */
    private function getCategoryUrlTemplate($language = null)
    {
        $result = (string)config('tager-blog.url_templates.category', '/category/{alias}');
        return $this->processLanguageTemplate($result, $language);
    }

    /**
     * @return string
     */
    private function getPostUrlTemplate($language = null)
    {
        $result = (string)config('tager-blog.url_templates.post', '/post/{alias}');
        return $this->processLanguageTemplate($result, $language);
    }

    /**
     * @param string $template
     * @param string $language
     * @return string
     */
    private function processLanguageTemplate($template, $language)
    {
        if ($language) {
            $hideFromUrl = TagerBlogConfig::isLanguageHideFromUrl($language);
            if (!$hideFromUrl) {
                $template = str_replace('{language}', $language, $template);
            } else {
                $template = str_replace('{language}/', '', $template);
            }
        }

        return $template;
    }

    /**
     * @param string|null $language
     * @return string
     */
    public function getNewCategoryAliasTemplate($language = null)
    {
        $template = $this->getCategoryUrlTemplate($language);

        $template = str_replace('{id}', 'XXXX', $template);

        return $template;
    }

    /**
     * @param string|null $language
     * @return string
     */
    public function getNewPostAliasTemplate($language = null)
    {
        $template = $this->getPostUrlTemplate($language);

        $template = str_replace('{id}', 'XXXX', $template);

        return $template;
    }

    /**
     * @param BlogCategory $category
     * @return string
     */
    public function getCategoryUrl(BlogCategory $category)
    {
        $template = $this->getCategoryUrlTemplate($category->language);

        $template = str_replace('{id}', $category->id, $template);
        $template = str_replace('{alias}', $category->url_alias, $template);

        return $template;
    }

    /**
     * @param BlogPost $post
     * @return string
     */
    public function getPostUrl(BlogPost $post)
    {
        $template = $this->getPostUrlTemplate($post->language);

        $template = str_replace('{id}', $post->id, $template);
        $template = str_replace('{alias}', $post->url_alias, $template);

        return $template;
    }
}
