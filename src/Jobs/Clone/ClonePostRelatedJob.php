<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs\Clone;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostCategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRelatedPostRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Pages\Models\TagerPage;

class ClonePostRelatedJob extends Job
{
    protected BlogPost $source;

    protected BlogPost $dest;

    public function __construct(BlogPost $source, BlogPost $dest)
    {
        $this->source = $source;

        $this->dest = $dest;
    }

    public function handle(PostRelatedPostRepository $postRelatedPostRepository)
    {
        foreach ($this->source->relatedPosts as $relatedPost) {
            $postRelatedPostRepository->create([
                'post_id' => $this->dest->id,
                'related_post_id' => $relatedPost->id
            ]);
        }
    }
}
