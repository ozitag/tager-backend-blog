<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;
use OZiTAG\Tager\Backend\Core\Feature;

class ListPostsFeature extends Feature
{
    public function handle(PostRepository $postRepository)
    {
        return GuestPostResource::collection($postRepository->all());
    }
}