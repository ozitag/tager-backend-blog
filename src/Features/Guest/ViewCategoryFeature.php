<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestFullCategoryResource;
use OZiTAG\Tager\Backend\Core\Feature;

class ViewCategoryFeature extends Feature
{
    private $alias;

    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    public function handle(CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->getByAlias($this->alias);
        if (!$category) {
            abort(404, 'Category not found');
        }

        return new GuestFullCategoryResource($category);
    }
}
