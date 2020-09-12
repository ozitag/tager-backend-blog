<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogTag;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;

class PostRepository extends EloquentRepository
{
    public function __construct(BlogPost $model)
    {
        parent::__construct($model);
    }

    public function getByIds($ids)
    {
        if (empty($ids)) {
            return [];
        }

        return $this->model->ordered()->whereIn('id', $ids)->all();
    }

    /**
     * @param $language
     * @param integer $offset
     * @param integer $limit
     * @return Collection
     */
    public function getByLanguage($language, $offset = 0, $limit = null)
    {
        return $this->model->ordered()->where('language', '=', $language)->skip($offset)->take($limit)->all();
    }

    /**
     * Returns all the records.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($offset = 0, $limit = null)
    {
        return $this->model->ordered()->skip($offset)->take($limit)->all();
    }

    public function getByAlias($alias, $language = null)
    {
        $query = $this->model::query()->whereUrlAlias($alias);

        if ($language) {
            $query->whereLanguage($language);
        }

        return $query->first();
    }

    public function findByCategoryId($id, $offset = 0, $limit = null)
    {
        $repository = new CategoryRepository(new BlogCategory());
        $model = $repository->find($id);

        return $model->posts()->skip($offset)->take($limit)->orderBy('date', 'desc')->get();
    }

    public function getByTag(BlogTag $tag, $language = null, $offset = 0, $limit = null)
    {
        $query = $this->model::query()->skip($offset)->take($limit);

        if ($language) {
            $query->whereLanguage($language);
        }

        $query->join('tager_blog_post_tags', 'post_id', '=', 'tager_blog_posts.id');
        $query->where('tager_blog_post_tags.tag_id', '=', $tag->id);

        return $query->get();
    }

    public function search($searchQuery, $language = null, $offset = 0, $limit = null)
    {
        $query = $this->model::query()->orderBy('date', 'desc')->skip($offset)->take($limit);

        if ($language) {
            $query->where('language', '=', $language);
        }

        $query->where('title', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('excerpt', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('body', 'LIKE', '%' . $searchQuery . '%');

        return $query->get();
    }
}
