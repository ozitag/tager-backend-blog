<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use OZiTAG\Tager\Backend\Blog\Models\BlogPostCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogPostTag;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;

class PostTagRepository extends EloquentRepository
{
    public function __construct(BlogPostTag $model)
    {
        parent::__construct($model);
    }

    public function deleteByPostId($postId)
    {
        return $this->model::query()->wherePostId($postId)->delete();
    }
}
