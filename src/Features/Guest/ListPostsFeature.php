<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;

class ListPostsFeature extends BaseFeature
{
    private $offset;

    private $limit;

    public function __construct($language, $offset, $limit)
    {
        parent::__construct($language);

        $this->offset = $offset;

        $this->limit = $limit;
    }

    public function handle(PostRepository $postRepository)
    {
        if ($this->language) {
            $collection = $postRepository->getByLanguage($this->language, $this->offset, $this->limit);
        } else {
            $collection = $postRepository->all($this->offset, $this->limit);
        }

        return GuestPostResource::collection($collection);
    }
}
