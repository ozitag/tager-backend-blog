<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Requests\UpdateBlogPostRequest;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetPostByIdJob;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostCategoriesJob;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminPostResource;


class UpdatePostFeature extends Feature
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle(UpdateBlogPostRequest $request, Storage $fileStorage)
    {
        $model = $this->run(GetPostByIdJob::class, [
            'id' => $this->id
        ]);

        if (!$model) {
            abort(404, 'Post not found');
        }

        if ($request->image) {
            $fileStorage->setFileScenario($request->image, TagerBlogConfig::getPostImageScenario());
        }

        if ($request->coverImage) {
            $fileStorage->setFileScenario($request->coverImage, TagerBlogConfig::getPostCoverScenario());
        }

        if ($request->openGraphImage) {
            $fileStorage->setFileScenario($request->openGraphImage, TagerBlogConfig::getOpenGraphScenario());
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
            'categoryIds' => $request->categories
        ]);

        return new AdminPostResource($model);
    }
}
