<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

class UpdateBlogPostRequest extends CreateBlogPostRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'urlAlias' => 'required|string'
        ]);
    }
}
