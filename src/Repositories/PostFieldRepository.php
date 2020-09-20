<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use Illuminate\Support\Collection;
use OZiTAG\Tager\Backend\Blog\Models\BlogPostField;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Crud\Contracts\IRepositoryWithPriorityMethods;
use OZiTAG\Tager\Backend\Crud\Traits\RepositoryPriorityMethodsTrait;

class PostFieldRepository extends EloquentRepository implements IRepositoryWithPriorityMethods
{
    use RepositoryPriorityMethodsTrait;

    public function __construct(BlogPostField $model)
    {
        parent::__construct($model);
    }

    public function deleteByPostId($postId)
    {
        return $this->model::query()->wherePostId($postId)->delete();
    }

    public function getByPostIdAndField($postId, $field)
    {
        return $this->model::query()->wherePostId($postId)->whereField($field)->first();
    }
}
