<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Blog\Enums\BlogPostStatus;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class PublishPostJob extends Job
{
    protected BlogPost $model;

    public function __construct(BlogPost $model)
    {
        $this->model = $model;
    }

    public function handle(PostRepository $repository)
    {
        $repository->set($this->model)->fillAndSave([
            'status' => BlogPostStatus::Published,
            'publish_at' => null
        ]);
    }
}
