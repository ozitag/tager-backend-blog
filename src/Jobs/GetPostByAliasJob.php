<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;

class GetPostByAliasJob extends Job
{
    /** @var integer */
    private $alias;

    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    public function handle(PostRepository $repository)
    {
        return $repository->getByAlias($this->alias);
    }
}
