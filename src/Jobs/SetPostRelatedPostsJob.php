<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Blog\Repositories\PostRelatedPostRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostCategoryRepository;

class SetPostRelatedPostsJob extends Job
{
    private $post;

    private $relatedPostIds;

    public function __construct(BlogPost $post, $relatedPostIds)
    {
        $this->post = $post;
        $this->relatedPostIds = $relatedPostIds;
    }

    public function handle(PostRelatedPostRepository $postRelatedPostRepository)
    {
        $postRelatedPostRepository->deleteByPostId($this->post->id);

        foreach ($this->relatedPostIds as $relatedPostId) {
            $postRelatedPostRepository->create([
                'post_id' => $this->post->id,
                'related_post_id' => $relatedPostId
            ]);
        }
    }
}
