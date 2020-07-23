<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

class UpdateBlogCategoryRequest extends CreateBlogCategoryRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'urlAlias' => ['string', 'required', 'unique:tager_blog_categories,url_alias,' . $this->route('id')]
        ]);
    }
}
