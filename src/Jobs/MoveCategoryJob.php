<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogPostCategory;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class MoveCategoryJob extends Job
{
    /** @var BlogPostCategory */
    private $model;

    /** @var string */
    private $direction;

    public function __construct(BlogCategory $model, $direction)
    {
        $this->model = $model;

        $this->direction = $direction;
    }

    public function handle(CategoryRepository $categoryRepository)
    {
        if ($this->direction == 'up') {
            $other = $categoryRepository->findFirstWithLowerPriorityThan($this->model->priority, $this->model->language);
        } else {
            $other = $categoryRepository->findFirstWithHigherPriorityThan($this->model->priority, $this->model->language);
        }

        if (!$other) {
            return;
        }

        $a = $other->priority;
        $other->priority = $this->model->priority;
        $this->model->priority = $a;

        $this->model->save();
        $other->save();
    }
}
