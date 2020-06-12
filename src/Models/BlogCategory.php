<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Ozerich\FileStorage\Models\File;

class BlogCategory extends Model
{
    protected $table = 'tager_blog_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url_alias',
        'name',
        'page_title',
        'page_description',
        'open_graph_image_id',
    ];

    public function openGraphImage()
    {
        return $this->hasOne(File::class, 'open_graph_image_id');
    }
}
