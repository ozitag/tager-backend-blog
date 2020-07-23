<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestCategoryResource;

class ListCategoriesFeature extends Feature
{
    public function handle(CategoryRepository $categoryRepository)
    {
        return GuestCategoryResource::collection($categoryRepository->all());
    }
}
