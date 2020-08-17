<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class GetPriorityForNewCategoryJob extends Job
{
    private $language = null;

    public function __construct($language = null)
    {
        $this->language = $language;
    }

    public function handle(CategoryRepository $repository)
    {
        $model = $repository->findItemWithMaxPriority($this->language);

        return $model ? $model->priority + 1 : 1;
    }
}
