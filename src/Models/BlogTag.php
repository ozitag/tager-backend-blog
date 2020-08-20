<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogSeoHelper;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;

class BlogTag extends Model
{
    public $timestamps = false;

    protected $table = 'tager_blog_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag'
    ];
}
