<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogSeoHelper;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;
use OZiTAG\Tager\Backend\Core\Models\TModel;
use OZiTAG\Tager\Backend\Crud\Contracts\IModelPriorityConditional;

class BlogCategory extends TModel implements IModelPriorityConditional
{
    use SoftDeletes;

    public $timestamps = null;

    protected $table = 'tager_blog_categories';

    static $defaultOrder = 'language asc, priority asc';

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

    public function getPriorityConditionalAttributes()
    {
        return [
            'language'
        ];
    }

    public function getPublicPageTitleAttribute()
    {
        return (new TagerBlogSeoHelper())->getCategoryTitle($this);
    }

    public function getPublicPageDescriptionAttribute()
    {
        return (new TagerBlogSeoHelper())->getCategoryDescription($this);
    }
}
