<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use OZiTAG\Tager\Backend\Blog\Models\BlogPostCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogPostRelatedPost;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;

class PostRelatedPostRepository extends EloquentRepository
{
    public function __construct(BlogPostRelatedPost $model)
    {
        parent::__construct($model);
    }

    public function deleteByPostId($postId)
    {
        return $this->model::wherePostId($postId)->delete();
    }
}
