<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Core\Repositories\IFilterable;
use OZiTAG\Tager\Backend\Core\Repositories\ISearchable;
use OZiTAG\Tager\Backend\Crud\Contracts\IRepositoryCrudTreeRepository;

class CategoryRepository extends EloquentRepository implements IRepositoryCrudTreeRepository, ISearchable, IFilterable
{
    public function __construct(BlogCategory $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $language
     * @return Collection
     */
    public function getByLanguage($language)
    {
        return $this->model->where('language', '=', $language)->get();
    }

    /**
     * @param string $alias
     * @param string|null $language
     * @return BlogCategory|null
     */
    public function getByAlias($alias, $language = null)
    {
        $alias = preg_replace('#\/+$#si', '', $alias);
        if (empty($alias)) {
            $alias = '/';
        }

        if (mb_substr($alias, 0, 1) !== '/') {
            $alias = '/' . $alias;
        }

        $alias = mb_substr($alias, 1);

        $query = $this->model::query()->whereUrlAlias($alias);

        if ($language) {
            $query = $query->whereLanguage($language);
        }

        return $query->first();
    }

    public function searchByQuery(?string $query, Builder $builder = null): ?Builder
    {
        $builder = $builder ? $builder : $this->model;

        return $builder->orWhere('name', 'LIKE', '%' . $query . '%');
    }

    public function filterByKey(Builder $builder, string $key, mixed $value): Builder
    {
        switch ($key) {
            case 'language':
                return $builder->whereIn('language', explode(',', $value));
            default:
                return $builder;
        }
    }
}
