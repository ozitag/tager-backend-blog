<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\AdminCategoryResource;
use OZiTAG\Tager\Backend\Core\Feature;

class ListCategoriesFeature extends Feature
{
    public function handle(CategoryRepository $repository)
    {
        return AdminCategoryResource::collection($repository->all());
    }
}
