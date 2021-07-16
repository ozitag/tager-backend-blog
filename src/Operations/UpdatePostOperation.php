<?php

namespace OZiTAG\Tager\Backend\Blog\Operations;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostAdditionalFieldsJob;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostRelatedPostsJob;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostTagsJob;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Requests\UpdateBlogPostRequest;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostCategoriesJob;
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
        $model->cover_image_id = Storage::fromUUIDtoId($request->coverImage);
        $model->image_id = Storage::fromUUIDtoId($request->image);
        $model->image_mobile_id = Storage::fromUUIDtoId($request->imageMobile);
        $model->status = $request->status;
        $model->page_title = $request->pageTitle;
        $model->page_description = $request->pageDescription;
        $model->open_graph_image_id = Storage::fromUUIDtoId($request->openGraphImage);
        $model->save();

        $this->run(SetPostCategoriesJob::class, [
            'post' => $model,
            'categoryIds' => $request->categories
        ]);

        $this->run(SetPostRelatedPostsJob::class, [
            'post' => $model,
            'relatedPostIds' => $request->relatedPosts
        ]);

        $this->run(SetPostTagsJob::class, [
            'post' => $model,
            'tags' => $request->tags
        ]);

        $this->run(SetPostAdditionalFieldsJob::class, [
            'post' => $model,
            'fields' => $request->additionalFields
        ]);

        return $model;
    }
}
