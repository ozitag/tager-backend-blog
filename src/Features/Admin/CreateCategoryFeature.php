<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Jobs\GetPriorityForNewCategoryJob;
use OZiTAG\Tager\Backend\Blog\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryUrlAliasJob;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminCategoryResource;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogCategoryRequest;

class CreateCategoryFeature extends Feature
{
    public function handle(CreateBlogCategoryRequest $request, CategoryRepository $categoryRepository, Storage $fileStorage)
    {
        $alias = $this->run(GetCategoryUrlAliasJob::class, [
            'name' => $request->name
        ]);

        if ($request->openGraphImage) {
            $fileStorage->setFileScenario($request->openGraphImage, TagerBlogConfig::getOpenGraphScenario());
        }

        $maxPriority = $this->run(GetPriorityForNewCategoryJob::class);

        $model = $categoryRepository->create([
            'name' => $request->name,
            'url_alias' => $alias,
            'page_title' => $request->pageTitle,
            'page_description' => $request->pageDescription,
            'open_graph_image_id' => $request->openGraphImage,
            'priority' => $maxPriority + 1
        ]);

        return new AdminCategoryResource($model);
    }
}
