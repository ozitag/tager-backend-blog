<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPostTag extends Model
{
    public $timestamps = false;

    protected $table = 'tager_blog_post_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag_id',
        'post_id',
    ];

    public function tag()
    {
        return $this->hasOne(BlogTag::class, 'tag_id');
    }

    public function post()
    {
        return $this->hasOne(BlogPost::class, 'post_id');
    }
}
