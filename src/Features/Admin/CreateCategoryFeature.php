<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryUrlAliasJob;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminCategoryResource;
use OZiTAG\Tager\Backend\Core\Feature;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogCategoryRequest;

class CreateCategoryFeature extends Feature
{
    public function handle(CreateBlogCategoryRequest $request, CategoryRepository $categoryRepository)
    {
        $alias = $this->run(GetCategoryUrlAliasJob::class, [
            'name' => $request->name
        ]);

        $model = $categoryRepository->create([
            'name' => $request->name,
            'url_alias' => $alias,
            'page_title' => $request->pageTitle,
            'page_description' => $request->pageDescription,
            'open_graph_image_id' => $request->openGraphImage
        ]);

        return new AdminCategoryResource($model);
    }
}
