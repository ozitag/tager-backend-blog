<?php

namespace OZiTAG\Tager\Backend\Blog\Operations;

use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Jobs\Clone\CloneBasicPostJob;
use OZiTAG\Tager\Backend\Blog\Jobs\Clone\ClonePostCategoriesJob;
use OZiTAG\Tager\Backend\Blog\Jobs\Clone\ClonePostRelatedJob;
use OZiTAG\Tager\Backend\Blog\Jobs\Clone\ClonePostTagsJob;
use OZiTAG\Tager\Backend\Blog\Jobs\Clone\GetUrlForNewPostJob;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class ClonePostOperation extends Job
{
    protected BlogPost $model;

    public function __construct(BlogPost $model)
    {
        $this->model = $model;
    }

    public function handle(PostRepository $repository)
    {
        $urlAlias = $this->run(GetUrlForNewPostJob::class, [
            'currentUrl' => $this->model->url_alias,
            'language' => $this->model->language
        ]);

        $post = $this->run(CloneBasicPostJob::class, [
            'model' => $this->model,
            'newUrl' => $urlAlias
        ]);

        $this->run(ClonePostCategoriesJob::class, [
            'source' => $this->model,
            'dest' => $post
        ]);

        $this->run(ClonePostTagsJob::class, [
            'source' => $this->model,
            'dest' => $post
        ]);

        $this->run(ClonePostRelatedJob::class, [
            'source' => $this->model,
            'dest' => $post
        ]);

        return $post;
    }
}
