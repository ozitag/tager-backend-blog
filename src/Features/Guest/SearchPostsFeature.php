<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Guest;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Blog\Fields\BlogModuleSettingField;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestPostResource;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Guest\GuestCategoryResource;
use OZiTAG\Tager\Backend\Fields\Enums\FieldType;
use OZiTAG\Tager\Backend\ModuleSettings\ModuleSettings;

class SearchPostsFeature extends BaseFeature
{
    private $query;

    private $offset;

    private $limit;

    public function __construct($language, $query, $offset, $limit)
    {
        parent::__construct($language);

        $this->query = $query;

        $this->offset = $offset;

        $this->limit = $limit;
    }

    public function handle(PostRepository $postRepository)
    {
        $collection = $postRepository->search($this->query, $this->language, $this->offset, $this->limit);


        $resourceClass = TagerBlogConfig::getShortResourceClass();
        if (!empty($resourceClass)) {
            return call_user_func($resourceClass . '::collection', $collection);
        } else {
            return GuestPostResource::collection($collection);
        }
    }
}
