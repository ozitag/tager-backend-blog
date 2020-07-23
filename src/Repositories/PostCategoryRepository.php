<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use OZiTAG\Tager\Backend\Blog\Models\BlogPostCategory;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;

class PostCategoryRepository extends EloquentRepository
{
    public function __construct(BlogPostCategory $model)
    {
        parent::__construct($model);
    }

    public function deleteByPostId($postId)
    {
        return BlogPostCategory::wherePostId($postId)->delete();
    }
}
