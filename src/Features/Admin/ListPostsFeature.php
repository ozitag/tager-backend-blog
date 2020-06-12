<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\AdminCategoryResource;
use OZiTAG\Tager\Backend\Blog\Resources\AdminPostResource;
use OZiTAG\Tager\Backend\Core\Feature;

class ListPostsFeature extends Feature
{
    public function handle(PostRepository $postRepository)
    {
        return AdminPostResource::collection($postRepository->all());
    }
}
