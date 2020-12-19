<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostFullResource;

class ViewPostFeature extends BaseFeature
{
    private $alias;

    public function __construct($alias, $language)
    {
        parent::__construct($language);

        $this->alias = $alias;
    }

    public function handle(PostRepository $postRepository)
    {
        $model = $postRepository->getByAlias($this->alias, $this->language);

        if (!$model) {
            abort(404, 'Post Not Found');
        }


        $resourceClass = TagerBlogConfig::getFullResourceClass();
        if (!empty($resourceClass)) {
            return new $resourceClass($model);
        } else {
            return new GuestPostFullResource($model);
        }
    }
}
