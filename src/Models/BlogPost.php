<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogSeoHelper;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;
use OZiTAG\Tager\Backend\Core\Models\TModel;
use OZiTAG\Tager\Backend\Fields\FieldFactory;

class BlogPost extends TModel
{
    use SoftDeletes;

    protected $table = 'tager_blog_posts';

    static $defaultOrder = 'date desc';

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
        'language'
    ];

    public function coverImage()
    {
        return $this->belongsTo(File::class, 'cover_image_id');
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function openGraphImage()
    {
        return $this->belongsTo(File::class, 'open_graph_image_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            BlogCategory::class,
            'tager_blog_post_categories',
            'post_id',
            'category_id'
        );
    }

    public function relatedPosts()
    {
        return $this->belongsToMany(
            static::class,
            'tager_blog_post_related_posts',
            'post_id',
            'related_post_id'
        );
    }

    public function fields()
    {
        return $this->hasMany(BlogPostField::class, 'post_id');
    }

    public function postTags()
    {
        return $this->hasMany(BlogPostTag::class, 'post_id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            BlogTag::class,
            'tager_blog_post_tags',
            'post_id',
            'tag_id'
        );
    }

    public function getUrlAttribute()
    {
        return (new TagerBlogUrlHelper())->getPostUrl($this);
    }

    public function getPublicPageTitleAttribute()
    {
        return (new TagerBlogSeoHelper())->getPostTitle($this);
    }

    public function getPublicPageDescriptionAttribute()
    {
        return (new TagerBlogSeoHelper())->getPostDescription($this);
    }

    public function getTagsArrayAttribute()
    {
        return array_map(function ($item) {
            return $item['tag'];
        }, $this->tags->toArray());
    }

    public function getAdditionalFieldsAttribute()
    {
        $result = [];

        foreach ($this->fields as $field) {
            $fieldConfig = TagerBlogConfig::getPostAdditionalField($field->field);
            if (!$fieldConfig) {
                continue;
            }

            $fieldModel = FieldFactory::create($fieldConfig['type'], $fieldConfig['label'], $fieldConfig['meta'] ?? null);
            $fieldModel->setName($field->field);
            $type = $fieldModel->getTypeInstance();
            $type->loadValueFromDatabase($field->value);

            $result[] = [
                'name' => $fieldModel->getName(),
                'value' => $type->getAdminFullJson()
            ];
        }

        return $result;
    }
}
