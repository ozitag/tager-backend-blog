<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $table = 'tager_blog_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'url_alias',
        'excerpt',
        'body',
        'date',
        'cover_image_id',
        'image_id',
        'status',
        'page_title',
        'page_description',
        'open_graph_image_id',
        'language'
    ];

    public function coverImage()
    {
        return $this->belongsTo(File::class, 'cover_image_id');
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function openGraphImage()
    {
        return $this->belongsTo(File::class, 'open_graph_image_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            BlogCategory::class,
            'tager_blog_post_categories',
            'post_id',
            'category_id'
        );
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('date', 'desc')->get();
    }

    public function getUrlAttribute()
    {
        return (new TagerBlogUrlHelper())->getPostUrl($this);
    }
}
