<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Ozerich\FileStorage\Models\File;

class TagerBlogPostCategory extends Model
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
        return $this->hasOne(TagerBlogCategory::class, 'category_id');
    }

    public function post()
    {
        return $this->hasOne(TagerBlogPost::class, 'post_id');
    }
}
