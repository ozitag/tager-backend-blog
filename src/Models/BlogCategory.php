<?php

namespace OZiTAG\Tager\Backend\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Ozerich\FileStorage\Models\File;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogSeoHelper;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogUrlHelper;
use OZiTAG\Tager\Backend\Core\Models\Contracts\IPublicWebModel;
use OZiTAG\Tager\Backend\Core\Models\TModel;

/**
 * Class BlogCategory
 * @package OZiTAG\Tager\Backend\Blog\Models
 *
 * @property bool $is_default
 * @property string $url_alias
 * @property string $name
 * @property string $page_title
 * @property string $page_description
 * @property string $open_graph_image_id
 * @property string $language
 *
 * @property File $openGraphImage
 */
class BlogCategory extends TModel implements IPublicWebModel
{
    use NodeTrait;

    use SoftDeletes;

    public $timestamps = null;

    protected $table = 'tager_blog_categories';

    static string $defaultOrder = 'language asc';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'is_default',
        'url_alias',
        'name',
        'page_title',
        'page_description',
        'open_graph_image_id',
        'language'
    ];

    public function openGraphImage()
    {
        return $this->belongsTo(File::class, 'open_graph_image_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (self $category) {
            $category->openGraphImage()->delete();
        });
    }

    public function posts()
    {
        return $this->belongsToMany(
            BlogPost::class,
            'tager_blog_post_categories',
            'category_id',
            'post_id'
        );
    }

    private function recPostsCount(self $category): int
    {
        $result = $category->posts->count();

        foreach ($category->children as $child) {
            $result = $result + $this->recPostsCount($child);
        }

        return $result;
    }

    public function getPostsCountAttribute()
    {
        return $this->recPostsCount($this);
    }

    public function getWebPageUrl(): string
    {
        return (new TagerBlogUrlHelper())->getCategoryUrl($this);
    }

    public function getWebPageTitle(): string
    {
        return (new TagerBlogSeoHelper())->getCategoryTitle($this);
    }

    public function getWebPageDescription(): ?string
    {
        return (new TagerBlogSeoHelper())->getCategoryDescription($this);
    }

    public function getWebOpenGraphImageUrl(): ?string
    {
        return $this->openGraphImage?->getFullJson();
    }

    public function getPanelType(): ?string
    {
        return __('tager-blog::panel.category');
    }

    public function getPanelTitle(): ?string
    {
        return $this->name;
    }
}
