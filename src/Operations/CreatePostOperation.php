<?php

namespace OZiTAG\Tager\Backend\Blog\Operations;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Enums\BlogPostStatus;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostAdditionalFieldsJob;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostRelatedPostsJob;
use OZiTAG\Tager\Backend\Blog\Jobs\SetPostTagsJob;
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

    public function handle(PostRepository $postRepository)
    {
        $request = $this->request;

        $model = $postRepository->create([
            'title' => $request->title,
            'url_alias' => $request->urlAlias,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'datetime' => $request->datetime,
            'image_id' => Storage::fromUUIDtoId($request->image),
            'mobile_image_id' => Storage::fromUUIDtoId($request->imageMobile),
            'cover_image_id' => Storage::fromUUIDtoId($request->coverImage),
            'status' => $request->status,
            'page_title' => $request->pageTitle,
            'page_description' => $request->pageDescription,
            'open_graph_image_id' => Storage::fromUUIDtoId($request->openGraphImage),
            'language' => $request->language,
            'publish_at' => $request->status == BlogPostStatus::Draft ? $request->publishAt : null,
            'archive_at' => $request->status == BlogPostStatus::Published ? $request->archiveAt : null,
        ]);

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
