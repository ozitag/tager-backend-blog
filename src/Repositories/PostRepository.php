<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
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

    public function findByCategoryId($id)
    {
        $repository = new CategoryRepository(new BlogCategory());
        $model = $repository->find($id);

        return $model->posts()->get();
    }
}
