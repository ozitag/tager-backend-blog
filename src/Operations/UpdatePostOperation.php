<?php

namespace OZiTAG\Tager\Backend\Blog\Operations;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Requests\UpdateBlogPostRequest;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetPostByIdJob;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostCategoriesJob;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminPostResource;
use OZiTAG\Tager\Backend\Core\Jobs\Operation;

class UpdatePostOperation extends Operation
{
    private $id;

    private $request;

    public function __construct(BlogPost $model, UpdateBlogPostRequest $request)
    {
        $this->model = $model;

        $this->request = $request;
    }

    public function handle(UpdateBlogPostRequest $request, Storage $fileStorage)
    {
        $model = $this->model;
        $request = $this->request;

        if (TagerBlogConfig::isMultiLang()) {
            $model->language = $request->language;
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

        return $model;
    }
}
