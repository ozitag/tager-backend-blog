<?php

namespace OZiTAG\Tager\Backend\Blog\Operations;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Jobs\GetPriorityForNewCategoryJob;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryByIdJob;
use OZiTAG\Tager\Backend\Blog\Requests\UpdateBlogCategoryRequest;
use OZiTAG\Tager\Backend\Core\Jobs\Operation;

class UpdateCategoryOperation extends Operation
{
    private $model;

    private $request;

    public function __construct(BlogCategory $model, UpdateBlogCategoryRequest $request)
    {
        $this->model = $model;

        $this->request = $request;
    }

    public function handle(Storage $fileStorage)
    {
        $model = $this->model;
        $request = $this->request;

        $model->name = $request->name;
        $model->parent_id = $request->parent;
        $model->is_default = $request->isDefault;
        $model->url_alias = $request->urlAlias;
        $model->page_title = $request->pageTitle;
        $model->page_description = $request->pageDescription;
        $model->open_graph_image_id = $request->openGraphImage;

        if (TagerBlogConfig::isMultiLang()) {
            $model->language = $request->language;
        } else {
            $model->language = null;
        }

        $model->save();

        return $model;
    }
}
