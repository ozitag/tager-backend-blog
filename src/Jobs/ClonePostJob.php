<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class ClonePostJob extends Job
{
    protected BlogPost $model;

    public function __construct(BlogPost $model)
    {
        $this->model = $model;
    }

    public function handle(PostRepository $repository)
    {
        $ind = 0;
        while (true) {
            $url = $this->model->url_alias . '-copy';
            if ($ind > 0) {
                $url .= '-' . $ind;
            }

            if ($repository->getByAlias($url, $this->model->language) === null) {
                break;
            }

            $ind = $ind + 1;
        }

        return $this->model;
    }
}
