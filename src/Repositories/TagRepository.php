<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use Illuminate\Support\Collection;
use OZiTAG\Tager\Backend\Blog\Models\BlogTag;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Crud\Contracts\IRepositoryWithPriorityMethods;
use OZiTAG\Tager\Backend\Crud\Traits\RepositoryPriorityMethodsTrait;

class TagRepository extends EloquentRepository
{
    public function __construct(BlogTag $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $tag
     * @return BlogTag
     */
    public function getByTag($tag)
    {
        return $this->model::query()->whereTag($tag)->first();
    }
}
