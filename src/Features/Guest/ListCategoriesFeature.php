<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestCategoryResource;

class ListCategoriesFeature extends BaseFeature
{
    public function handle(CategoryRepository $categoryRepository)
    {
        if ($this->language) {
            $collection = $categoryRepository->getByLanguage($this->language);
        } else {
            $collection = $categoryRepository->all();
        }

        return GuestCategoryResource::collection($collection);
    }
}
