<?php

namespace OZiTAG\Tager\Backend\Blog\Operations;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Models\BlogCategory;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Core\Jobs\Operation;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryUrlAliasJob;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogCategoryRequest;

class CreateCategoryOperation extends Operation
{
    private $request;

    public function __construct(CreateBlogCategoryRequest $request)
    {
        $this->request = $request;
    }

    public function handle(CategoryRepository $categoryRepository, Storage $fileStorage)
    {
        $request = $this->request;

        $fields = [
            'name' => $request->name,
            'is_default' => $request->isDefault,
            'url_alias' => $request->urlAlias,
            'page_title' => $request->pageTitle,
            'page_description' => $request->pageDescription,
            'open_graph_image_id' => $request->openGraphImage,
        ];

        if (TagerBlogConfig::isMultiLang()) {
            $fields['language'] = $request->language;
        }

        /** @var BlogCategory $model */
        $model = $categoryRepository->create($fields);

        $model->parent_id = $request->parent;
        $model->save();

        return $model;
    }
}
