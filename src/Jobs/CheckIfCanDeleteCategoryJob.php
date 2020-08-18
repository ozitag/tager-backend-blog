<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Core\Jobs\Job;

class CheckIfCanDeleteCategoryJob extends Job
{
    private $model;

    public function __construct(BlogCategory $model)
    {
        $this->model = $model;
    }

    public function handle()
    {
        if ($this->model->posts->isEmpty() == false) {
            return 'It is not available to remove category with posts';
        }

        return true;
    }
}
