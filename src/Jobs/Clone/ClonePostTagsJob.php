<?php

namespace OZiTAG\Tager\Backend\Blog\Jobs\Clone;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Blog\Models\BlogPost;
use OZiTAG\Tager\Backend\Blog\Repositories\PostCategoryRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostRepository;
use OZiTAG\Tager\Backend\Blog\Repositories\PostTagRepository;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Blog\Repositories\CategoryRepository;
use OZiTAG\Tager\Backend\Pages\Models\TagerPage;

class ClonePostTagsJob extends Job
{
    protected BlogPost $source;
    protected BlogPost $dest;

    public function __construct(BlogPost $source, BlogPost $dest)
    {
        $this->source = $source;

        $this->dest = $dest;
    }

    public function handle(PostTagRepository $postTagRepository)
    {
        foreach ($this->source->tags as $tag) {
            $postTagRepository->create([
                'post_id' => $this->dest->id,
                'tag_id' => $tag->id
            ]);
        }
    }
}
