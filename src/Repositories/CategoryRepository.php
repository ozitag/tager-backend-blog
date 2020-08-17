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

    public function all()
    {
        return $this->model->query()->orderBy('language', 'asc')->get();
    }

    /**
     * @param string $alias
     * @param string|null $language
     * @return BlogCategory|null
     */
    public function getByAlias($alias, $language = null)
    {
        $query = $this->model::query()->whereUrlAlias($alias);

        if ($language) {
            $query = $query->whereLanguage($language);
        }

        return $query->first();
    }

    /**
     * @param string|null $language
     * @return BlogCategory|null
     */
    public function findItemWithMaxPriority($language = null)
    {
        $query = $this->model->query();

        if ($language) {
            $query = $query->whereLanguage($language);
        }

        return $query->orderBy('priority', 'desc')->first();
    }


    /**
     * @param integer $priority
     * @return BlogCategory|null
     */
    public function findFirstWithLowerPriorityThan($priority, $language)
    {
        $query = $this->model->query();

        if ($language) {
            $query = $query->whereLanguage($language);
        }

        return $query->where('priority', '<', $priority)->orderBy('priority', 'desc')->first();
    }

    /**
     * @param integer $priority
     * @return BlogCategory|null
     */
    public function findFirstWithHigherPriorityThan($priority, $language)
    {
        $query = $this->model->query();

        if ($language) {
            $query = $query->whereLanguage($language);
        }

        return $query->where('priority', '>', $priority)->orderBy('priority', 'asc')->first();
    }
}
