<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminPostResource;

class ListPostsFeature extends Feature
{
    public function handle(PostRepository $postRepository)
    {
        return AdminPostResource::collection($postRepository->all());
    }
}
