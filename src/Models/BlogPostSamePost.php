<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogSeoHelper;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;

class BlogPostSamePost extends Model
{
    public $timestamps = false;
    
    protected $table = 'tager_blog_post_same_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'same_post_id'
    ];

    public function post()
    {
        return $this->belongsTo(self::class, 'post_id');
    }

    public function samePost()
    {
        return $this->belongsTo(self::class, 'same_post_id');
    }
}
