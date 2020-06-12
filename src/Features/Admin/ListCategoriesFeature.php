<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Core\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminCategoryResource;

class ListCategoriesFeature extends Feature
{
    public function handle(CategoryRepository $repository)
    {
        return AdminCategoryResource::collection($repository->all());
    }
}
