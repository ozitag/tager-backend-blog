<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;

class ListPostsFeature extends BaseFeature
{
    public function handle(PostRepository $postRepository)
    {
        if ($this->language) {
            $collection = $postRepository->getByLanguage($this->language);
        } else {
            $collection = $postRepository->all();
        }

        return GuestPostResource::collection($collection);
    }
}
