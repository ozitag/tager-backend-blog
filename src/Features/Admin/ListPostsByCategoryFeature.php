<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryByIdJob;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminPostResource;

class ListPostsByCategoryFeature extends Feature
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle(PostRepository $postRepository)
    {
        $model = $this->run(GetCategoryByIdJob::class, ['id' => $this->id]);
        if (!$model) {
            abort(404, 'Category not found');
        }

        return AdminPostResource::collection($postRepository->findByCategoryId($model->id));
    }
}
