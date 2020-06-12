<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestCategoryResource;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestFullCategoryResource;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;
use OZiTAG\Tager\Backend\Core\Feature;

class ListPostsByCategoryFeature extends Feature
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        $category = $categoryRepository->find($this->id);
        if (!$category) {
            abort(404, 'Category not found');
        }

        return GuestPostResource::collection($postRepository->findByCategoryId($category->id));
    }
}
