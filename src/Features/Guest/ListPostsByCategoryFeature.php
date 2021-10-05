<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use OZiTAG\Tager\Backend\Blog\Jobs\GetChildrenIdsForCategoryJob;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostFullResource;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;

class ListPostsByCategoryFeature extends Feature
{
    private $id;

    private $offset;

    private $limit;

    public function __construct($id, $offset, $limit)
    {
        $this->id = $id;

        $this->offset = $offset;

        $this->limit = $limit;
    }


    public function handle(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        $model = $categoryRepository->find($this->id);
        if (!$model) {
            abort(404, 'Category Not Found');
        }

        $childrenIds = $this->run(GetChildrenIdsForCategoryJob::class, [
            'category' => $model
        ]);

        $ids = array_merge([$model->id], $childrenIds);

        $collection = $postRepository->findByCategoryIds($ids, $this->offset, $this->limit);

        $resourceClass = TagerBlogConfig::getShortResourceClass();
        if (!empty($resourceClass)) {
            return call_user_func($resourceClass . '::collection', $collection);
        } else {
            return GuestPostResource::collection($collection);
        }
    }
}
