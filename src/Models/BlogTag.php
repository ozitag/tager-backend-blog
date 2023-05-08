<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $tag
 * @property string $url_alias
 */
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
        'tag', 'url_alias'
    ];
}
