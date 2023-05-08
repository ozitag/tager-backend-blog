<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPostRelatedPost extends Model
{
    public $timestamps = false;

    protected $table = 'tager_blog_post_related_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'related_post_id'
    ];

    public function post()
    {
        return $this->belongsTo(self::class, 'post_id');
    }

    public function relatedPost()
    {
        return $this->belongsTo(self::class, 'related_post_id');
    }
}
