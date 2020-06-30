<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;

class CategoryRepository extends EloquentRepository
{
    public function __construct(BlogCategory $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $alias
     * @return BlogCategory|null
     */
    public function getByAlias($alias)
    {
        return BlogCategory::whereUrlAlias($alias)->first();
    }

    /**
     * @param integer $priority
     * @return BlogCategory|null
     */
    public function findFirstWithLowerPriorityThan($priority)
    {
        return BlogCategory::where('priority', '<', $priority)->orderBy('priority', 'desc')->first();
    }

    /**
     * @param integer $priority
     * @return BlogCategory|null
     */
    public function findFirstWithHigherPriorityThan($priority)
    {
        return BlogCategory::where('priority', '>', $priority)->orderBy('priority', 'asc')->first();
    }
}
