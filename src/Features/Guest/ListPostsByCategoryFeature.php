<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostFullResource;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;

class ListPostsByCategoryFeature extends Feature
{
    private $id;

    private $offset;

    private $limit;

    public function __construct($id, $offset, $limit)
    {
        $this->id = $id;

        $this->offset = $offset;

        $this->limit = $limit;
    }

    public function handle(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        $model = $categoryRepository->find($this->id);
        if (!$model) {
            abort(404, 'Category Not Found');
        }

        return GuestPostResource::collection($postRepository->findByCategoryId($model->id, $this->offset, $this->limit));
    }
}
