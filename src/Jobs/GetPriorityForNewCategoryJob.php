<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class GetPriorityForNewCategoryJob
{
    public function handle(CategoryRepository $repository)
    {
        $model = $repository->findItemWithMaxPriority();
        return $model ? $model->priority : 1;
    }
}
