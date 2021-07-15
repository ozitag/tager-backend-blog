<?php

namespace OZiTAG\Tager\Backend\Blog\Requests;

use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;

class UpdateBlogPostRequest extends CreateBlogPostRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            'relatedPosts.*' => ['exists:' . BlogPost::class . ',id,deleted_at,NULL', 'notIn:' . $this->route('id')]
        ]);
    }
}
