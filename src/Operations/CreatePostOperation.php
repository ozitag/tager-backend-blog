<?php

namespace OZiTAG\Tager\Backend\Blog\Operations;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostSamePostsJob;
use OZiTAG\Tager\Backend\Blog\Utils\TagerBlogConfig;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Blog\Jobs\GetPostUrlAliasJob;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostCategoriesJob;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Requests\CreateBlogPostRequest;
use OZiTAG\Tager\Backend\Blog\Resources\Admin\AdminPostResource;
use OZiTAG\Tager\Backend\Core\Jobs\Operation;

class CreatePostOperation extends Operation
{
    private $request;

    public function __construct(CreateBlogPostRequest $request)
    {
        $this->request = $request;
    }

    public function handle(PostRepository $postRepository, Storage $fileStorage)
    {
        $request = $this->request;

        $alias = $this->run(GetPostUrlAliasJob::class, [
            'name' => $request->title,
            'language' => $request->language
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
            'language' => $request->language
        ]);

        $this->run(SetPostCategoriesJob::class, [
            'post' => $model,
            'categoryIds' => $request->categories
        ]);

        $this->run(SetPostSamePostsJob::class, [
            'post' => $model,
            'samePostIds' => $request->samePosts
        ]);

        return $model;
    }
}
