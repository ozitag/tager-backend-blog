<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;

class BlogCategory extends Model
{
    use SoftDeletes;

    public $timestamps = null;

    protected $table = 'tager_blog_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url_alias',
        'name',
        'page_title',
        'page_description',
        'open_graph_image_id',
        'priority',
        'language'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('priority', 'asc');
        });
    }

    public function openGraphImage()
    {
        return $this->belongsTo(File::class, 'open_graph_image_id');
    }

    public function posts()
    {
        return $this->belongsToMany(
            BlogPost::class,
            'tager_blog_post_categories',
            'category_id',
            'post_id'
        );
    }

    public function getUrlAttribute()
    {
        return (new TagerBlogUrlHelper())->getCategoryUrl($this);
    }

    public function getPostsCountAttribute()
    {
        return $this->posts->count();
    }
}
