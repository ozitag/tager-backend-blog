<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;

class GetCategoryByIdJob
{
    /** @var integer */
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle(CategoryRepository $repository)
    {
        return $repository->find($this->id);
    }
}
