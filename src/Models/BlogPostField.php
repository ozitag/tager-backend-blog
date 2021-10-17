<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $post_id
 * @property string $field
 * @property string $value
 */
class BlogPostField extends Model
{
    public $timestamps = false;

    protected $table = 'tager_blog_post_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'field',
        'value'
    ];

    public function post()
    {
        return $this->hasOne(BlogPost::class, 'post_id');
    }
}
