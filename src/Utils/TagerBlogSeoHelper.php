<?php

namespace OZiTAG\Tager\Backend\Blog\Utils;

use Illuminate\Support\Facades\App;
use OZiTAG\Tager\Backend\Blog\Enums\BlogSettingField;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Fields\Enums\FieldType;
use OZiTAG\Tager\Backend\ModuleSettings\ModuleSettings;

class TagerBlogSeoHelper
{
    private $moduleSettings;

    public function __construct()
    {
        $this->moduleSettings = App::make(ModuleSettings::class);
    }

    private function apply($settingField, $templateParams, $default = null)
    {
        $template = $this->moduleSettings->getPublicValue('blog', $settingField, FieldType::String);
        if (empty($template)) {
            return $default;
        }

        foreach ($templateParams as $param => $value) {
            $template = str_replace('{{' . $param . '}}', $value, $template);
        }

        return $template;
    }

    /**
     * @param BlogCategory $category
     * @return string
     */
    public function getCategoryTitle(BlogCategory $category)
    {
        if (!empty($category->page_title)) {
            return $category->page_title;
        }

        return $this->apply(BlogSettingField::CategoryTitleTemplate, [
            'id' => $category->id,
            'name' => $category->name
        ], $category->name);
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

        return $this->apply(BlogSettingField::CategoryDescriptionTemplate, [
            'id' => $category->id,
            'name' => $category->name
        ]);
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

        return $this->apply(BlogSettingField::PostTitleTemplate, [
            'id' => $post->id,
            'name' => $post->name,
            'excerpt' => $post->excerpt,
            'body' => $post->body
        ], $post->name);
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

        return $this->apply(BlogSettingField::PostDescriptionTemplate, [
            'id' => $post->id,
            'name' => $post->name,
            'excerpt' => $post->excerpt,
            'body' => $post->body
        ], $post->excerpt);
    }
}
