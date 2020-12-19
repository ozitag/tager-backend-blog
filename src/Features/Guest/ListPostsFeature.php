<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;

class ListPostsFeature extends BaseFeature
{
    private $offset;

    private $limit;

    private $ids;

    public function __construct($language, $offset, $limit, $ids)
    {
        if ($ids === null) {
            parent::__construct($language);
        }

        $this->offset = $offset;

        $this->limit = $limit;

        $this->ids = $ids;
    }

    public function handle(PostRepository $postRepository)
    {
        if ($this->ids !== null) {
            $collection = $postRepository->getByIds($this->ids);
        } else {
            if ($this->language) {
                $collection = $postRepository->getByLanguage($this->language, $this->offset, $this->limit);
            } else {
                $collection = $postRepository->all($this->offset, $this->limit);
            }
        }

        $resourceClass = TagerBlogConfig::getShortResourceClass();
        if (!empty($resourceClass)) {
            return call_user_func($resourceClass . '::collection', $collection);
        } else {
            return GuestPostResource::collection($collection);
        }
    }
}
