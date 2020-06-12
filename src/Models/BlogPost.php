<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Ozerich\FileStorage\Models\File;

class BlogPost extends Model
{
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
    ];

    public function coverImage()
    {
        return $this->hasOne(File::class, 'cover_image_id');
    }

    public function image()
    {
        return $this->hasOne(File::class, 'image_id');
    }

    public function openGraphImage()
    {
        return $this->hasOne(File::class, 'open_graph_image_id');
    }
}
