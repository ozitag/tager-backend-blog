<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class GetCategoryByAliasJob
{
    /** @var integer */
    private $alias;

    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    public function handle(CategoryRepository $repository)
    {
        return $repository->getByAlias($this->alias);
    }
}
