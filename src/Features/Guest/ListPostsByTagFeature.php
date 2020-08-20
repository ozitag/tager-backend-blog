<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Repositories\TagRepository;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;

class ListPostsByTagFeature extends BaseFeature
{
    private $tag;

    public function __construct($tag, $language)
    {
        $this->tag = $tag;

        parent::__construct($language);
    }

    public function handle(PostRepository $postRepository, TagRepository $tagRepository)
    {
        $tag = $tagRepository->getByTag($this->tag);

        if (!$tag) {
            return GuestPostResource::collection([]);
        }

        return GuestPostResource::collection($postRepository->getByTag($tag, $this->language));
    }
}
