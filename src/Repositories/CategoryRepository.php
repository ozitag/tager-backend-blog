<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;

class CategoryRepository extends EloquentRepository
{
    public function __construct(BlogCategory $model)
    {
        parent::__construct($model);
    }

    public function getByAlias($alias)
    {
        return BlogCategory::whereUrlAlias($alias)->first();
    }
}
