<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostFullResource;

class ViewPostFeature extends Feature
{
    private $alias;

    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    public function handle(PostRepository $postRepository)
    {
        $model = $postRepository->getByAlias($this->alias);
        if (!$model) {
            abort(404, 'Post Not Found');
        }

        return new GuestPostFullResource($model);
    }
}
