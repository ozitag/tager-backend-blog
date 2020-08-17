<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;

class PostRepository extends EloquentRepository
{
    public function __construct(BlogPost $model)
    {
        parent::__construct($model);
    }

    /**
     * Returns all the records.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->ordered()->all();
    }

    public function getByAlias($alias, $language = null)
    {
        $query = $this->model->query();

        if ($language) {
            $query->whereLanguage($language);
        }

        return $query->first();
    }

    public function findByCategoryId($id)
    {
        $repository = new CategoryRepository(new BlogCategory());
        $model = $repository->find($id);

        return $model->posts()->orderBy('date', 'desc')->get();
    }
}
