<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use OZiTAG\Tager\Backend\Blog\Models\BlogPostCategory;

class UpdateBlogCategoryRequest extends CreateBlogCategoryRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'urlAlias' => ['string', 'required', 'unique:tager_blog_categories,url_alias,' . $this->route('id')]
        ]);
    }
}
