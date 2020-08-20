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

    /**
     * @param $language
     * @return Collection
     */
    public function getByLanguage($language)
    {
        return $this->model->where('language', '=', $language)->get();
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
        $query = $this->model::query()->whereUrlAlias($alias);

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

    public function getByTag(BlogTag $tag, $language = null)
    {
        $query = $this->model::query();

        if ($language) {
            $query->whereLanguage($language);
        }

        $query->join('tager_blog_post_tags', 'post_id', '=', 'tager_blog_posts.id');
        $query->where('tager_blog_post_tags.tag_id', '=', $tag->id);

        return $query->get();
    }
}
