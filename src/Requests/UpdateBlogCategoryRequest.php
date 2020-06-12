<?php

namespace OZiTAG\Tager\Backend\Seo\Requests;

class UpdateBlogCategoryRequest extends CreateBlogCategoryRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'urlAlias' => 'required|string'
        ]);
    }
}