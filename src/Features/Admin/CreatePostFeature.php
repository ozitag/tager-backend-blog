<?php

namespace OZiTAG\Tager\Backend\Blog\Features\Admin;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetPostUrlAliasJob;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostCategoriesJob;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogPostRequest;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminPostResource;

class CreatePostFeature extends Feature
{
    public function handle(CreateBlogPostRequest $request, PostRepository $postRepository, Storage $fileStorage)
    {
        $alias = $this->run(GetPostUrlAliasJob::class, [
            'name' => $request->title
        ]);

        if ($request->image) {
            $fileStorage->setFileScenario($request->image, TagerBlogConfig::getPostImageScenario());
        }

        if ($request->coverImage) {
            $fileStorage->setFileScenario($request->coverImage, TagerBlogConfig::getPostCoverScenario());
        }

        if ($request->openGraphImage) {
            $fileStorage->setFileScenario($request->openGraphImage, TagerBlogConfig::getOpenGraphScenario());
        }

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
            'categoryIds' => $request->categories
        ]);

        return new AdminPostResource($model);
    }
}
