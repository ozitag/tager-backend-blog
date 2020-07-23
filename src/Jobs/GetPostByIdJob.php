<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;

class GetPostByIdJob extends Job
{
    /** @var integer */
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle(PostRepository $repository)
    {
        return $repository->find($this->id);
    }
}
