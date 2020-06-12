<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Blog\Jobs\GetPostByIdJob;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostCategoriesJob;
use OZiTAG\Tager\Backend\Blog\Resources\AdminPostResource;
use OZiTAG\Tager\Backend\Core\Feature;

class UpdatePostFeature extends Feature
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        $model = $this->run(GetPostByIdJob::class, [
            'id' => $this->id
        ]);

        if (!$model) {
            abort(404, 'Post not found');
        }

        $model->title = $request->title;
        $model->url_alias = $request->urlAlias;
        $model->excerpt = $request->excerpt;
        $model->body = $request->body;
        $model->date = $request->date;
        $model->image_id = $request->image;
        $model->cover_image_id = $request->coverImage;
        $model->status = $request->status;
        $model->page_title = $request->pageTitle;
        $model->page_description = $request->pageDescription;
        $model->open_graph_image_id = $request->openGraphImage;
        $model->save();

        $this->run(SetPostCategoriesJob::class, [
            'post' => $model,
            'categoryIds' => $request->categoryIds
        ]);

        return new AdminPostResource($model);
    }
}
