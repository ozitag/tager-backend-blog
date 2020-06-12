<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Ozerich\FileStorage\Models\File;

class BlogPostCategory extends Model
{
    protected $table = 'tager_blog_post_categorids';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'post_id',
    ];

    public function category()
    {
        return $this->hasOne(BlogCategory::class, 'category_id');
    }

    public function post()
    {
        return $this->hasOne(BlogPost::class, 'post_id');
    }
}
