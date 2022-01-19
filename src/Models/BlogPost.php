<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogSeoHelper;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;
use OZiTAG\Tager\Backend\Core\Models\Contracts\IPublicWebModel;
use OZiTAG\Tager\Backend\Core\Models\TModel;
use OZiTAG\Tager\Backend\Fields\FieldFactory;

/**
 * Class BlogPost
 * @package OZiTAG\Tager\Backend\Blog\Models
 *
 * @property int $id
 * @property string $title
 * @property string $url_alias
 * @property string $excerpt
 * @property string $body
 * @property string $datetime
 * @property integer $cover_image_id
 * @property integer $image_id
 * @property integer $mobile_image_id
 * @property string $status
 * @property string $archive_at
 * @property string $publish_at
 * @property string $page_title
 * @property string $page_description
 * @property integer $open_graph_image_id
 * @property string $language
 *
 * @property File $image
 * @property File $imageMobile
 * @property File $coverImage
 * @property File $openGraphImage
 * @property BlogPostField[] $fields
 */
class BlogPost extends TModel implements IPublicWebModel
{
    use SoftDeletes;

    protected $table = 'tager_blog_posts';

    static $defaultOrder = 'datetime desc';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_boolean',
        'title',
        'url_alias',
        'excerpt',
        'body',
        'datetime',
        'cover_image_id',
        'image_id',
        'mobile_image_id',
        'status', 'archive_at', 'publish_at',
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

    public function imageMobile()
    {
        return $this->belongsTo(File::class, 'mobile_image_id');
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

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (self $post) {
            $post->image()->delete();
            $post->coverImage()->delete();
            $post->openGraphImage()->delete();
        });
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

    public function getWebPageUrl(): string
    {
        return (new TagerBlogUrlHelper())->getPostUrl($this);
    }

    public function getWebPageTitle(): string
    {
        return (new TagerBlogSeoHelper())->getPostTitle($this);
    }

    public function getWebPageDescription(): ?string
    {
        return (new TagerBlogSeoHelper())->getPostDescription($this);
    }

    public function getWebOpenGraphImageUrl(): ?string
    {
        return $this->openGraphImage ? $this->openGraphImage->getUrl() : (
            $this->image ? $this->image->getUrl() : (
                $this->coverImage ? $this->coverImage->getUrl() : (
                    $this->imageMobile ? $this->imageMobile->getUrl() : null
                )
            )
        );
    }

    public function getPanelType(): ?string
    {
        return __('tager-blog::panel.post');
    }

    public function getPanelTitle(): ?string
    {
        return $this->title;
    }
}
