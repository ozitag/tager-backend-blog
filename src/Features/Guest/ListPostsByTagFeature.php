<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Repositories\TagRepository;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;

class ListPostsByTagFeature extends BaseFeature
{
    private $tag;

    private $offset;

    private $limit;

    public function __construct($tag, $language, $offset, $limit)
    {
        $this->tag = $tag;

        $this->offset = $offset;

        $this->limit = $limit;

        parent::__construct($language);
    }

    public function handle(PostRepository $postRepository, TagRepository $tagRepository)
    {
        $tag = $tagRepository->getByTag($this->tag);

        if (!$tag) {
            return GuestPostResource::collection([]);
        }

        return GuestPostResource::collection($postRepository->getByTag($tag, $this->language, $this->offset, $this->limit));
    }
}
