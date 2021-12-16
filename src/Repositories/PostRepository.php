<?php

namespace OZiTAG\Tager\Backend\Blog\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use OZiTAG\Tager\Backend\Blog\Enums\BlogPostStatus;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Blog\Models\BlogTag;
use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Core\Repositories\IFilterable;
use OZiTAG\Tager\Backend\Core\Repositories\ISearchable;

class PostRepository extends EloquentRepository implements ISearchable, IFilterable
{
    public function __construct(BlogPost $model)
    {
        parent::__construct($model);
    }

    private function queryByStatus(BlogPostStatus $blogPostStatus): Builder
    {
        return $this->builder()->where('status', $blogPostStatus->value);
    }

    public function queryPublished(): Builder
    {
        return $this->queryByStatus(BlogPostStatus::Published);
    }

    public function queryArchived(): Builder
    {
        return $this->queryByStatus(BlogPostStatus::Archived);
    }

    public function queryDraft(): Builder
    {
        return $this->queryByStatus(BlogPostStatus::Draft);
    }

    public function queryByIds(array $ids): Builder
    {
        return $this->queryPublished()->whereIn('id', $ids);
    }

    public function getByIds(array $ids): Collection
    {
        return $this->queryByIds($ids)->get();
    }

    public function queryByLanguage(string $language, int $offset = 0, ?int $limit = null): Builder
    {
        return $this->queryPublished()
            ->where('language', '=', $language)
            ->skip($offset)->take($limit);
    }

    public function getByLanguage(string $language, int $offset = 0, ?int $limit = null): Collection
    {
        return $this->queryByLanguage($language, $offset, $limit)->get();
    }

    public function getPostsCount(?string $language = null): int
    {
        $query = $this->model::query();

        if ($language) {
            $query->where('language', '=', $language);
        }

        return $query->count();
    }

    public function all(int $offset = 0, ?int $limit = null): Collection
    {
        $query = $this->queryPublished();

        if ($offset) $query->skip($offset);

        if ($limit) $query->take($limit);

        return $query->get();
    }

    public function queryByAlias(string $alias, ?string $language = null): Builder
    {
        $query = $this->queryPublished()->whereUrlAlias($alias);

        if ($language) {
            $query->whereLanguage($language);
        }

        return $query;
    }

    public function getByAlias($alias, $language = null): BlogPost
    {
        return $this->queryByAlias($alias, $language)->first();
    }

    public function queryByCategoryId(int $id, int $offset, ?int $limit): Builder
    {
        $query = $this->queryPublished()->skip($offset)->take($limit);

        $query->join('tager_blog_post_categories', 'post_id', '=', 'tager_blog_posts.id');
        $query->where('tager_blog_post_categories.category_id', $id);

        return $query->orderBy('datetime', 'desc');
    }

    public function findByCategoryId(int $id, int $offset = 0, ?int $limit = null): Collection
    {
        return $this->queryByCategoryId($id, $offset, $limit)->get();
    }

    public function queryByCategoryIds(array $ids, int $offset, ?int $limit): Builder
    {
        $query = $this->queryPublished()->skip($offset)->take($limit);

        $query->join('tager_blog_post_categories', 'post_id', '=', 'tager_blog_posts.id');
        $query->whereIn('tager_blog_post_categories.category_id', $ids);

        return $query->orderBy('datetime', 'desc');
    }

    public function findByCategoryIds(array $ids, $offset = 0, $limit = null): Collection
    {
        return $this->queryByCategoryIds($ids, $offset, $limit)->get();
    }

    public function queryByTag(int $tagId, ?string $language = null, int $offset = 0, ?int $limit = null): Builder
    {
        $query = $this->queryPublished()->skip($offset)->take($limit);

        if ($language) {
            $query->whereLanguage($language);
        }

        $query->join('tager_blog_post_tags', 'post_id', '=', 'tager_blog_posts.id');
        $query->where('tager_blog_post_tags.tag_id', '=', $tagId);

        return $query;
    }

    public function getByTag(BlogTag $tag, $language = null, $offset = 0, $limit = null): Collection
    {
        return $this->queryByTag($tag->id, $language, $offset, $limit)->get();
    }

    public function search($searchQuery, $language = null, $offset = 0, $limit = null): Collection
    {
        $query = $this->queryPublished()->orderBy('datetime', 'desc');

        if ($offset !== null) {
            $query->skip($offset);
            $query->take(999999999);
        }

        if ($limit !== null) {
            $query->take($limit);
        }

        if ($language) {
            $query->where('language', '=', $language);
        }

        $query->where('title', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('excerpt', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('body', 'LIKE', '%' . $searchQuery . '%');

        return $query->get();
    }

    public function searchByQuery(?string $query, Builder $builder = null): ?Builder
    {
        $builder = $builder ? $builder : $this->model;

        return $builder
            ->orWhere('title', 'LIKE', '%' . $query . '%')
            ->orWhere('url_alias', 'LIKE', '%' . $query . '%');
    }

    public function filterByKey(Builder $builder, string $key, mixed $value): Builder
    {
        switch ($key) {
            case 'language':
                return $builder->whereIn('language', explode(',', $value));
            case 'status':
                return $builder->whereIn('status', explode(',', $value));
            case 'category':
                return $builder
                    ->join('tager_blog_post_categories', 'tager_blog_post_categories.post_id', '=', 'tager_blog_posts.id')
                    ->whereIn('tager_blog_post_categories.category_id', explode(',', $value));
            case 'from-date':
                return $builder->where('datetime', '>=', $value);
            case 'to-date':
                return $builder->where('datetime', '<=', $value);
            default:
                return $builder;
        }
    }
}
