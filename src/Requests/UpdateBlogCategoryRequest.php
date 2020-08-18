<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;

class UpdateBlogCategoryRequest extends CreateBlogCategoryRequest
{
    public function rules()
    {
        $language = TagerBlogConfig::isMultiLang() ? $this->language : 'NULL';

        return array_merge(parent::rules(), [
            'urlAlias' => [
                'string', 'required',
                'unique:tager_blog_categories,url_alias,' . $this->route('id', 0) . ',id,deleted_at,NULL,language,' . $language
            ]
        ]);
    }
}
