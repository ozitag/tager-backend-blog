<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestCategoryResource;
use OZiTAG\Tager\Backend\Core\Feature;

class ListCategoriesFeature extends Feature
{
    public function handle(CategoryRepository $categoryRepository)
    {
        return GuestCategoryResource::collection($categoryRepository->all());
    }
}
