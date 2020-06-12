<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use OZiTAG\Tager\Backend\Blog\Jobs\GetPostUrlAliasJob;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostCategoriesJob;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogPostRequest;
use OZiTAG\Tager\Backend\Blog\Resources\AdminPostResource;
use OZiTAG\Tager\Backend\Core\Feature;

class CreatePostFeature extends Feature
{
    public function handle(CreateBlogPostRequest $request, PostRepository $postRepository)
    {
        $alias = $this->run(GetPostUrlAliasJob::class, [
            'name' => $request->title
        ]);

        $model = $postRepository->create([
            'title' => $request->title,
            'url_alias' => $alias,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'date' => $request->date,
            'image_id' => $request->image,
            'cover_image_id' => $request->coverImage,
            'status' => $request->status,
            'page_title' => $request->pageTitle,
            'page_description' => $request->pageDescription,
            'open_graph_image_id' => $request->openGraphImage,
        ]);

        $this->run(SetPostCategoriesJob::class, [
            'post' => $model,
            'categoryIds' => $request->categoryIds
        ]);

        return new AdminPostResource($model);
    }
}
