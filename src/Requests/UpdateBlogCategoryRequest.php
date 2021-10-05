<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;

class UpdateBlogCategoryRequest extends CreateBlogCategoryRequest
{
    public function rules()
    {
        return parent::rules();
    }
}
