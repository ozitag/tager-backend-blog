<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;

class PostRepository extends EloquentRepository
{
    public function __construct(BlogPost $model)
    {
        parent::__construct($model);
    }

    public function getByAlias($alias)
    {
        return BlogPost::whereUrlAlias($alias)->first();
    }

    public function getByCategoryId($id)
    {
        return BlogPost::whereUrlAlias($alias)->first();
    }
}
