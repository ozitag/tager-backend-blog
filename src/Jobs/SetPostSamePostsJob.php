<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs;

use OZiTAG\Tager\Backend\Blog\Repositories\PostSamePostRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostCategoryRepository;

class SetPostSamePostsJob extends Job
{
    private $post;

    private $samePostIds;

    public function __construct(BlogPost $post, $samePostIds)
    {
        $this->post = $post;
        $this->samePostIds = $samePostIds;
    }

    public function handle(PostSamePostRepository $postSamePostRepository)
    {
        $postSamePostRepository->deleteByPostId($this->post->id);

        foreach ($this->samePostIds as $samePostId) {
            $postSamePostRepository->create([
                'post_id' => $this->post->id,
                'same_post_id' => $samePostId
            ]);
        }
    }
}
