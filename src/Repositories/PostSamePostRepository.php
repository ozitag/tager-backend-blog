<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use OZiTAG\Tager\Backend\Blog\Models\BlogPostCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogPostSamePost;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;

class PostSamePostRepository extends EloquentRepository
{
    public function __construct(BlogPostSamePost $model)
    {
        parent::__construct($model);
    }

    public function deleteByPostId($postId)
    {
        return $this->model::wherePostId($postId)->delete();
    }
}
