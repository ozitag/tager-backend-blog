<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Jobs\GetPriorityForNewCategoryJob;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminCategoryFullResource;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminFullCategoryResource;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryUrlAliasJob;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminCategoryResource;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogCategoryRequest;

class CreateCategoryFeature extends Feature
{
    public function handle(CreateBlogCategoryRequest $request, CategoryRepository $categoryRepository, Storage $fileStorage)
    {
        $alias = $this->run(GetCategoryUrlAliasJob::class, [
            'name' => $request->name,
            'language' => $request->language,
        ]);

        if ($request->openGraphImage) {
            $fileStorage->setFileScenario($request->openGraphImage, TagerBlogConfig::getOpenGraphScenario());
        }

        $maxPriority = $this->run(GetPriorityForNewCategoryJob::class, [
            'language' => TagerBlogConfig::isMultiLang() ? $request->language : null
        ]);

        $fields = [
            'name' => $request->name,
            'url_alias' => $alias,
            'page_title' => $request->pageTitle,
            'page_description' => $request->pageDescription,
            'open_graph_image_id' => $request->openGraphImage,
            'priority' => $maxPriority
        ];

        if (TagerBlogConfig::isMultiLang()) {
            $fields['language'] = $request->language;
        }

        $model = $categoryRepository->create($fields);

        return new AdminCategoryFullResource($model);
    }
}
