<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Blog\Jobs\GetCategoryByIdJob;
use OZiTAG\Tager\Backend\Blog\Requests\UpdateBlogCategoryRequest;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminCategoryResource;
use OZiTAG\Tager\Backend\Core\Feature;

class UpdateCategoryFeature extends Feature
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle(UpdateBlogCategoryRequest $request)
    {
        $model = $this->run(GetCategoryByIdJob::class, ['id' => $this->id]);
        if (!$model) {
            abort(404, 'Category not found');
        }

        $model->name = $request->name;
        $model->url_alias = $request->urlAlias;
        $model->page_title = $request->pageTitle;
        $model->page_description = $request->pageDescription;
        $model->open_graph_image_id = $request->openGraphImage;
        $model->save();

        return new AdminCategoryResource($model);
    }
}
