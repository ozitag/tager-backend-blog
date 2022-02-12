<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;

class SearchPostsFeature extends BaseFeature
{
    private $query;

    private $offset;

    private $limit;

    public function __construct($language, $query, $offset, $limit)
    {
        parent::__construct($language);

        $this->query = $query;

        $this->offset = $offset;

        $this->limit = $limit;
    }

    public function handle(PostRepository $postRepository)
    {
        $collection = $postRepository->search($this->query, $this->language, $this->offset, $this->limit);

        $resourceClass = TagerBlogConfig::getShortResourceClass();
        if (!empty($resourceClass)) {
            return call_user_func($resourceClass . '::collection', $collection);
        } else {
            return GuestPostResource::collection($collection);
        }
    }
}
